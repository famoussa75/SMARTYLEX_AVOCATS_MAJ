<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuissiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huissiers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idHss');
            $table->string('prenomHss');
            $table->string('nomHss');
            $table->string('telHss_1')->nullable();
            $table->string('telHss_2')->nullable();
            $table->string('emailHss')->nullable();
            $table->string('adresseHss')->nullable();
            $table->string('rattachement')->nullable();
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
        Schema::dropIfExists('huissiers');
    }
}
