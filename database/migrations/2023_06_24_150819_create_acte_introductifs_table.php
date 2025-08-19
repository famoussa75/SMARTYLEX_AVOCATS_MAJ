<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActeIntroductifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acte_introductifs', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idActe');
            $table->unsignedInteger('idAudience');
            $table->foreign('idAudience')->references('idAudience')->on('audiences')->onDelete('cascade');
            $table->unsignedInteger('idNatureAction')->nullable();
            $table->foreign('idNatureAction')->references('idNatureAction')->on('nature_actions')->onDelete('cascade');
            $table->string('typeActe');
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
        Schema::dropIfExists('acte_introductifs');
    }
}
