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
            $table->string('sebagian')->nullable()->default(0);
            $table->boolean('diterima_pm')->default(0);
            $table->string('diterima_pm_by')->nullable()->default(0);
            $table->date('tanggal_diterima_pm')->nullable()->default('0000-00-00');
            $table->enum('status_validasi_pm',['Belum Validasi','ACC','ACC Sebagian','Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan')->default('-');
            $table->boolean('diterima_spv')->nullable()->default(0);
            $table->string('diterima_spv_by')->nullable()->default(0);
            $table->date('tanggal_diterima_spv')->nullable()->default('0000-00-00');
            $table->string('stok_update')->nullable()->default(0);
            $table->string('created_by')->default(0);
            $table->boolean('history')->default(0);
            $table->unsignedBigInteger('history_id')->default(0);
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
