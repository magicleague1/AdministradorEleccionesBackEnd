<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsociarTitularSuplente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asociartitularsuplente', function (Blueprint $table) {
            $table->integer('ID_TS', 15)->nullable()->default(null);
            $table->integer('COD_SIS', 15)->nullable()->default(null);
            $table->integer('COD_COMITE', 15)->nullable()->default(null);
            $table->integer('COD_TITULAR_SUPLENTE', 15)->nullable()->default(null);

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
        Schema::dropIfExists('asociartitularsuplente');
    }
}
