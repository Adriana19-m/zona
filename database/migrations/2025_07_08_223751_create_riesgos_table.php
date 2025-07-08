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
        Schema::create('riesgos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('nivel');
            
            // Coordenadas múltiples para polígonos
            $table->decimal('latitud1', 10, 8)->nullable();
            $table->decimal('longitud1', 11, 8)->nullable();
            $table->decimal('latitud2', 10, 8)->nullable();
            $table->decimal('longitud2', 11, 8)->nullable();
            $table->decimal('latitud3', 10, 8)->nullable();
            $table->decimal('longitud3', 11, 8)->nullable();
            $table->decimal('latitud4', 10, 8)->nullable();
            $table->decimal('longitud4', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riesgos');
    }
};