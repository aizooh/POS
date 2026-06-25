<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'pin'      => '1234', //
        ]);

        User::create([
            'name' => 'Attendant User',
            'email' => 'attendant@pos.com',
            'password' => Hash::make('password'),
            'role' => 'attendant',
            'pin'      => '1234', //
        ]);
    }
}