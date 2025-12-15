<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersAndClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates test users with different roles and multiple test clients.
     * Each user is assigned to multiple clients with different roles.
     */
    public function run(): void
    {
        // Common password for all test users
        $password = Hash::make('qweasdzxc123');

        // Create test clients
        $acmeClient = Client::create([
            'name' => 'ACME Corporation',
            'code' => 'ACME',
            'description' => 'Global manufacturing and distribution company',
            'is_active' => true,
        ]);

        $techCorpClient = Client::create([
            'name' => 'TechCorp Solutions',
            'code' => 'TECHCORP',
            'description' => 'Technology solutions provider',
            'is_active' => true,
        ]);

        $globalTradeClient = Client::create([
            'name' => 'GlobalTrade Logistics',
            'code' => 'GLOBALTRADE',
            'description' => 'International logistics and supply chain management',
            'is_active' => true,
        ]);

        // Create users with different roles
        $users = [
            [
                'name' => 'Super Admin Example',
                'email' => 'super_admin@example.com',
                'default_role' => 'super_admin',
                'clients' => [
                    ['client' => $acmeClient, 'role' => 'super_admin', 'is_primary' => true],
                    ['client' => $techCorpClient, 'role' => 'super_admin', 'is_primary' => false],
                    ['client' => $globalTradeClient, 'role' => 'super_admin', 'is_primary' => false],
                ],
            ],
            [
                'name' => 'Admin Example',
                'email' => 'admin@example.com',
                'default_role' => 'admin',
                'clients' => [
                    ['client' => $acmeClient, 'role' => 'admin', 'is_primary' => true],
                    ['client' => $techCorpClient, 'role' => 'shop_manager', 'is_primary' => false],
                ],
            ],
            [
                'name' => 'Supervisor Example',
                'email' => 'supervisor@example.com',
                'default_role' => 'admin',
                'clients' => [
                    ['client' => $techCorpClient, 'role' => 'admin', 'is_primary' => true],
                    ['client' => $globalTradeClient, 'role' => 'shop_manager', 'is_primary' => false],
                ],
            ],
            [
                'name' => 'Shop Manager Example',
                'email' => 'shop_manager@example.com',
                'default_role' => 'shop_manager',
                'clients' => [
                    ['client' => $acmeClient, 'role' => 'shop_manager', 'is_primary' => true],
                    ['client' => $globalTradeClient, 'role' => 'commercial_partner', 'is_primary' => false],
                ],
            ],
            [
                'name' => 'Shopper Example',
                'email' => 'shopper@example.com',
                'default_role' => 'commercial_partner',
                'clients' => [
                    ['client' => $techCorpClient, 'role' => 'commercial_partner', 'is_primary' => true],
                    ['client' => $acmeClient, 'role' => 'vip', 'is_primary' => false],
                ],
            ],
            [
                'name' => 'VIP Shopper Example',
                'email' => 'vip_shopper@example.com',
                'default_role' => 'vip',
                'clients' => [
                    ['client' => $globalTradeClient, 'role' => 'vip', 'is_primary' => true],
                    ['client' => $techCorpClient, 'role' => 'vip', 'is_primary' => false],
                ],
            ],
        ];

        foreach ($users as $userData) {
            // Create the user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $password,
                'role' => $userData['default_role'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Attach user to clients with different roles
            foreach ($userData['clients'] as $clientData) {
                $user->clients()->attach($clientData['client']->id, [
                    'role' => $clientData['role'],
                    'is_primary' => $clientData['is_primary'],
                    'is_active' => true,
                    'permissions' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Set current_client_id to primary client
                if ($clientData['is_primary']) {
                    $user->update(['current_client_id' => $clientData['client']->id]);
                }
            }

            $this->command->info("Created user: {$user->name} ({$user->email})");
        }

        $this->command->info('');
        $this->command->info('Test users and clients created successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Password for all users: qweasdzxc123');
        $this->command->info('');
        $this->command->info('Users:');
        foreach ($users as $userData) {
            $this->command->info("  - {$userData['email']} ({$userData['name']})");
        }
        $this->command->info('');
        $this->command->info('Clients:');
        $this->command->info("  - ACME Corporation (ACME)");
        $this->command->info("  - TechCorp Solutions (TECHCORP)");
        $this->command->info("  - GlobalTrade Logistics (GLOBALTRADE)");
    }
}
