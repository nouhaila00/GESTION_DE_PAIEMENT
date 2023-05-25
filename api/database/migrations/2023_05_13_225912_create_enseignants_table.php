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
            $table->string('ppr')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->unsignedBigInteger('etablissement_id');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('etablissement_id')->references('id')->on ('etablissements');
            $table->foreign('grade_id')->references('id')->on ('grades');
            $table->foreign('user_id')->references('id')->on ('users');
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
