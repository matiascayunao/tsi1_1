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
       Schema::create('resumenes_citas', function (Blueprint $table) {
    $table->unsignedBigInteger('idCita')->primary();
    $table->string('diagnostico');
    $table->string('prescripcion');
    $table->string('numReceta');

    $table->foreign('idCita')
          ->references('idCita')
          ->on('citas_pacientes')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumenes_citas');
    }
};
