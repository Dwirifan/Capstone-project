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
        Schema::create('lahan', function (Blueprint $table) {
            $table->id('id_lahan');
            $table->unsignedBigInteger('id_petani')->nullable();
            $table->string('lokasi_lahan');
            $table->decimal('latitude', 10, 7); 
            $table->decimal('longitude', 10, 7);
            $table->json('bentuk_lahan');
            $table->float('ukuran_lahan');
            $table->float('ph_tanah');
            $table->float('ketersediaan_air');
            $table->foreign('id_petani')->references('id_user')->on('user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahan');
    }
};
