<?php

namespace Database\Seeders;

use App\Models\Key;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Key::create([
            'key_name' => 'COA - Room 201',
        ]);

        Key::create([
            'key_name' => 'COA - Room 202',
        ]);

        Key::create([
            'key_name' => 'COA - Room 203',
        ]);

        Key::create([
            'key_name' => 'COA - Room 204',
        ]);

        Key::create([
            'key_name' => 'COA - Room 205',
        ]);

        Key::create([
            'key_name' => 'STEM - Room 201',
        ]);

        Key::create([
            'key_name' => 'STEM - Room 202',
        ]);

        Key::create([
            'key_name' => 'STEM - Room 203',
        ]);

        Key::create([
            'key_name' => 'STEM - Room 204',
        ]);

        Key::create([
            'key_name' => 'STEM - Room 205',
        ]);

        Key::create([
            'key_name' => 'EAC - Room 201',
        ]);

        Key::create([
            'key_name' => 'EAC - Room 202',
        ]);

        Key::create([
            'key_name' => 'EAC - Room 203',
        ]);

        Key::create([
            'key_name' => 'EAC - Room 204',
        ]);

        Key::create([
            'key_name' => 'EAC - Room 205',
        ]);
    }
}
