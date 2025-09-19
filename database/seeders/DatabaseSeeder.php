<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email'     => 'mohamed@gmail.com',
            'username'  => 'admin'
        ], [
            'f_name'    => 'Mohamed',
            'l_name'    => 'Ashmawy',
            'email'     => 'mohamed@gmail.com',
            'username'  => 'admin',
            'password'  => Hash::make('password'),
            'abilities' => '*'
        ]);
    }
}
