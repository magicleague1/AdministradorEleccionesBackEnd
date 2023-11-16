<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Eleccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eleccioness', function (Blueprint $table) {
            $table->id('COD_ELECCION');
            $table->string('COD_ADMIN', 30)->nullable();
            $table->unsignedBigInteger('COD_FRENTE')->nullable();
            $table->unsignedBigInteger('COD_TEU')->nullable();
            $table->unsignedBigInteger('COD_COMITE')->nullable();
            $table->string('MOTIVO_ELECCION', 50);
            $table->string('TIPO_ELECCION', 255)->nullable();
            $table->date('FECHA_ELECCION');
            $table->date('FECHA_INI_CONVOCATORIA');
            $table->date('FECHA_FIN_CONVOCATORIA');
            $table->date('FECHA_INI_INSC_FRENTES');
            $table->date('FECHA_FIN_INSC_FRENTES');
            $table->boolean('ELECCION_ACTIVA')->default(1);
            $table->timestamps();

            // Claves foráneas
            $table->foreign('COD_FRENTE')->references('COD_FRENTE')->on('frentes')->onDelete('SET NULL');
            $table->foreign('COD_TEU')->references('COD_TEU')->on('teus')->onDelete('SET NULL');
            $table->foreign('COD_COMITE')->references('COD_COMITE')->on('comites')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
