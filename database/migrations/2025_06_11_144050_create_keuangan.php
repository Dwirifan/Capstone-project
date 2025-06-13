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
       
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_petani');
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();

            $table->enum('jenis', ['masuk', 'keluar']);
            $table->decimal('jumlah', 15, 2);
            $table->decimal('saldo_setelah', 15, 2)->nullable();

            $table->timestamps();
            $table->foreign('id_petani')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('set null');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
