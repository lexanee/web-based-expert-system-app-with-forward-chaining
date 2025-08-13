<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create superadmin account
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@iotace.co.id',
            'password' => Hash::make('bismillah'),
            'email_verified_at' => now(),
        ]);

        // Create additional admin account
        User::create([
            'name' => 'Admin IOTACE',
            'email' => 'admin@iotace.co.id',
            'password' => Hash::make('bismillah'),
            'email_verified_at' => now(),
        ]);
    }
}
