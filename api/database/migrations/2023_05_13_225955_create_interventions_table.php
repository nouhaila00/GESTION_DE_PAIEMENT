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
            $table->unsignedBigInteger('id_intervenant');
            $table->unsignedBigInteger('id_Etab');
            $table->string('intitule_intervention');
            $table->date('Annee_univ');
            $table->string('Semestre');
            $table->date('Date_debut');
            $table->date('Date_fin');
            $table->integer('Nbr_heures');
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
