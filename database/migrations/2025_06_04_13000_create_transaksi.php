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
          Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_user');
            $table->date('tgl_transaksi');
            $table->enum('metode_transaksi', ['DP', 'transfer']);
            $table->integer('jumlah_barang');
            $table->decimal('harga_item', 15, 2);
            $table->decimal('total_transaksi', 15, 2);
            $table->enum('status_transaksi', ['lunas', 'belum_lunas']);
            $table->timestamps();


            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });

        // Tabel transfer
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->enum('bank_pengirim', ['bank bni','bank cmb_niaga', 'bank bri', 'bank mandiri', 'bank bca']);
            $table->string('nama_pengirim');
            $table->string('no_rekening_pengirim');
            $table->string('bukti_transfer'); 
            $table->timestamp('tgl_transfer')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
        });

        // Tabel DP
        Schema::create('dp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->decimal('jumlah_dp', 15, 2);
            $table->string('bank_pengirim');
            $table->string('nama_pengirim');
            $table->string('no_rekening_pengirim');
            $table->string('bukti_dp');
            $table->timestamp('tgl_dp')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('transfer');
    Schema::dropIfExists('dp');
    Schema::dropIfExists('transaksi');
}
};
