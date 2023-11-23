<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrarPoblaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poblacion', function (Blueprint $table) {
            $table->integer('CODSIS')->primary();
            $table->char('COD_COMITE', 15)->nullable();
            $table->char('APELLIDO', 40);
            $table->char('NOMBRE', 40);
            $table->integer('CARNETIDENTIDAD');
            $table->tinyInteger('ESTUDIANTE')->nullable();
            $table->tinyInteger('DOCENTE')->nullable();
            

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
        //
    }
}
