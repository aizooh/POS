<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@pos.com'],[
            'name' => 'Admin User',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'pin'      => '1234', //
        ]);

        User::updateOrCreate([
            'email' => 'attendant@pos.com'
        ],[
            'name' => 'Attendant User',
            'email' => 'attendant@pos.com',
            'password' => Hash::make('password'),
            'role' => 'attendant',
            'pin'      => '1234', //
        ]);
    }
}
// User::updateOrCreate(
//     ['email' => 'admin@mamicarpos.com'], // 👈 Look for this user first
//     [                                    // 👈 If found, update these; if not, create them
//         'name' => 'Admin',
//         'password' => Hash::make('your-secure-password'), // Ensure this matches your login pass
//         'role' => 'admin',
//         'pin' => '1234',
//     ]
// );