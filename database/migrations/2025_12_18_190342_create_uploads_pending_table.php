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
        Schema::create('uploads_pending', function (Blueprint $table) {
            $table->id();
            $table->string('temp_path');
            $table->string('original_name');
            $table->string('final_path');
            $table->string('affaire_slug');
            $table->enum('status', ['pending', 'done', 'error'])->default('pending');
            $table->text('error')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads_pending');
    }
};
