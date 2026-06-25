<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@mamicarpos.com',
        'password' => bcrypt('admin1234'),
        'role' => 'admin',
        'pin' => '1234',
    ]);

    User::create([
        'name' => 'Attendant',
        'email' => 'attendant@mamicarpos.com',
        'password' => bcrypt('attend1234'),
        'role' => 'attendant',
        'pin' => '1234',
    ]);
}
}
