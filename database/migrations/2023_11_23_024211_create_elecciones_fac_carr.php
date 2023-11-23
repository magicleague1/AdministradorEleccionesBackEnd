<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleccionesFacCarr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elecciones_fac_carr', function (Blueprint $table) {
            $table->unsignedBigInteger('COD_ELECCION')->nullable()->default(null);
            $table->unsignedBigInteger('COD_FACULTAD')->nullable()->default(null);
            $table->unsignedBigInteger('COD_CARRERA')->nullable()->default(null);

            /*$table->index('COD_ELECCION');
            $table->index('COD_FACULTAD');
            $table->index('COD_CARRERA');*/

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
        Schema::dropIfExists('elecciones_fac_carr');
    }
}
