<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'ABC Logistics',
                'code' => 'ABC_LOG',
                'description' => 'Leading logistics and warehousing company',
                'domain' => 'abc-logistics.com',
                'is_active' => true,
                'settings' => [
                    'timezone' => 'UTC',
                    'currency' => 'USD',
                    'theme' => 'light',
                ],
            ],
            [
                'name' => 'Global Supply Chain',
                'code' => 'GSC',
                'description' => 'International supply chain management',
                'domain' => 'globalsupply.com',
                'is_active' => true,
                'settings' => [
                    'timezone' => 'UTC',
                    'currency' => 'EUR',
                    'theme' => 'light',
                ],
            ],
            [
                'name' => 'Metro Warehouse Solutions',
                'code' => 'MWS',
                'description' => 'Urban warehouse management services',
                'domain' => 'metrowarehouse.com',
                'is_active' => true,
                'settings' => [
                    'timezone' => 'UTC',
                    'currency' => 'USD',
                    'theme' => 'dark',
                ],
            ],
        ];

        foreach ($clients as $clientData) {
            \App\Models\Client::create($clientData);
        }
    }
}
