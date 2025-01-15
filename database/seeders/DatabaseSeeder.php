<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\KeySeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@logease.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call([
            KeySeeder::class,
            DepartmentSeeder::class
        ]);
    }
}
