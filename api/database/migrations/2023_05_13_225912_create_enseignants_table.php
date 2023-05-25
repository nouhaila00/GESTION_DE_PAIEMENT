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
            $table->unsignedBigInteger('id_etab');
            $table->unsignedBigInteger('id_grade');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_etab')->references('id')->on ('etablissements');
            $table->foreign('id_grade')->references('id')->on ('grades');
            $table->foreign('id_user')->references('id')->on ('users');
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
