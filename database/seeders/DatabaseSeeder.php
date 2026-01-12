<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Siti Moza Meilinda',
            'username' => 'zaza',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Putri Widyaningrum',
            'username' => 'dyaa',
            'password' => Hash::make('12345678'),
            'role' => 'teknisi',
        ]);
    }
}