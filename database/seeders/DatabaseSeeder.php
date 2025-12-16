<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@veggourmet.test'],
            [
                'name'     => 'Admin Veggourmet',
                'password' => Hash::make('12345678'),
                'role'     => 'admin',
            ]
        );
    }
}
