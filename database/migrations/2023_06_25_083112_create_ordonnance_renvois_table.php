<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdonnanceRenvoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordonnance_renvois', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idOrd');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->string('numOrd');
            $table->string('cabinetIns')->nullable();
            $table->string('typeProcedure');
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
        Schema::dropIfExists('ordonnance_renvois');
    }
}
