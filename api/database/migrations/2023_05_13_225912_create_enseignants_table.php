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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('PPR');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->foreign('id_etab')->references('id')->on ('etablissements');
            $table->foreign('id_grade')->references('id_grade')->on ('grades');
            $table->foreign('id_user')->references('id_user')->on ('users');
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
        Schema::dropIfExists('enseignants');
    }
};
