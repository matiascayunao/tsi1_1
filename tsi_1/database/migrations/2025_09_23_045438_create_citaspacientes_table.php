<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas_pacientes', function (Blueprint $table) {
            $table->smallIncrements('idCita');                   // SmallInt PK (auto)
            $table->string('rutPaciente', 12);
            $table->string('rutMedico', 12);
            $table->dateTime('fechaHora');
            $table->string('motivoCita', 200);

            $table->foreign('rutPaciente')
                  ->references('rutPaciente')
                  ->on('pacientes')
                  ->onDelete('cascade');

            $table->foreign('rutMedico')
                  ->references('rutMedico')
                  ->on('medicos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas_pacientes');
    }
};
