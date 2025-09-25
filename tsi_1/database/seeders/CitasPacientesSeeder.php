<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitasPacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('citas_pacientes')->insert([
            [
                'idCita' => 1,
                'rutPaciente' => '11111111-1',
                'rutMedico' => '33333333-3',
                'fechaHora' => '2025-09-25 10:00:00',
                'motivoCita' => 'Control de rutina'
            ],
            [
                'idCita' => 2,
                'rutPaciente' => '22222222-2',
                'rutMedico' => '44444444-4',
                'fechaHora' => '2025-09-26 11:30:00',
                'motivoCita' => 'Consulta pediátrica'
            ],
        ]);
    }
}
