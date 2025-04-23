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
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('etiqueta_cpu')->nullable()->change();
            $table->string('marca_cpu')->nullable()->change();
            $table->string('modelo_cpu')->nullable()->change();
            $table->string('numero_serie_cpu')->nullable()->change();
            $table->string('tipo_cpu')->nullable()->change();
            $table->string('memoria')->nullable()->change();
            $table->string('disco_duro')->nullable()->change();
            $table->string('conectores_video')->nullable()->change();
            $table->string('etiqueta_monitor')->nullable()->change();
            $table->string('marca_monitor')->nullable()->change();
            $table->string('modelo_monitor')->nullable()->change();
            $table->string('conectores_monitor')->nullable()->change();
            $table->unsignedInteger('pulgadas')->nullable()->change();
            $table->string('numero_serie_monitor')->nullable()->change();
            $table->string('etiqueta_teclado')->nullable()->change();
            $table->string('etiqueta_raton')->nullable()->change();
            $table->text('observaciones')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('etiqueta_cpu')->nullable(false)->change();
            $table->string('marca_cpu')->nullable(false)->change();
            $table->string('modelo_cpu')->nullable(false)->change();
            $table->string('numero_serie_cpu')->nullable(false)->change();
            $table->string('tipo_cpu')->nullable(false)->change();
            $table->string('memoria')->nullable(false)->change();
            $table->string('disco_duro')->nullable(false)->change();
            $table->string('conectores_video')->nullable(false)->change();
            $table->string('etiqueta_monitor')->nullable(false)->change();
            $table->string('marca_monitor')->nullable(false)->change();
            $table->string('modelo_monitor')->nullable(false)->change();
            $table->string('conectores_monitor')->nullable(false)->change();
            $table->unsignedInteger('pulgadas')->nullable(false)->change();
            $table->string('numero_serie_monitor')->nullable(false)->change();
            $table->string('etiqueta_teclado')->nullable(false)->change();
            $table->string('etiqueta_raton')->nullable(false)->change();
            $table->text('observaciones')->nullable(false)->change();
        });
    }
};
