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
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->string('PPR');
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedBigInteger('id_etablissement');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_etablissement')->references('id')->on ('etablissements');
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
        Schema::dropIfExists('administrateurs');
    }
};
