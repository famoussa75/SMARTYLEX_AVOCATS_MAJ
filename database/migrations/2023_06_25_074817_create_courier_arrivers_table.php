<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierArriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_arrivers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idCourierArr');
            $table->unsignedInteger('idAffaire')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->text('expediteur');
            $table->string('dateCourier');
            $table->string('dateArriver');
            $table->bigInteger('numero');
            $table->text('objet');
            $table->string('statut');
            $table->string('niveau');
            $table->string('confidentialite')->nullable();
            $table->text('slug');
            $table->unsignedInteger('signifie')->nullable();
            $table->string('statutCourierTrasmise');
            
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
        Schema::dropIfExists('courier_arrivers');
    }
}
