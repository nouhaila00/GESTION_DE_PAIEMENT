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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->integer('id_intervenant');
            $table->double('taux_h');
            $table->integer('id_etab');
            $table->double('brut');
            $table->integer('IR');
            $table->double('net');
            $table->string('annee_univ');
            $table->string('semestre');
            $table->foreign('id_intervenant')->references('id_intervention')->on ('interventions');
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
        Schema::dropIfExists('paiements');
    }
};
