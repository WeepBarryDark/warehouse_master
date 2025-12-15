<?php

namespace App\Enums;

enum UserRole: string
{
    case VIP = 'vip';
    case COMMERCIAL_PARTNER = 'commercial_partner';
    case SHOP_MANAGER = 'shop_manager';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    /**
     * Get all role values.
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Get the display name for the role.
     */
    public function label(): string
    {
        return match($this) {
            self::VIP => 'VIP',
            self::COMMERCIAL_PARTNER => 'Commercial Partner',
            self::SHOP_MANAGER => 'Shop Manager',
            self::ADMIN => 'Admin',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }

    /**
     * Get the permissions for this role.
     */
    public function permissions(): array
    {
        return match($this) {
            self::VIP => [
                'message_center',
                'account',
                'settings',
            ],
            self::COMMERCIAL_PARTNER => [
                'message_center',
                'account',
                'settings',
            ],
            self::SHOP_MANAGER => [
                'message_center',
                'account',
                'transaction_management',
                'settings',
            ],
            self::ADMIN => [
                'message_center',
                'account',
                'transaction_management',
                'warehouse_management',
                'document',
                'settings',
            ],
            self::SUPER_ADMIN => [
                'message_center',
                'account',
                'transaction_management',
                'warehouse_management',
                'document',
                'settings',
                'laravel_system_access',
            ],
        };
    }

    /**
     * Check if this role has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }

    /**
     * Get roles that have access to a specific permission.
     */
    public static function withPermission(string $permission): array
    {
        return array_filter(self::cases(), fn($role) => $role->hasPermission($permission));
    }
}