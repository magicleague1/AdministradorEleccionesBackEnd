<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('CODADMINISTRADOR'); // Esto ya es autoincremental y clave primaria
            $table->integer('CODCOMITE')->nullable()->default(null);
            $table->char('NOMBREADMINISTRADOR', 40)->nullable()->default(null);
            $table->char('CONTRASENAADMINISTRADOR', 10)->nullable()->default(null);
            $table->char('CORREO', 20)->nullable()->default(null);
            $table->integer('TELEFONO')->nullable()->default(null); // No autoincremental
        
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrador');
    }
}
