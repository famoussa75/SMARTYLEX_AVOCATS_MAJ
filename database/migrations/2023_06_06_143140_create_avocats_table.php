<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvocatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avocats', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idAvc');
            $table->string('prenomAvc');
            $table->string('nomAvc');
            $table->string('telAvc_1')->nullable();
            $table->string('telAvc_2')->nullable();
            $table->string('telAvc_3')->nullable();
            $table->string('emailAvc_1')->nullable();
            $table->string('emailAvc_2')->nullable();
            $table->string('adresseAvc')->nullable();
            $table->string('annee_entrer')->nullable();
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
        Schema::dropIfExists('avocats');
    }
}
