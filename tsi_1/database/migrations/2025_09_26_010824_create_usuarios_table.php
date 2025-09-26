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
    Schema::create('usuarios', function (Blueprint $table) {
        $table->string('rut')->primary(); // rut único como PK
        $table->string('nombre');
        $table->string('password'); // encriptada con Hash::make()
        $table->enum('rol', ['secretaria', 'medico']); // solo 2 tipos de usuarios
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
