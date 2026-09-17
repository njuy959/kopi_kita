<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Menambahkan akun user default.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'admin@kopikita.com',
            ],
            [
                'name' => 'Admin KOPI KITA',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'kasir@kopikita.com',
            ],
            [
                'name' => 'Kasir KOPI KITA',
                'password' => Hash::make('password123'),
                'role' => 'cashier',
            ]
        );
    }
}