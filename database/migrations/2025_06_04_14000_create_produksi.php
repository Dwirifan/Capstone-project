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
        Schema::create('produksi', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->unsignedBigInteger('id_panen');
            $table->date('tgl_pengemasan');
            $table->string('metode_pembersihan');
            $table->string('jenis_penggilingan');
            $table->string('kondisi_penyimpanan');
            $table->foreign('id_panen')->references('id_panen')->on('panen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
