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
        ]);
    }
}
