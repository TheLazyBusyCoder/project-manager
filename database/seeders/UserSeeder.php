<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'manager_id' => 0,
            ],
            [
                'name' => 'Project Manager',
                'email' => 'pm@example.com',
                'password' => Hash::make('password'),
                'role' => 'project_manager',
                'status' => 'active',
                'manager_id' => 0,
            ],
            [
                'name' => 'Developer User',
                'email' => 'developer@example.com',
                'password' => Hash::make('password'),
                'role' => 'developer',
                'status' => 'active',
                'manager_id' => 2, // example: assigned to PM
            ],
            [
                'name' => 'Tester User',
                'email' => 'tester@example.com',
                'password' => Hash::make('password'),
                'role' => 'tester',
                'status' => 'active',
                'manager_id' => 2, // example: assigned to PM
            ],
        ]);
    }
}