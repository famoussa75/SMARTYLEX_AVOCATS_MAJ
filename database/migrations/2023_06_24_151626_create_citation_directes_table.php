<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitationDirectesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citation_directes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idCitation');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->text('saisi');
            $table->string('dateHeureAud');
            $table->unsignedInteger('idHuissier')->nullable();
            $table->foreign('idHuissier')->references('idHss')->on('huissiers')->onDelete('cascade');
            $table->string('recepteurCitation');
            $table->string('dateSignification')->nullable();
            $table->text('mentionParticuliere')->nullable();
            $table->text('chefAccusation')->nullable();
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
        Schema::dropIfExists('citation_directes');
    }
}
