<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties_requetes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('idPartie');
            $table->unsignedInteger('idRequete');
            $table->foreign('idRequete')->references('idProcedure')->on('procedure_requetes')->onDelete('cascade');
            $table->string('role');
            $table->string('autreRole')->nullable();
            $table->unsignedInteger('idClient')->nullable(); 
            $table->unsignedInteger('idAffaire')->nullable(); 
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->string('typeAvocat')->nullable();
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
        Schema::dropIfExists('parties_requetes');
    }
}
