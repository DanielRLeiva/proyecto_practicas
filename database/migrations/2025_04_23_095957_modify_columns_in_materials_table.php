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
        Schema::table('materials', function (Blueprint $table) {
            $table->string('etiqueta')->nullable()->change();
            $table->text('descripcion')->nullable()->change();
            $table->string('marca')->nullable()->change();
            $table->string('modelo')->nullable()->change();
            $table->string('numero_serie')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('etiqueta')->nullable(false)->change();
            $table->text('descripcion')->nullable(false)->change();
            $table->string('marca')->nullable(false)->change();
            $table->string('modelo')->nullable(false)->change();
            $table->string('numero_serie')->nullable(false)->change();
        });
    }
};
