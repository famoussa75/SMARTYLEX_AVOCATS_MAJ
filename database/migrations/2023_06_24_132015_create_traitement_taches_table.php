<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraitementTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traitement_taches', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idTraitement');
            $table->unsignedInteger('idTache');
            $table->unsignedInteger('idPersonnel')->nullable();
            $table->foreign('idTache')->references('idTache')->on('taches')->onDelete('cascade');
            $table->foreign('idPersonnel')->references('idPersonnel')->on('personnels')->onDelete('cascade');
            $table->text('description');
            $table->text('type')->nullable();
            $table->double('timesheet')->nullable();
            $table->string('uniteTime')->nullable();
            $table->text('initialAdmin')->nullable();
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
        Schema::dropIfExists('traitement_taches');
    }
}
