<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrepriseAdversesRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprise_adverses_requetes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('idEntreprise');
            $table->unsignedInteger('idPartie');
            $table->foreign('idPartie')->references('idPartie')->on('parties_requetes')->onDelete('cascade');
            $table->text('denomination');
            $table->string('numRccm')->nullable();
            $table->string('siegeSocial');
            $table->string('formeLegal');
            $table->string('representantLegal')->nullable();
            $table->text('slug')->nullable();
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
        Schema::dropIfExists('entreprise_adverses_requetes');
    }
}
