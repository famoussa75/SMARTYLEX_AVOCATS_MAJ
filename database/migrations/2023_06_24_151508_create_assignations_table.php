<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idAssignation');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->string('numRg')->nullable();
            $table->unsignedInteger('idHuissier'); 
            $table->foreign('idHuissier')->references('idHss')->on('huissiers')->onDelete('cascade');
            $table->text('recepteurAss');
            $table->string('dateAssignation');
            $table->string('datePremiereComp');
            $table->string('dateEnrollement');
            $table->text('mentionParticuliere')->nullable();
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
        Schema::dropIfExists('assignations');
    }
}
