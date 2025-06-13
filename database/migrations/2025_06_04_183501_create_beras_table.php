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
        Schema::create('beras', function (Blueprint $table) {
            $table->id('id_beras')->primary();
            $table->unsignedBigInteger('id_produksi');
            $table->unsignedBigInteger('id_produk');
            $table->enum('kualitas_beras', ['premium', 'medium', 'rendah']);
            $table->integer('harga_kg');
            $table->decimal('stok_kg');
            $table->string('deskripsi');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_produksi')->references('id_produksi')->on('produksi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beras');
    }
};
