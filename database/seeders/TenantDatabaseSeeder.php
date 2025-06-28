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
        Role::create(['name' => "super-admin"]);
        Role::create(['name' => "admin"]);
        Role::create(['name' => "seller"]);
        Role::create(['name' => "user"]);

        $tenant = Tenant::create([
            'name' => 'Tenant A',
            'slug' => 'tenant-a',
            'domain' => 'tenant-a.example.com',
            'database_name' => 'tenant_a_db',
            'timezone' => 'UTC',
            'currency' => 'Rs',
            'locale' => 'ur_Pak',
            'is_active' => true,
            'settings' => null,
            'trial_ends_at' => null
        ]);

        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('2k19khalidkhan'),
            'remember_token' => null,
            'tenant_id' => $tenant->id,
        ]);

        $superadmin->assignRole('super-admin');
        
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => null,
            'tenant_id' => $tenant->id,
        ]);

        $admin->assignRole('admin');




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
