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
            $table->id('ID_TS')->nullable()->default(null);
            $table->integer('COD_SIS')->nullable()->default(null);
            $table->integer('COD_COMITE')->nullable()->default(null);
            $table->integer('COD_TITULAR_SUPLENTE')->nullable()->default(null);
        
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
