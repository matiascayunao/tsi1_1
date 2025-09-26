<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->string('rutPaciente', 12)->primary();
            $table->string('nombre', 100);
            $table->date('fechaNacimiento');
            $table->string('correo', 100)->unique();
            $table->string('telefono', 15);

            $table->unsignedTinyInteger('codPrevision');         // FK tinyint
            $table->foreign('codPrevision')
                  ->references('codPrevision')
                  ->on('previsiones')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
