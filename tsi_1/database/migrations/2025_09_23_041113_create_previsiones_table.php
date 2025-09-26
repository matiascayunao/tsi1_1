<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('previsiones', function (Blueprint $table) {
            $table->tinyIncrements('codPrevision');              // TinyInt PK (auto)
            $table->string('nombrePrevision', 50);
            $table->string('tipoPrevision', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previsiones');
    }
};
