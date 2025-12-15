# Multi-Client System Documentation

## Overview

This document explains the complete redesign of the User-Client relationship from a **one-to-many** to a **many-to-many** architecture. This allows:

- **One user to belong to multiple clients** with different roles and permissions in each
- **One client to have multiple users** with varying access levels
- **Context switching** between clients for users with multi-client access
- **Role-based permissions** that vary per client context

---

## Table of Contents

1. [Architecture](#architecture)
2. [Database Schema](#database-schema)
3. [Models & Relationships](#models--relationships)
4. [Test Users & Clients](#test-users--clients)
5. [Usage Examples](#usage-examples)
6. [Migration Guide](#migration-guide)
7. [API Reference](#api-reference)

---

## Architecture

### Before (One-to-Many)

```
User ─┐
      ├─── belongs to ONE ───> Client
User ─┘
```

**Problems:**
- Users could only access one client
- No way to share users across organizations
- Users needed separate accounts for multiple clients

### After (Many-to-Many)

```
User ─┐
      ├───┐
User ─┤   ├─── belong to MANY ───> Clients
      ├───┘
User ─┘

Client ─┐
        ├───┐
Client ─┤   ├─── has MANY ───> Users (with different roles)
        ├───┘
Client ─┘
```

**Benefits:**
- Single account for multiple organizations
- Different roles per client (e.g., Admin in ACME, VIP in TechCorp)
- Granular permissions per client relationship
- Easy client switching without re-authentication

---

## Database Schema

### 1. Pivot Table: `client_user`

Manages the many-to-many relationship with additional context.

```sql
CREATE TABLE client_user (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    client_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,

    -- Role in this specific client (can differ per client)
    role VARCHAR(255) DEFAULT 'vip',

    -- Custom permissions for this client (overrides role defaults)
    permissions JSON NULL,

    -- Is this the user's default/primary client?
    is_primary BOOLEAN DEFAULT FALSE,

    -- Is this relationship active?
    is_active BOOLEAN DEFAULT TRUE,

    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    UNIQUE KEY unique_user_client (client_id, user_id),
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Key Fields:**
- `role`: User's role in THIS client (super_admin, admin, shop_manager, commercial_partner, vip)
- `permissions`: Custom permissions array for THIS client
- `is_primary`: User's default client (shown on login)
- `is_active`: Can temporarily disable user access to specific client

### 2. Users Table Addition

```sql
ALTER TABLE users ADD COLUMN current_client_id BIGINT NULL;
ALTER TABLE users ADD FOREIGN KEY (current_client_id) REFERENCES clients(id);
```

**Purpose:**
- Tracks which client the user is currently viewing/working with
- Enables client switching without re-authentication
- Used by middleware to enforce client-specific permissions

---

## Models & Relationships

### User Model (`app/Models/User.php`)

#### New Relationships

```php
// Many-to-Many: Get all clients user belongs to
public function clients(): BelongsToMany
{
    return $this->belongsToMany(Client::class, 'client_user')
        ->withPivot(['role', 'permissions', 'is_primary', 'is_active'])
        ->withTimestamps()
        ->wherePivot('is_active', true);
}

// Get current client context
public function currentClient(): BelongsTo
{
    return $this->belongsTo(Client::class, 'current_client_id');
}

// Get user's primary client
public function primaryClient()
{
    return $this->clients()->wherePivot('is_primary', true)->first();
}
```

#### New Methods

```php
// Switch client context
public function switchClient(int $clientId): bool
{
    if (!$this->clients()->where('clients.id', $clientId)->exists()) {
        return false; // User doesn't have access
    }

    $this->update(['current_client_id' => $clientId]);
    return true;
}

// Get role for current client
public function getCurrentRole(): ?UserRole
{
    $pivot = $this->clients()
        ->where('clients.id', $this->current_client_id)
        ->first()?->pivot;

    return $pivot ? UserRole::from($pivot->role) : $this->role;
}

// Get permissions for current client
public function getCurrentPermissions(): array
{
    $pivot = $this->clients()
        ->where('clients.id', $this->current_client_id)
        ->first()?->pivot;

    return $pivot?->permissions ?? $this->permissions ?? [];
}
```

#### Updated Permission Checks

All permission checks now use **current client context**:

```php
public function hasPermission(string $permission): bool
{
    // Check current client's custom permissions
    if (in_array($permission, $this->getCurrentPermissions())) {
        return true;
    }

    // Check current client's role permissions
    return $this->getCurrentRole()?->hasPermission($permission) ?? false;
}
```

### Client Model (`app/Models/Client.php`)

#### New Relationships

```php
// Many-to-Many: Get all users who are members
public function members(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'client_user')
        ->withPivot(['role', 'permissions', 'is_primary', 'is_active'])
        ->withTimestamps()
        ->wherePivot('is_active', true);
}

// Get members with specific role
public function membersWithRole(string $role): BelongsToMany
{
    return $this->members()->wherePivot('role', $role);
}
```

---

## Test Users & Clients

### Created Clients

All test clients are automatically created with sample data:

| Client Name | Code | Description |
|------------|------|-------------|
| **ACME Corporation** | ACME | Global manufacturing and distribution company |
| **TechCorp Solutions** | TECHCORP | Technology solutions provider |
| **GlobalTrade Logistics** | GLOBALTRADE | International logistics and supply chain management |

### Created Users

All users have the same password: **`qweasdzxc123`**

#### 1. Super Admin Example
- **Email:** `super_admin@example.com`
- **Primary Client:** ACME Corporation
- **Access:**
  - ACME: `super_admin` role
  - TechCorp: `super_admin` role
  - GlobalTrade: `super_admin` role

#### 2. Admin Example
- **Email:** `admin@example.com`
- **Primary Client:** ACME Corporation
- **Access:**
  - ACME: `admin` role
  - TechCorp: `shop_manager` role

#### 3. Supervisor Example
- **Email:** `supervisor@example.com`
- **Primary Client:** TechCorp Solutions
- **Access:**
  - TechCorp: `admin` role
  - GlobalTrade: `shop_manager` role

#### 4. Shop Manager Example
- **Email:** `shop_manager@example.com`
- **Primary Client:** ACME Corporation
- **Access:**
  - ACME: `shop_manager` role
  - GlobalTrade: `commercial_partner` role

#### 5. Shopper Example
- **Email:** `shopper@example.com`
- **Primary Client:** TechCorp Solutions
- **Access:**
  - TechCorp: `commercial_partner` role
  - ACME: `vip` role

#### 6. VIP Shopper Example
- **Email:** `vip_shopper@example.com`
- **Primary Client:** GlobalTrade Logistics
- **Access:**
  - GlobalTrade: `vip` role
  - TechCorp: `vip` role

---

## Usage Examples

### Example 1: User with Different Roles

**Scenario:** Admin Example works as Admin for ACME but only Shop Manager for TechCorp.

```php
$user = User::where('email', 'admin@example.com')->first();

// Switch to ACME
$user->switchClient($acmeClient->id);
$user->getCurrentRole(); // Returns: UserRole::ADMIN
$user->hasPermission('warehouse_management'); // Returns: true

// Switch to TechCorp
$user->switchClient($techCorpClient->id);
$user->getCurrentRole(); // Returns: UserRole::SHOP_MANAGER
$user->hasPermission('warehouse_management'); // Returns: false
```

### Example 2: Query Users by Client

```php
// Get all members of ACME
$acmeMembers = Client::where('code', 'ACME')->first()->members;

// Get all admins in TechCorp
$techCorpAdmins = Client::where('code', 'TECHCORP')
    ->first()
    ->membersWithRole('admin');
```

### Example 3: Check User Access to Client

```php
$user = auth()->user();

// Check if user has access to specific client
if ($user->clients()->where('clients.id', $clientId)->exists()) {
    // User can access this client
    $user->switchClient($clientId);
}
```

### Example 4: Attach User to New Client

```php
$user = User::find(1);
$client = Client::find(2);

// Attach user to client with specific role
$user->clients()->attach($client->id, [
    'role' => 'shop_manager',
    'permissions' => ['inventory_management', 'transaction_management'],
    'is_primary' => false,
    'is_active' => true,
]);
```

---

## Migration Guide

### Running the Migrations

```bash
# Fresh migrate (WARNING: Deletes all data)
php artisan migrate:fresh

# Run the seeder
php artisan db:seed --class=TestUsersAndClientsSeeder
```

### Manual Migration Steps

If you have existing users:

```php
// Step 1: Migrate existing users to pivot table
$users = User::all();
foreach ($users as $user) {
    if ($user->client_id) {
        $user->clients()->attach($user->client_id, [
            'role' => $user->role,
            'permissions' => $user->permissions,
            'is_primary' => true,
            'is_active' => true,
        ]);

        $user->update(['current_client_id' => $user->client_id]);
    }
}

// Step 2: (Optional) Remove old client_id column
// Only after verifying all data migrated correctly
// Schema::table('users', function (Blueprint $table) {
//     $table->dropForeign(['client_id']);
//     $table->dropColumn('client_id');
// });
```

---

## API Reference

### User Model Methods

#### Relationship Methods

| Method | Return Type | Description |
|--------|------------|-------------|
| `clients()` | BelongsToMany | All clients user belongs to |
| `currentClient()` | BelongsTo | Currently selected client |
| `primaryClient()` | Client\|null | User's primary/default client |

#### Client Management

| Method | Parameters | Return | Description |
|--------|-----------|--------|-------------|
| `switchClient()` | int $clientId | bool | Switch to different client context |
| `getCurrentRole()` | - | UserRole\|null | Get role in current client |
| `getCurrentPermissions()` | - | array | Get permissions in current client |

#### Permission Checks (Context-Aware)

| Method | Parameters | Return | Description |
|--------|-----------|--------|-------------|
| `hasPermission()` | string $permission | bool | Check permission in current client |
| `hasAnyPermission()` | array $permissions | bool | Check if has any permission |
| `hasAllPermissions()` | array $permissions | bool | Check if has all permissions |
| `hasRole()` | UserRole $role | bool | Check role in current client |

### Client Model Methods

#### Relationship Methods

| Method | Return Type | Description |
|--------|------------|-------------|
| `members()` | BelongsToMany | All active users in this client |
| `activeMembers()` | BelongsToMany | All active members |
| `membersWithRole()` | BelongsToMany | Members with specific role |

---

## Role-Based Access Control (RBAC)

### Roles Hierarchy

From highest to lowest privilege:

1. **super_admin** - Full system access, all clients
2. **admin** - Warehouse management + transactions
3. **shop_manager** - Transaction management only
4. **commercial_partner** - Account + messaging
5. **vip** - Basic account + messaging

### Permissions by Role

| Permission | VIP | Commercial | Shop Manager | Admin | Super Admin |
|-----------|-----|-----------|-------------|--------|------------|
| message_center | ✅ | ✅ | ✅ | ✅ | ✅ |
| account | ✅ | ✅ | ✅ | ✅ | ✅ |
| settings | ✅ | ✅ | ✅ | ✅ | ✅ |
| transaction_management | ❌ | ❌ | ✅ | ✅ | ✅ |
| warehouse_management | ❌ | ❌ | ❌ | ✅ | ✅ |
| document | ❌ | ❌ | ❌ | ✅ | ✅ |
| laravel_system_access | ❌ | ❌ | ❌ | ❌ | ✅ |

**Note:** Permissions can be different for the same user across different clients.

---

## Important Considerations

### 1. Backward Compatibility

The system maintains backward compatibility:
- Old `client_id` column still exists (deprecated)
- Old `role` column still exists (used as default)
- Old `client()` relationship still works

### 2. Current Client Context

All permission checks use `current_client_id`:
- Middleware checks permissions for current client
- Role may differ per client
- Users must select a client before accessing restricted areas

### 3. Primary Client

Each user should have exactly ONE primary client:
- Used as default on login
- Can be changed by user
- Ensures users always have a starting context

### 4. Super Admin Privileges

Super Admins have special treatment:
- Can access ALL clients without explicit assignment
- Bypass most middleware checks
- Used for system administration

---

## Testing

### Login Test

```bash
# Use any test account
Email: admin@example.com
Password: qweasdzxc123
```

### Verify Multi-Client Access

```php
$user = User::where('email', 'admin@example.com')->first();

// Should return 2 clients
dd($user->clients()->get());

// Should return ACME (primary)
dd($user->currentClient);

// Should be 'admin'
dd($user->getCurrentRole());
```

### Test Client Switching

```php
$user = auth()->user();

// Get all accessible clients
$clients = $user->clients;

// Switch to second client
$user->switchClient($clients[1]->id);

// Role should change
dd($user->getCurrentRole());
```

---

## Future Enhancements

### Planned Features

1. **Client Switcher UI Component**
   - Dropdown in navbar to switch clients
   - Show current client name/logo
   - Quick access to all user's clients

2. **Client Invitations**
   - Invite existing users to join client
   - Email-based invitation system
   - Pending invitations management

3. **Audit Trail**
   - Track which client user was in during actions
   - Log client switches
   - Export activity reports per client

4. **WordPress Integration**
   - Sync clients from WordPress
   - Auto-create clients from WP organizations
   - SSO with WordPress accounts

---

## Troubleshooting

### Issue: User has no current_client_id

**Solution:**
```php
// Set to primary client
$user->update([
    'current_client_id' => $user->primaryClient()?->id
]);
```

### Issue: Permission checks failing

**Cause:** User's `current_client_id` not set

**Solution:**
```php
// Always ensure current_client_id is set
if (!$user->current_client_id && $user->clients()->exists()) {
    $user->switchClient($user->primaryClient()->id);
}
```

### Issue: User attached to client but can't access

**Check:**
1. Is `is_active` = true in pivot table?
2. Is client's `is_active` = true?
3. Is user's `is_active` = true?
4. Does role have required permissions?

---

## Database Queries for Debugging

```sql
-- See all user-client relationships
SELECT
    u.name AS user_name,
    u.email,
    c.name AS client_name,
    cu.role,
    cu.is_primary,
    cu.is_active
FROM users u
JOIN client_user cu ON u.id = cu.user_id
JOIN clients c ON c.id = cu.client_id
ORDER BY u.name, cu.is_primary DESC;

-- Find users with access to multiple clients
SELECT
    u.name,
    COUNT(cu.client_id) AS client_count
FROM users u
JOIN client_user cu ON u.id = cu.user_id
GROUP BY u.id
HAVING client_count > 1;

-- Find clients with most users
SELECT
    c.name,
    COUNT(cu.user_id) AS user_count
FROM clients c
JOIN client_user cu ON c.id = cu.client_id
GROUP BY c.id
ORDER BY user_count DESC;
```

---

## Summary

This multi-client system provides:

✅ **Flexibility:** One user, multiple organizations
✅ **Security:** Different roles/permissions per client
✅ **Scalability:** Easy to add more clients/users
✅ **User Experience:** No need for multiple accounts
✅ **Control:** Granular permissions per relationship

**Next Steps:**
1. Implement client switcher UI
2. Add client management dashboard
3. Integrate with WordPress (if needed)
4. Add invitation system

---

**Document Version:** 1.0
**Last Updated:** 2025-12-15
**Author:** System Architect
