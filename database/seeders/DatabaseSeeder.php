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
        // Admin user
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'phone' => '09123456789',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Sample Dentists
        User::create([
            'name' => 'Dr. Maria Santos',
            'email' => 'dr.santos@dentalcare.com',
            'phone' => '09123456701',
            'role' => 'dentist',
            'working_start' => '09:00',
            'working_end' => '17:00',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Dr. Juan Reyes',
            'email' => 'dr.reyes@dentalcare.com',
            'phone' => '09123456702',
            'role' => 'dentist',
            'working_start' => '09:00',
            'working_end' => '17:00',
            'password' => Hash::make('password'),
        ]);

        // Sample Client
        User::create([
            'name' => 'client1',
            'email' => 'client@gmail.com',
            'phone' => '09123456789',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        // Dental Services with proper durations and buffer times
        $services = [
            [
                'name' => 'Dental Cleaning',
                'description' => 'Professional teeth cleaning to remove plaque and tartar, polish teeth, and maintain oral hygiene.',
                'price' => 1500.00,
                'duration_minutes' => 30,
                'buffer_minutes' => 10,
            ],
            [
                'name' => 'Tooth Extraction',
                'description' => 'Safe removal of damaged or problematic teeth by professional dentists.',
                'price' => 2500.00,
                'duration_minutes' => 60,
                'buffer_minutes' => 15,
            ],
            [
                'name' => 'Braces Adjustment',
                'description' => 'Regular orthodontic adjustment to ensure proper teeth alignment and braces function.',
                'price' => 2000.00,
                'duration_minutes' => 45,
                'buffer_minutes' => 10,
            ],
            [
                'name' => 'Teeth Whitening',
                'description' => 'Professional teeth whitening treatment to brighten and whiten your smile safely.',
                'price' => 5000.00,
                'duration_minutes' => 90,
                'buffer_minutes' => 15,
            ],
            [
                'name' => 'Dental Check-up',
                'description' => 'Comprehensive oral examination including X-rays and overall dental health assessment.',
                'price' => 800.00,
                'duration_minutes' => 30,
                'buffer_minutes' => 10,
            ],
            [
                'name' => 'Root Canal',
                'description' => 'Treatment to repair and save a badly damaged or infected tooth without extraction.',
                'price' => 8000.00,
                'duration_minutes' => 120,
                'buffer_minutes' => 20,
            ],
            [
                'name' => 'Filling',
                'description' => 'Composite or amalgam filling to restore cavities and damaged teeth to their natural shape.',
                'price' => 1200.00,
                'duration_minutes' => 45,
                'buffer_minutes' => 10,
            ],
        ];

        foreach ($services as $service){
            Service::create(array_merge($service, ['is_active' => true]));
        }
    }
}
