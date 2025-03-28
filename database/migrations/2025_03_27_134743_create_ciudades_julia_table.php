<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('ciudadesJulia', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_pais');
            $table->string('nombre_pais');
            $table->string('codigo_ciudad');
            $table->string('nombre_ciudad');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('ciudadesJulia');
    }
};