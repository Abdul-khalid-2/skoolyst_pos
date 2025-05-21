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
<<<<<<< HEAD
        $this->call([
            InventoryLogsSeeder::class,
            // Other seeders...
        ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
=======

        // User::factory()->create([
        //     'name' => 'super admin',
        //     'email' => 'superadmin@gmail.com',
>>>>>>> 4087c472f0dfb0ce89c282d5665377c5a352a50a
        // ]);
    }
}
