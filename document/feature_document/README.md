# Warehouse Master - Feature Documentation

This directory contains comprehensive documentation for all features and fixes applied to the Warehouse Master application.

## Quick Links

- [Quick Reference Guide](./QUICK_REFERENCE.md) - Test users, common patterns, and quick reference
- [Multi-Client System Documentation](./MULTI_CLIENT_SYSTEM_DOCUMENTATION.md) - Complete multi-client architecture guide
- [Codebase Analysis Report](./CODEBASE_REPORT.md) - Initial analysis and critical bug fixes
- [Internationalization Fixes](./I18N_FIX_SUMMARY.md) - i18n implementation for e-commerce pages
- [User Menu Fix](./USER_MENU_FIX.md) - Dropdown menu implementation and fixes

---

## Document Overview

### 📚 QUICK_REFERENCE.md
**Purpose:** Quick lookup for developers
**Contents:**
- Test user credentials (password: qweasdzxc123)
- Test client organizations
- Role permissions matrix
- Common code patterns
- Quick troubleshooting tips

**When to use:** Starting development, testing features, quick lookups

---

### 🏢 MULTI_CLIENT_SYSTEM_DOCUMENTATION.md
**Purpose:** Comprehensive multi-client architecture documentation
**Contents:**
- Database schema (many-to-many User-Client relationship)
- User roles and permissions system
- Client switching functionality
- API reference for all models
- Migration guide from single-client to multi-client
- Troubleshooting guide

**When to use:** Understanding multi-client system, implementing client-related features, troubleshooting access issues

**Key Features Documented:**
- One user can belong to multiple clients
- Multiple clients can have multiple users
- Different roles per client for same user
- Context switching between clients
- Role-based permission system (5 roles: super_admin, admin, shop_manager, commercial_partner, vip)

---

### 🔍 CODEBASE_REPORT.md
**Purpose:** Initial codebase analysis and critical bug fixes
**Contents:**
- Technology stack analysis (Laravel 12 + Vue 3 + Inertia.js + TypeScript)
- Architecture overview
- WordPress connection verification (confirmed: NO WordPress connection)
- Critical bug fix: Registration users missing client_id
- Middleware enhancements
- Authentication flow fixes

**When to use:** Understanding project architecture, onboarding new developers, reference for initial bugs fixed

**Critical Fix Applied:**
- Registration bug: New users weren't assigned client_id, blocking dashboard access
- Solution: Auto-create personal organization for each new user

---

### 🌐 I18N_FIX_SUMMARY.md
**Purpose:** Internationalization implementation guide
**Contents:**
- Vue i18n integration
- Fixed pages: Home.vue, Products.vue
- Implementation patterns for $t() function
- Translation key structure
- Remaining pages to fix (Pricing, About, Contact, Help, Cart)

**When to use:** Implementing i18n on new pages, troubleshooting language switching

**Supported Languages:**
- English (en) 🇺🇸
- Chinese Simplified (zh-CN) 🇨🇳

---

### 🎨 USER_MENU_FIX.md
**Purpose:** User dropdown menu implementation
**Contents:**
- Reka UI DropdownMenu component usage
- Fix for non-clickable menu items (as-child prop)
- Internationalization of menu items
- Cart icon functionality
- Testing procedures

**When to use:** Working with dropdown menus, troubleshooting UI component interactions

**Issue Fixed:**
- User avatar dropdown wasn't showing Dashboard, Profile, Logout options
- Menu items weren't clickable
- Missing internationalization

---

## Recent Updates

### Timezone Support (2025-12-15)
**Implementation:**
- All database times stored in UTC
- User-specific timezone preferences
- Default timezone: Australia/Sydney
- Timezone selector in settings

**Supported Timezones:**
- All Australia timezones (8): Sydney, Melbourne, Brisbane, Perth, Adelaide, Hobart, Darwin, Canberra
- New Zealand timezones (2): Auckland, Chatham Islands
- China timezones (2): Shanghai, Hong Kong
- UTC (reference)

**Files Modified:**
- `database/migrations/2025_12_15_113132_add_timezone_to_users_table.php`
- `app/Models/User.php` (added timezone to fillable)
- `resources/js/i18n/index.ts` (SUPPORTED_TIMEZONES)
- `resources/js/components/LanguageTimezoneSettings.vue` (timezone selector UI)
- `app/Http/Controllers/Settings/ProfileController.php` (updateTimezone method)
- `routes/settings.php` (timezone update route)

---

## Project Structure Reference

### Technology Stack
- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Vue 3 (Composition API) + TypeScript
- **Bridge:** Inertia.js 2.0
- **Styling:** Tailwind CSS 4.x
- **UI Components:** Reka UI (Headless components)
- **i18n:** Vue I18n
- **Database:** SQLite (configurable to MySQL/PostgreSQL)
- **Authentication:** Laravel Breeze (session-based)

### Key Directories
```
app/
├── Enums/UserRole.php          # Role definitions and permissions
├── Models/
│   ├── User.php                # User model with multi-client support
│   └── Client.php              # Client/Organization model
├── Http/
│   ├── Controllers/
│   │   ├── Auth/               # Authentication controllers
│   │   └── Settings/           # Settings controllers
│   └── Middleware/
│       ├── CheckUserRole.php   # Role-based access control
│       └── EnsureClientAccess.php  # Client isolation

resources/js/
├── components/
│   ├── LanguageTimezoneSettings.vue  # Language & timezone selector
│   └── EcommerceNavbar.vue     # Navigation with user menu
├── pages/
│   ├── ecommerce/              # E-commerce public pages
│   └── settings/               # Settings pages
└── i18n/
    ├── index.ts                # i18n configuration
    └── locales/                # Translation files

database/
├── migrations/                 # Database schema
└── seeders/
    └── TestUsersAndClientsSeeder.php  # Test data
```

