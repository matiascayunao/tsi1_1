<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pacientes')->insert([
            [
                'rutPaciente' => '11111111-1',
                'nombre' => 'Juan Pérez',
                'fechaNacimiento' => '1990-05-15',
                'correo' => 'juan.perez@example.com',
                'telefono' => '987654321',
                'codPrevision' => 1
            ],
            [
                'rutPaciente' => '22222222-2',
                'nombre' => 'María González',
                'fechaNacimiento' => '1985-10-20',
                'correo' => 'maria.gonzalez@example.com',
                'telefono' => '912345678',
                'codPrevision' => 2
            ],
        ]);
    }
}
