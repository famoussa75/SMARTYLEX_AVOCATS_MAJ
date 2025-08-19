<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvocatPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avocat_parties', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idAvocatPartie');
            $table->unsignedInteger('idPartie');
            $table->foreign('idPartie')->references('idPartie')->on('parties')->onDelete('cascade');
            $table->unsignedInteger('idAvocat')->nullable(); 
            $table->foreign('idAvocat')->references('idAvc')->on('avocats')->onDelete('cascade');
            $table->text('slug');  
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
        Schema::dropIfExists('avocat_parties');
    }
}
