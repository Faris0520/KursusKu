<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Admin
    User::create([
        'name' => 'Admin',
        'email' => 'admin@kursusku.test',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'is_verified' => true,
    ]);

    // Mentor (verified)
    User::create([
        'name' => 'Mentor Demo',
        'email' => 'mentor@kursusku.test',
        'password' => bcrypt('password'),
        'role' => 'mentor',
        'is_verified' => true,
    ]);

    // Siswa
    User::create([
        'name' => 'Siswa Demo',
        'email' => 'siswa@kursusku.test',
        'password' => bcrypt('password'),
        'role' => 'siswa',
    ]);

    // Kategori
    $categories = ['Web Development', 'Mobile Development', 'Data Science', 'UI/UX Design', 'DevOps'];
    foreach ($categories as $name) {
        Category::create(['name' => $name]);
    }
}
}
