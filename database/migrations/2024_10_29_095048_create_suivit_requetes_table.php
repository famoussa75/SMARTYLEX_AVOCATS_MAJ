<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuivitRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivit_requetes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idSuivit');
            $table->unsignedInteger('idRequete');
            $table->foreign('idRequete')->references('idProcedure')->on('procedure_requetes')->onDelete('cascade');
            $table->string('ordonnance')->nullable();
            $table->string('reference')->nullable();
            $table->string('reponse')->nullable();
            $table->text('dateDecision')->nullable();
            $table->text('dateReception')->nullable();
            $table->string('rappel')->nullable();
            $table->text('suiviPar')->nullable();
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
        Schema::dropIfExists('suivit_requetes');
    }
}
