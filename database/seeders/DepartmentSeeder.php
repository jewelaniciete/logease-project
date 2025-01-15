<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'department_name' => 'COA Department',
        ]);

        Department::create([
            'department_name' => 'STEM Department',
        ]);

        Department::create([
            'department_name' => 'EAC Department',
        ]);
    }
}
