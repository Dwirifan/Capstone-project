<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_petani')->nullable();
            $table->enum('tipe_produk', ['gabah', 'beras', 'tebas'])->nullable();
            $table->string('nama');
            $table->integer('rating')->nullable();
            $table->integer('jumlah_penjualan')->default(0);
            $table->foreign('id_petani')->references('id_petani')->on('petani')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('file_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->enum('tipe_file', ['foto', 'video']);
            $table->string('file_path');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('file_produk');
        Schema::dropIfExists('produk');
        
    }
};
