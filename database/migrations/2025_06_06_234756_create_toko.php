<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('toko', function (Blueprint $table) {
    //         $table->id('id_toko');
    //         $table->unsignedBigInteger('id_petani');
    //         $table->string('name_toko');
    //         $table->integer('nomor_rekening');
    //         $table->string('alamat');
    //         $table->string('deskripsi');
    //         $table->foreign('id_petani')->references('id_petani')->on('petani')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('toko');
    // }
};
