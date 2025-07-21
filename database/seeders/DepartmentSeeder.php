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

        $departments = [
            [
                'name' => 'IT',
                'description' => 'IT Department',
                'status' => 'active',
                'color' => '#3674B5',
            ],
            [
                'name' => 'HR',
                'description' => 'Human Resources Department',
                'status' => 'active',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'Finance',
                'description' => 'Finance Department',
                'status' => 'active',
                'color' => '#EAB308',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Marketing Department',
                'status' => 'active',
                'color' => '#84CC16',
            ],
            [
                'name' => 'Sales',
                'description' => 'Sales Department',
                'status' => 'active',
                'color' => '#10B981',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
