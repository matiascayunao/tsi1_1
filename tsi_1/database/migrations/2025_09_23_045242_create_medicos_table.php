<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->string('rutMedico', 12)->primary();
            $table->string('nombreMedico', 100);
            $table->string('correoMedico', 100)->unique();
            $table->string('telefonoMedico', 15);

            $table->unsignedTinyInteger('idEspecialidad');       // FK tinyint
            $table->foreign('idEspecialidad')
                  ->references('idEspecialidad')
                  ->on('especialidades')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
