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
        Schema::create('gabah', function (Blueprint $table) {
            $table->id('id_gabah')->primary();
            $table->unsignedBigInteger('id_panen')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->enum('kualitas_gabah',['bagus','sedang','buruk']);
            $table->integer('harga_gabah');
            $table->decimal('stok_kg');
             $table->string('deskripsi');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_panen')->references('id_panen')->on('panen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gabah');
    }
};
