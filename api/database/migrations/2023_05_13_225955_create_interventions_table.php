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
            $table->id();
            $table->unsignedBigInteger('id_intervenant');
            $table->unsignedBigInteger('etablissement_id');
            $table->string('intitule_intervention');
            $table->string('annee_univ');
            $table->string('semestre');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nbr_heures');
            $table->integer('visa_etb')->default(0);
            $table->integer('visa_uae')->default(0);
            $table->foreign('id_intervenant')->references('id')->on ('enseignants');
            $table->foreign('etablissement_id')->references('id')->on ('etablissements');
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
