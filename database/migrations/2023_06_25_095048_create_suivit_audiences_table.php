<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuivitAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivit_audiences', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idSuivit');
            $table->unsignedInteger('idAudience');
            $table->foreign('idAudience')->references('idAudience')->on('audiences')->onDelete('cascade');
            $table->string('dateAudience')->nullable();
            $table->string('dateProchaineAudience')->nullable();
            $table->time('heure')->nullable();
            $table->string('TypeDecision')->nullable();
            $table->text('decision')->nullable();
            $table->text('extrait')->nullable();
            $table->string('heureDebut')->nullable();
            $table->string('heureFin')->nullable();
            $table->string('president')->nullable();
            $table->string('greffier')->nullable();
            $table->string('rappelLettre')->nullable();
            $table->string('rappelSignification')->nullable();
            $table->string('email')->nullable();
            $table->text('suiviPar')->nullable();
            $table->text('slug')->nullable();
            $table->string('rappelProchaineAudience')->nullable();
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
        Schema::dropIfExists('suivit_audiences');
    }
}
