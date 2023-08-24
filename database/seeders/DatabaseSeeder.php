<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Database\Factories\EmployeeFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sussy',
            'email' => 'sussy@gmail.com',
        ]);

        Employee::factory(10)->create();
    }
}
