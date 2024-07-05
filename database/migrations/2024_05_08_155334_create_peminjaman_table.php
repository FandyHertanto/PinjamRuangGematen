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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruang_id');
            $table->foreign('ruang_id')->references('id')->on('ruang');
            $table->unsignedBigInteger('peminjam_id');
            $table->foreign('peminjam_id')->references('id')->on('users');
            $table->date('TanggalPinjam');
            $table->time('JamMulai');
            $table->time('JamSelesai');
            $table->string('Deskripsi');
            $table->string('Persetujuan')->default('pending');
            $table->string('StatusPinjam')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
