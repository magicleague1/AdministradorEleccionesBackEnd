<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoblacionFacuCarr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poblacion_facu_carr', function (Blueprint $table) {
            $table->char('codsis', 25);
            $table->unsignedBigInteger('cod_facultad');
            $table->unsignedBigInteger('cod_carrera');

            /*$table->index('cod_facultad');
            $table->index('cod_carrera');*/
            
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
        Schema::dropIfExists('poblacion_facu_carr');
    }
}
