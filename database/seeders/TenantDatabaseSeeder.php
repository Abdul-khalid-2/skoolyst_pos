<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Tenant;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => "admin"]);
        Role::create(['name' => "seller"]);
        Role::create(['name' => "user"]);

        User::create([
            'name' => 'mdautos',
            'email' => 'mdautos@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => null
        ]);

        Tenant::create([
            'name' => 'Tenant A',
            'slug' => 'tenant-a',
            'domain' => 'tenant-a.example.com',
            'database_name' => 'tenant_a_db',
            'timezone' => 'UTC',
            'currency' => 'USD',
            'locale' => 'en_US',
            'is_active' => true,
            'settings' => null,
            'trial_ends_at' => null
        ]);


        PaymentMethod::create([
            'tenant_id' => 1,
            'name' => 'Cash',
            'code' => 'CASH',
            'type' => 'cash',
            'is_active' => true,
            'settings' => null
        ]);

        PaymentMethod::create([
            'tenant_id' => 1,
            'name' => 'Bank Transfer',
            'code' => 'BANK',
            'type' => 'bank',
            'is_active' => true,
            'settings' => null
        ]);
    }
}
