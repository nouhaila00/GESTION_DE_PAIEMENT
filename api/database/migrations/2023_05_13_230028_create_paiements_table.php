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
            $table->unsignedBigInteger('id_intervenant');
            $table->integer('id_etab');
            $table->integer('VH');
            $table->float('taux_h');
            $table->float('brut');
            $table->float('IR');
            $table->float('net');
            $table->date('annee_univ');
            $table->string('semestre');
            $table->foreign('id_intervenant')->references('id_intervention')->on ('interventions');
            $table->foreign('id_etab')->references('id')->on ('etablissements');
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
