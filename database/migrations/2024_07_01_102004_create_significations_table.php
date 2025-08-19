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
        Schema::create('significations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idSignification');
            $table->datetime('dateSignification')->nullable();
            $table->text('numJugement')->nullable();
            $table->text('slugAudience')->nullable();
            $table->unsignedInteger('idHss');
            $table->foreign('idHss')->references('idHss')->on('huissiers')->onDelete('cascade');
            $table->text('recepteur')->nullable();
            $table->text('reserve')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('significations');
    }
};
