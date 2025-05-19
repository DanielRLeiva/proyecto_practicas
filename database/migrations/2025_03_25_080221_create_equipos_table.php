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
            $table->string('etiqueta_cpu')->nullable();
            $table->string('marca_cpu')->nullable();
            $table->string('modelo_cpu')->nullable();
            $table->string('numero_serie_cpu')->nullable();
            $table->string('tipo_cpu')->nullable();
            $table->string('memoria')->nullable();
            $table->string('disco_duro')->nullable();
            $table->string('conectores_video')->nullable();
            $table->string('etiqueta_monitor')->nullable();
            $table->string('marca_monitor')->nullable();
            $table->string('modelo_monitor')->nullable();
            $table->string('conectores_monitor')->nullable();
            $table->decimal('pulgadas', 4, 1)->nullable();
            $table->string('numero_serie_monitor')->nullable();
            $table->string('etiqueta_teclado')->nullable();
            $table->string('etiqueta_raton')->nullable();
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
