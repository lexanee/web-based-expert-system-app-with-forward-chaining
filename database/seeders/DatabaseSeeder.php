<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Run custom seeders
        $this->call([
            UserSeeder::class,
            // Use JSON-based seeders to avoid duplication
            GejalaSeeder::class,
            MasalahSeeder::class,
            AturanSeeder::class,
        ]);
    }
}
