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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('etiqueta_cpu');
            $table->string('marca_cpu');
            $table->string('modelo_cpu');
            $table->string('numero_serie_cpu');
            $table->string('tipo_cpu');
            $table->string('memoria');
            $table->string('disco_duro');
            $table->string('conectores_video');
            $table->string('etiqueta_monitor');
            $table->string('marca_monitor');
            $table->string('modelo_monitor');
            $table->string('conectores_monitor');
            $table->unsignedInteger('pulgadas');
            $table->string('numero_serie_monitor');
            $table->string('etiqueta_teclado');
            $table->string('etiqueta_raton');
            $table->text('observaciones')->nullable();
            $table->foreignId('aula_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
