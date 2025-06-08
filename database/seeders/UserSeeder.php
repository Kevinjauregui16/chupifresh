<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Kevin jauregui',
            'email' => 'kevin@gmail.com',
            'password' => Hash::make('kevinKR16'),
        ]);
    }
}
