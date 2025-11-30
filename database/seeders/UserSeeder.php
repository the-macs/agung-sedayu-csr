<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // generate user for the migration
        $userSuperAdmin = User::create([
            'name' => 'Esa Hadistra',
            'username' => 'esa.hadistra',
            'email' => 'esa.hadistra@garudapratama.com',
            'password' => bcrypt('password'),
            'phone' => '6281323459497',
        ]);

        // Assign role to user
        $userSuperAdmin->assignRole('super-admin');
        $userSuperAdmin->assignRole('admin');
    }
}
