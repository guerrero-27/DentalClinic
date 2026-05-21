<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '09123456789',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'client1',
            'email' => 'client@gmail.com',
            'phone' => '09123456789',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        $services = [
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
            ['name' => 'Dental Check-up',   'description' => 'desc here',   'price' => 500,     'duration_minutes' => 30],
        ];

        foreach ($services as $service){
            Service::create(array_merge($service, ['is_active' => true]));
        }
    }
}
