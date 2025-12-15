# Multi-Client System - Quick Reference

## Test User Credentials

**Password for all users:** `qweasdzxc123`

### Users & Access

| User | Email | Primary Client | Secondary Access |
|------|-------|---------------|-----------------|
| **Super Admin** | super_admin@example.com | ACME (super_admin) | TechCorp (super_admin), GlobalTrade (super_admin) |
| **Admin** | admin@example.com | ACME (admin) | TechCorp (shop_manager) |
| **Supervisor** | supervisor@example.com | TechCorp (admin) | GlobalTrade (shop_manager) |
| **Shop Manager** | shop_manager@example.com | ACME (shop_manager) | GlobalTrade (commercial_partner) |
| **Shopper** | shopper@example.com | TechCorp (commercial_partner) | ACME (vip) |
| **VIP Shopper** | vip_shopper@example.com | GlobalTrade (vip) | TechCorp (vip) |

### Clients

| Client Name | Code | Description |
|------------|------|-------------|
| ACME Corporation | ACME | Global manufacturing and distribution company |
| TechCorp Solutions | TECHCORP | Technology solutions provider |
| GlobalTrade Logistics | GLOBALTRADE | International logistics and supply chain management |

---

## Key Features

### One User, Multiple Clients

Users can belong to multiple clients with different roles in each client:

```
Admin Example:
├─ ACME Corp → admin role (full warehouse access)
└─ TechCorp → shop_manager role (transaction management only)
```

### Context Switching

Users can switch between clients without re-login:

```php
$user->switchClient($clientId);
```

### Role-Based Permissions

Same user can have different permissions in different clients:

```php
// In ACME (admin role)
$user->hasPermission('warehouse_management'); // true

// Switch to TechCorp (shop_manager role)
$user->switchClient($techCorpId);
$user->hasPermission('warehouse_management'); // false
```

---

## Database Schema

### Pivot Table: `client_user`

```
client_id (FK) ─┐
user_id (FK)    ├─ Unique Together
role            │
permissions     │
is_primary      │
is_active       ─┘
```

### Users Table

```
users
├─ client_id (deprecated, keep for compatibility)
├─ current_client_id (NEW - tracks active client context)
├─ role (default role)
└─ ...
```

---

## Quick Commands

### Setup

```bash
# Run migrations
php artisan migrate:fresh

# Seed test data
php artisan db:seed --class=TestUsersAndClientsSeeder
```

### Testing

```bash
# Login with any test user
Email: admin@example.com
Password: qweasdzxc123

# Check user's clients
php artisan tinker
>>> $user = User::where('email', 'admin@example.com')->first();
>>> $user->clients; // Shows all accessible clients
>>> $user->getCurrentRole(); // Shows role in current client
```

---

## Common Code Patterns

### Check User Access to Client

```php
if ($user->clients()->where('clients.id', $clientId)->exists()) {
    $user->switchClient($clientId);
}
```

### Add User to Client

```php
$user->clients()->attach($clientId, [
    'role' => 'shop_manager',
    'permissions' => ['inventory_management'],
    'is_primary' => false,
    'is_active' => true,
]);
```

### Get All Users in a Client

```php
$client = Client::find($clientId);
$members = $client->members; // All active members
$admins = $client->membersWithRole('admin'); // Only admins
```

### Check Permission (Context-Aware)

```php
// Automatically uses current client context
if ($user->hasPermission('warehouse_management')) {
    // User has permission in CURRENT client
}
```

---

## Role Permissions Quick Reference

| Role | Permissions |
|------|------------|
| **vip** | message_center, account, settings |
| **commercial_partner** | + (same as vip) |
| **shop_manager** | + transaction_management |
| **admin** | + warehouse_management, document |
| **super_admin** | + laravel_system_access |

---

## Next Steps

1. ✅ Test login with any user
2. ✅ Verify multi-client access works
3. 📝 Build client switcher UI component
4. 📝 Add client management dashboard
5. 📝 Implement WordPress integration

---

## Documentation

📖 **Full Documentation:** See `MULTI_CLIENT_SYSTEM_DOCUMENTATION.md`

---

**Quick Reference Version:** 1.0
**Last Updated:** 2025-12-15
