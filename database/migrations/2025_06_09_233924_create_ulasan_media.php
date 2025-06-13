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
        Schema::create('ulasan_media', function (Blueprint $table) {
            $table->id('id_ulasan_media');
            $table->foreignId('id_ulasan')->constrained('ulasan', 'id_ulasan');
            $table->string('file_path');
            $table->enum('tipe_media', ['foto', 'video']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan_media');
    }
};
