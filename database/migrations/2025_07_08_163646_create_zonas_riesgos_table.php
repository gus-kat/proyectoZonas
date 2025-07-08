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
        Schema::create('zonas_riesgos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('nivelRiesgo'); 

            
            $table->decimal('latitud1', 10, 7)->nullable();
            $table->decimal('longitud1', 10, 7)->nullable();
            $table->decimal('latitud2', 10, 7)->nullable();
            $table->decimal('longitud2', 10, 7)->nullable();
            $table->decimal('latitud3', 10, 7)->nullable();
            $table->decimal('longitud3', 10, 7)->nullable();
            $table->decimal('latitud4', 10, 7)->nullable();
            $table->decimal('longitud4', 10, 7)->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zonas_riesgos');
    }
};
