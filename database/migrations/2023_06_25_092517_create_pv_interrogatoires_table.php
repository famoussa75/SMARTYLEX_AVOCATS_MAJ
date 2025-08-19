<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvInterrogatoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pv_interrogatoires', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idPv');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->string('dateAudition');
            $table->text('identiteOPJ')->nullable();
            $table->text('infractions');
            $table->string('dateAudience');
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
        Schema::dropIfExists('pv_interrogatoires');
    }
}
