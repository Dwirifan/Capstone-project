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
        Schema::create('tebas', function (Blueprint $table) {
            $table->id('id_tebas')->primary();
            $table->unsignedBigInteger('id_lahan')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->integer('umur_padi');
            $table->float('rendeman_padi');
            $table->enum('stok_produk', ['available', 'sold_out'])->default('available');
            $table->integer('harga');
            $table->string('deskripsi');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_lahan')->references('id_lahan')->on('lahan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tebas');
    }
};
