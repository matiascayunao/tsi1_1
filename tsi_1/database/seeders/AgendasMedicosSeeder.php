<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgendasMedicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agendas_medicos')->insert([
            [
                'rutMedico' => '33333333-3',
                'fecha' => '2025-09-25',
                'horaInicio' => '09:00:00',
                'horaTermino' => '13:00:00',
                'fechaApertura' => '2025-09-20',
                'disponibilidad' => true
            ],
            [
                'rutMedico' => '44444444-4',
                'fecha' => '2025-09-26',
                'horaInicio' => '10:00:00',
                'horaTermino' => '14:00:00',
                'fechaApertura' => '2025-09-21',
                'disponibilidad' => true
            ],
        ]);
    }
}
