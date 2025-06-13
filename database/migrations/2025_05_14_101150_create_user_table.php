<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel users
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('google_id')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });

        // Tabel petani
        Schema::create('petani', function (Blueprint $table) {
            $table->unsignedBigInteger('id_petani')->primary();
            $table->foreign('id_petani')->references('id_user')->on('user')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('foto')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('nomor_rekening');
            $table->timestamps();
        });

        // Tabel pembeli 
        Schema::create('pembeli', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->primary();
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('foto')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });

        // Tabel mitra
        Schema::create('mitra', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mitra')->primary();
            $table->foreign('id_mitra')->references('id_user')->on('user')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('foto')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('nomor_rekening');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('token_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('token');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_revoked')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('user')->onDelete('cascade');
        });

        Schema::create('pending_user', function (Blueprint $table){
            $table->id('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

  public function down(): void
    {
    Schema::dropIfExists('token_user');
    Schema::dropIfExists('mitra');
    Schema::dropIfExists('pembeli');
    Schema::dropIfExists('petani');
    Schema::dropIfExists('pending_user');
    Schema::dropIfExists('password_reset_tokens');  
    Schema::dropIfExists('user');
    }

};
