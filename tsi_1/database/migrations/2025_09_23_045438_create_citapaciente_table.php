<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citapaciente', function (Blueprint $table) {
            $table->id('idCita');
            $table->string('rutPaciente', 12);
            $table->string('rutMedico', 12);
            $table->dateTime('fechaHora');
            $table->string('motivoCita');

            $table->foreign('rutPaciente')->references('rutPaciente')->on('Paciente');
            $table->foreign('rutMedico')->references('rutMedico')->on('Medico');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citapaciente');
    }
};
