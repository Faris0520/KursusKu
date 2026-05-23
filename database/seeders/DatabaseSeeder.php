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
        'email' => 'admin@kursusku.test',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'is_verified' => true,
    ]);
}
}
