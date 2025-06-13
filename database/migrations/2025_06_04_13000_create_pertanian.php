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
        Schema::create('pertanian', function (Blueprint $table) {
            $table->id('id_pertanian');
            $table->unsignedBigInteger('id_lahan');
            $table->date('tgl_tanam');
            $table->string('metode_tanam');
            $table->string('jenis_pupuk');
            $table->float('dosis_pupuk_HA');
            $table->integer('jumlah_gabah_percabang');
            $table->float('presentase_gabah_isi_hampa');
            $table->foreign('id_lahan')->references('id_lahan')->on('lahan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanian');
    }
};
