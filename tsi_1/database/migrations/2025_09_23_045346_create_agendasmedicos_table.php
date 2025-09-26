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
        Schema::create('agendas_medicos', function (Blueprint $table) {
                $table->string('rutMedico', 12);
                $table->date('fecha');
                $table->time('horaInicio');
                $table->time('horaTermino');
                $table->date('fechaApertura');
                $table->boolean('disponibilidad');

                $table->primary(['rutMedico', 'fecha']);
                $table->foreign('rutMedico')
                    ->references('rutMedico')
                    ->on('medicos')
                    ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas_medicos');
    }
};
