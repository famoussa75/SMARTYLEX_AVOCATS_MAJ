<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            // Client physique
            $table->increments('idClient');
            $table->string('typeClient');

            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();

            // Client Morale
            $table->unsignedInteger('idRepresentant')->nullable();
            $table->foreign('idRepresentant')->references('idRepresentant')->on('representants')->onDelete('cascade');
            $table->string('adresseEntreprise')->nullable();
            $table->string('emailEntreprise')->nullable();
            $table->string('telephoneEntreprise')->nullable();
            $table->string('denomination')->nullable();
            $table->string('capitalSocial')->nullable();
            $table->string('rccm')->nullable();
            $table->string('nif')->nullable();
            $table->string('cnss')->nullable();
            $table->string('logo')->nullable();

            $table->string('emailFacture')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
