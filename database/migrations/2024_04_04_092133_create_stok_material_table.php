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
        Schema::create('stok_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->string('kode_material');
            $table->double('harga');
            $table->string('masuk');
            $table->boolean('diterima_pm');
            $table->date('tanggal_diterima_pm')->nullable();
            $table->enum('status_validasi_pm',['Belum Validasi','ACC','ACC Sebagian','Tolak'])->nullable();
            $table->boolean('diterima_spv')->nullable();
            $table->date('tanggal_diterima_spv')->nullable();
            $table->string('stok_update')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_material');
    }
};
