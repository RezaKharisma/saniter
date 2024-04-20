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
        Schema::create('retur_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stok_material_id');
            $table->unsignedBigInteger('diterima_id');
            $table->string('kode_material');
            $table->string('nama_material');
            $table->date('tgl_retur')->nullable();
            $table->string('status');
            $table->string('keterangan');
            $table->string('retur_by')->nullable();
            $table->string('validasi_by')->nullable()->default(0);
            $table->string('retur_to')->nullable();
            $table->string('validasi_to')->nullable()->default(0);
            $table->string('jumlah');
            $table->enum('hasil_retur',['Diterima','Menunggu Validasi','Pending','Proses','Ditolak'])->nullable()->default('Menunggu Validasi');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_material');
    }
};
