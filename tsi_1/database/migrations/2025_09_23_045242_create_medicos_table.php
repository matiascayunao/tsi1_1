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
       Schema::create('medicos', function (Blueprint $table) {
            $table->string('rutMedico', 12)->primary();
            $table->string('nombreMedico');
            $table->string('correoMedico')->unique();
            $table->string('telefonoMedico', 15);

            $table->foreignId('idEspecialidad')
                ->constrained('especialidades', 'idEspecialidad')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
