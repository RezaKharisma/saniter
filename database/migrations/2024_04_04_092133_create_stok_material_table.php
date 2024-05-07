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
            $table->string('nama_material');
            $table->double('harga', 25, 2);
            $table->string('masuk');
            $table->string('sebagian_som')->nullable()->default(0);
            $table->string('sebagian_pm')->nullable()->default(0);
            $table->boolean('diterima_som')->default(0);
            $table->string('diterima_som_by')->nullable()->default(0);
            $table->date('tanggal_diterima_som')->nullable()->default(null);
            $table->enum('status_validasi_som', ['Belum Validasi', 'ACC', 'ACC Sebagian', 'Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan_som')->default('-');
            $table->boolean('diterima_pm')->nullable()->default(0);
            $table->string('diterima_pm_by')->nullable()->default(0);
            $table->date('tanggal_diterima_pm')->nullable()->default(null);
            $table->enum('status_validasi_pm', ['Belum Validasi', 'ACC', 'ACC Sebagian', 'Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan_pm')->default('-');
            $table->boolean('diterima_dir')->nullable()->default(0);
            $table->string('diterima_dir_by')->nullable()->default(0);
            $table->date('tanggal_diterima_dir')->nullable()->default(null);
            $table->enum('status_validasi_dir', ['Belum Validasi', 'ACC', 'Tolak'])->nullable()->default('Belum Validasi');
            $table->text('keterangan_dir')->default('-');
            $table->double('stok_update')->nullable()->default(0);
            $table->string('created_by')->default(0);
            $table->boolean('history')->default(0);
            $table->unsignedBigInteger('history_id')->default(0);
            $table->timestamps();
            // $table->unsignedBigInteger('material_id');
            // $table->string('kode_material');
            // $table->string('nama_material');
            // $table->double('harga');
            // $table->string('masuk');
            // $table->string('sebagian')->nullable()->default(0);
            // $table->boolean('diterima_pm')->default(0);
            // $table->string('diterima_pm_by')->nullable()->default(0);
            // $table->date('tanggal_diterima_pm')->nullable()->default(null);
            // $table->enum('status_validasi_pm',['Belum Validasi','ACC','ACC Sebagian','Tolak'])->nullable()->default('Belum Validasi');
            // $table->text('keterangan')->default('-');
            // $table->boolean('diterima_spv')->nullable()->default(0);
            // $table->string('diterima_spv_by')->nullable()->default(0);
            // $table->date('tanggal_diterima_spv')->nullable()->default(null);
            // $table->double('stok_update')->nullable()->default(0);
            // $table->string('created_by')->default(0);
            // $table->boolean('history')->default(0);
            // $table->unsignedBigInteger('history_id')->default(0);
            // $table->timestamps();
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
