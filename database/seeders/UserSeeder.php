<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'npk'      => '2191207',
            'name'     => 'Rifai Bondhan Yogaswara',
            'email'    => 'bondhan@example.com',
            'password' => Hash::make('2191207'),
            'role'     => 'admin',
        ]);
        User::create([
            'npk'      => '2150965',
            'name'     => 'Michael Suryonegoro',
            'email'    => 'michael@example.com',
            'password' => Hash::make('2150965'),
            'role'     => 'leader',
        ]);
        User::create([
            'npk'      => '2000103',
            'name'     => 'Fachrudin Fachmi',
            'email'    => 'fachrudinfachmi@example.com',
            'password' => Hash::make('2000103'),
            'role'     => 'user',
        ]);
    }
}
