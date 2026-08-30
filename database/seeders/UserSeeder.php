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
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@uis.ac.id',
                'role' => 'superadmin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Admin Unit',
                'email' => 'admin@uis.ac.id',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'User Sinergi',
                'email' => 'user@uis.ac.id',
                'role' => 'user',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

