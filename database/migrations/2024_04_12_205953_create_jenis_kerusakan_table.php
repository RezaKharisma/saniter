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
        Schema::create('jenis_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_tgl_kerja_id');
            $table->unsignedBigInteger('dikerjakan_oleh');
            $table->string('nama_kerusakan')->nullable();
            $table->string('foto');
            $table->text('deskripsi')->default('-');
            $table->string('nomor_denah');
            $table->date('tgl_selesai_pekerjaan');
            $table->enum('status_kerusakan',['Penggantian','Dengan Material','Tanpa Material']);
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_kerusakan');
    }
};
