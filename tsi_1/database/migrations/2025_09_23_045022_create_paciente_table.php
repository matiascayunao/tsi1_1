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
        Schema::create('Paciente', function (Blueprint $table) {
            $table->string('rutPaciente', 12)->primary();
            $table->string('nombre');
            $table->date('fechaNacimiento');
            $table->string('correo')->unique();
            $table->string('telefono', 15);
            $table->unsignedBigInteger('codPrevision');
            $table->foreign('codPrevision')->references('codPrevision')->on('Prevision');
            //$table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
