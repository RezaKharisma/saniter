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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('jenis_izin', length: 50);
            $table->date('tgl_mulai_izin');
            $table->date('tgl_akhir_izin');
            $table->text('keterangan');
            $table->integer('total_izin');
            $table->string('foto', length: 250);
            $table->boolean('validasi_1')->default(0)->nullable();
            $table->string('validasi_1_by')->nullable();
            $table->date('tanggal_diterima_1')->nullable()->default(null);
            $table->enum('status_validasi_1', ['Belum Validasi', 'ACC', 'Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan_1')->default('-');
            $table->boolean('validasi_2')->default(0)->nullable();
            $table->string('validasi_2_by')->nullable();
            $table->date('tanggal_diterima_2')->nullable()->default(null);
            $table->enum('status_validasi_2', ['Belum Validasi', 'ACC', 'Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan_2')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
