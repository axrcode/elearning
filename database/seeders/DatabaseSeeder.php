<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'id' => Role::ADMIN,
            'name' => 'Administrador',
            'description' => 'Usuario administrador',
        ]);

        Role::create([
            'id' => Role::TEACHER,
            'name' => 'Profesor',
            'description' => 'Usuario profesor',
        ]);

        Role::create([
            'id' => Role::STUDENT,
            'name' => 'Estudiante',
            'description' => 'Usuario estudiante',
        ]);

        User::factory()->create([
            'role_id' => Role::ADMIN,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);
    }
}
