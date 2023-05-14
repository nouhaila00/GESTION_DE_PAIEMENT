<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id('id_intervention');
            $table->integer('id_intervenant');
            $table->integer('id_Etab');
            $table->integer('visa_etb')->default(0);
            $table->integer('visa_uae')->default(0);
            $table->foreign('id_intervenant')->references('id')->on ('enseignants');
            $table->foreign('id_Etab')->references('id')->on ('etablissements');
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
        Schema::dropIfExists('interventions');
    }
};
