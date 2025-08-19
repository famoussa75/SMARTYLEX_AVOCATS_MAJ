<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachePersonnelFillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_personnel_filles', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idTachePersFille');
            $table->unsignedInteger('idTacheFille');
            $table->unsignedInteger('idPersonnel');
            $table->foreign('idTacheFille')->references('idTacheFille')->on('tache_filles');
            $table->foreign('idPersonnel')->references('idPersonnel')->on('personnels');
            $table->string('fonction')->nullable();
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
        Schema::dropIfExists('tache_personnel_filles');
    }
}
