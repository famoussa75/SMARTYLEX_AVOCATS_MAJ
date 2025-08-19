<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_personnels', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idTachePersonnel');
            $table->unsignedInteger('idTache');
            $table->unsignedInteger('idPersonnel');
            $table->foreign('idTache')->references('idTache')->on('taches')->onDelete('cascade');
            $table->foreign('idPersonnel')->references('idPersonnel')->on('personnels')->onDelete('cascade');
            $table->string('fonction')->nullable();
            $table->string('rappel')->nullable();
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
        Schema::dropIfExists('tache_personnels');
    }
}