---

## Test Data

### Test Users
All test users have password: `qweasdzxc123`

1. **super_admin@example.com** - Super Admin (access to all clients)
2. **admin@example.com** - Admin at ACME, Shop Manager at TechCorp
3. **supervisor@example.com** - Admin at TechCorp, Shop Manager at GlobalTrade
4. **shop_manager@example.com** - Shop Manager at ACME, Commercial Partner at GlobalTrade
5. **shopper@example.com** - Commercial Partner at TechCorp, VIP at ACME
6. **vip_shopper@example.com** - VIP at GlobalTrade and TechCorp

### Test Clients
1. **ACME Corporation** (ACME-2024)
2. **TechCorp Solutions** (TECH-2024)
3. **GlobalTrade Logistics** (GLOB-2024)

---

## Role Permissions Matrix

| Role | Message Center | Account | Transaction Mgmt | Warehouse Mgmt | Document | Settings | Laravel System |
|------|---------------|---------|------------------|----------------|----------|----------|---------------|
| VIP | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ |
| Commercial Partner | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ |
| Shop Manager | ✅ | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ |
| Admin | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Super Admin | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

---

## Getting Started

1. **New Developer Onboarding:**
   - Read [CODEBASE_REPORT.md](./CODEBASE_REPORT.md) for architecture overview
   - Check [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) for test credentials
   - Review [MULTI_CLIENT_SYSTEM_DOCUMENTATION.md](./MULTI_CLIENT_SYSTEM_DOCUMENTATION.md) for core system understanding

2. **Working with Multi-Client Features:**
   - Refer to [MULTI_CLIENT_SYSTEM_DOCUMENTATION.md](./MULTI_CLIENT_SYSTEM_DOCUMENTATION.md)
   - Use test users to test different role scenarios
   - Check permission methods in User model

3. **Implementing Internationalization:**
   - Follow patterns in [I18N_FIX_SUMMARY.md](./I18N_FIX_SUMMARY.md)
   - Use $t() function for all user-facing text
   - Convert static arrays to computed properties

4. **UI Component Development:**
   - Reference [USER_MENU_FIX.md](./USER_MENU_FIX.md) for Reka UI patterns
   - Always use `as-child` prop when wrapping interactive elements

---

## Common Development Tasks

### Switching User Context
```php
// In your controller
$user = Auth::user();
$user->switchClient($clientId);
```

### Checking Permissions
```php
// Check specific permission
if ($user->hasPermission('warehouse.manage')) {
    // User has permission
}

// Check role
if ($user->hasRole(UserRole::ADMIN)) {
    // User is admin in current client context
}

// Get current role (considers current client)
$role = $user->getCurrentRole();
```

### Adding New Translation
```typescript
// In your Vue component
import { useI18n } from 'vue-i18n'
const { t } = useI18n()

// In template
{{ $t('your.translation.key') }}

// In script
const message = t('your.translation.key')
```

### Updating User Timezone
```typescript
// Frontend
router.patch('/settings/timezone', {
  timezone: 'Australia/Sydney'
}, {
  preserveScroll: true,
  onSuccess: () => {
    window.location.reload()
  }
})
```

---

## Troubleshooting

### Common Issues

1. **User can't access dashboard after registration**
   - Fixed in [CODEBASE_REPORT.md](./CODEBASE_REPORT.md)
   - All new users now get auto-created organization

2. **Dropdown menu not working**
   - Fixed in [USER_MENU_FIX.md](./USER_MENU_FIX.md)
   - Check for `as-child` prop on DropdownMenuItem

3. **Language not switching**
   - See [I18N_FIX_SUMMARY.md](./I18N_FIX_SUMMARY.md)
   - Ensure all text uses $t() function

4. **Permission denied errors**
   - Check [MULTI_CLIENT_SYSTEM_DOCUMENTATION.md](./MULTI_CLIENT_SYSTEM_DOCUMENTATION.md)
   - Verify user's role in current client context
   - Check middleware on routes

---

## Documentation Updates

This documentation is actively maintained. Last updated: **2025-12-15**

**Changelog:**
- 2025-12-15: Added timezone support documentation
- 2025-12-15: Consolidated all feature documentation
- 2025-12-15: Created this README index
- 2025-12-15: Removed duplicate documentation (MULTI_CLIENT_IMPLEMENTATION.md, FIXES_APPLIED.md)
- 2025-12-15: Added multi-client system documentation
- 2025-12-15: Added i18n fixes documentation
- 2025-12-15: Added user menu fix documentation
- 2025-12-15: Initial codebase analysis and bug fixes

---

## Contributing to Documentation

When adding new features:
1. Update relevant existing documentation
2. Add entry to this README
3. Include code examples
4. Update changelog
5. Keep all comments in English

---

## Support

For questions about:
- **Architecture & Multi-Client System:** See MULTI_CLIENT_SYSTEM_DOCUMENTATION.md
- **Quick Reference:** See QUICK_REFERENCE.md
- **Specific Features:** Check individual feature documents above
- **Bug Reports:** Check CODEBASE_REPORT.md for known issues

---

*All documentation is maintained in English to ensure consistency across the development team.*
