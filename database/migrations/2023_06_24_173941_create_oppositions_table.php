<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOppositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oppositions', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idOpposition');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->unsignedInteger('idHuissier');
            $table->foreign('idHuissier')->references('idHss')->on('huissiers')->onDelete('cascade');
            $table->string('dateActe');
            $table->string('dateProchaineAud');
            $table->string('numDecision');
            $table->string('numRg')->nullable();
            $table->string('recepteurAss');
            $table->string('datePremiereComp');
            $table->string('dateEnrollement');
            $table->text('mentionParticuliere');
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
        Schema::dropIfExists('oppositions');
    }
}
