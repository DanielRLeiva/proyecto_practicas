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
        Schema::create('portatils', function (Blueprint $table) {
            $table->id();
            $table->string('marca_modelo');
            $table->string('comentarios')->nullable();
            $table->enum('estado', ['Libre', 'Asignado', 'Baja'])->default('Libre'); // Valores controlados
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portatils');
    }
};
