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
        Schema::create('panen', function (Blueprint $table) {
            $table->id('id_panen');
            $table->unsignedBigInteger('id_lahan');
            $table->enum('teknik_panen',['combie','manual']);
            $table->enum('jenis_pengeringan',['matahari','mesin']);
            $table->time('durasi_pengeringan');
            $table->foreign('id_lahan')->references('id_lahan')->on('lahan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panen');
    }
};
