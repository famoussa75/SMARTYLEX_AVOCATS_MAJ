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
        Schema::create('publicites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titre')->nullable();
            $table->string('image')->nullable();
            $table->string('lien')->nullable();
            $table->string('statut')->nullable();
            $table->string('debut')->nullable();
            $table->string('fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicites');
    }
};
