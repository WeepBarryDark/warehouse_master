<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Super Admin (can access all clients)
            [
                'name' => 'Super Administrator',
                'email' => 'super@warehousemaster.com',
                'password' => 'password',
                'client_id' => null, // Super admin doesn't belong to a specific client
                'role' => 'super_admin',
                'is_active' => true,
            ],
            
            // ABC Logistics Users
            [
                'name' => 'John VIP',
                'email' => 'vip@abc-logistics.com',
                'password' => 'password',
                'client_id' => 1, // ABC Logistics
                'role' => 'vip',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Partner',
                'email' => 'partner@abc-logistics.com',
                'password' => 'password',
                'client_id' => 1,
                'role' => 'commercial_partner',
                'is_active' => true,
            ],
            [
                'name' => 'Mike Manager',
                'email' => 'manager@abc-logistics.com',
                'password' => 'password',
                'client_id' => 1,
                'role' => 'shop_manager',
                'is_active' => true,
            ],
            [
                'name' => 'Alice Admin',
                'email' => 'admin@abc-logistics.com',
                'password' => 'password',
                'client_id' => 1,
                'role' => 'admin',
                'is_active' => true,
            ],
            
            // Global Supply Chain Users
            [
                'name' => 'Bob Manager',
                'email' => 'manager@globalsupply.com',
                'password' => 'password',
                'client_id' => 2,
                'role' => 'shop_manager',
                'is_active' => true,
            ],
            [
                'name' => 'Carol Admin',
                'email' => 'admin@globalsupply.com',
                'password' => 'password',
                'client_id' => 2,
                'role' => 'admin',
                'is_active' => true,
            ],
            
            // Metro Warehouse Solutions Users
            [
                'name' => 'David VIP',
                'email' => 'vip@metrowarehouse.com',
                'password' => 'password',
                'client_id' => 3,
                'role' => 'vip',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($userData['password']),
                'client_id' => $userData['client_id'],
                'role' => $userData['role'],
                'is_active' => $userData['is_active'],
                'email_verified_at' => now(),
            ]);
        }
    }
}
