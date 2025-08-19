<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('serveur_mails', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idServeur');
            $table->text('nom')->nullable();
            $table->text('host')->nullable();
            $table->text('smtpSecure')->nullable();
            $table->unsignedBigInteger('smtpPort');
            $table->timestamps();
        });

          // Insérez des données dans la table
          DB::table('serveur_mails')->insert([
            'nom' => 'Titan',
            'host' => 'smtp.titan.email',
            'smtpSecure' => 'ssl',
            'smtpPort' => 465,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serveur_mails');
    }
};
