<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medicos')->insert([
            [
                'rutMedico' => '33333333-3',
                'nombreMedico' => 'Dr. Carlos Ruiz',
                'correoMedico' => 'carlos.ruiz@example.com',
                'telefonoMedico' => '998877665',
                'idEspecialidad' => 1
            ],
            [
                'rutMedico' => '44444444-4',
                'nombreMedico' => 'Dra. Ana Torres',
                'correoMedico' => 'ana.torres@example.com',
                'telefonoMedico' => '976543210',
                'idEspecialidad' => 2
            ],
            [
                'rutMedico' => '55555555-5',
                'nombreMedico' => 'Dra. Soledad Diaz',
                'correoMedico' => 'soledad.diaz@example.com',
                'telefonoMedico' => '123123456',
                'idEspecialidad' => 3
            ],
            [
                'rutMedico' => '21655415-9',
                'nombreMedico' => 'Dr . Juan Pérez',
                'correoMedico' => 'Juan.Perez@example.com',
                'telefonoMedico' => '999947734',
                'idEspecialidad' => 6
            ],
            [
                'rutMedico' => '14444544-4',
                'nombreMedico' => 'Dr Nabih Jeria',
                'correoMedico' => 'nabih@example.com',
                'telefonoMedico' => '123123123',
                'idEspecialidad' => 4
            ],
            [
                'rutMedico' => '21888888-8',
                'nombreMedico' => 'Dra Fernanda Lopez',
                'correoMedico' => 'fernanda.lopez@example.com',
                'telefonoMedico' => '128930321',
                'idEspecialidad' => 5
            ],
        ]);
    }
}
