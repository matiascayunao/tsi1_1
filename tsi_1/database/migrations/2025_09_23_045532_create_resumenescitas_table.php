<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumenes_citas', function (Blueprint $table) {
            $table->unsignedSmallInteger('idCita')->primary();   // debe calzar con smallIncrements
            $table->string('diagnostico', 200);
            $table->string('prescripcion', 200);
            $table->unsignedSmallInteger('numReceta')->nullable();

            $table->foreign('idCita')
                  ->references('idCita')
                  ->on('citas_pacientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumenes_citas');
    }
};
