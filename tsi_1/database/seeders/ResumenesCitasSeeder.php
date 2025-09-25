<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResumenesCitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('resumenes_citas')->insert([
            [
                'idCita' => 1,
                'diagnostico' => 'Hipertensión controlada',
                'prescripcion' => 'Losartán 50mg diario',
                'numReceta' => 'RX1001'
            ],
            [
                'idCita' => 2,
                'diagnostico' => 'Resfriado común',
                'prescripcion' => 'Paracetamol 500mg cada 8 horas',
                'numReceta' => 'RX1002'
            ],
        ]);
    }
}
