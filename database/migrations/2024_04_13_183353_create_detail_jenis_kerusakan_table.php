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
        Schema::create('detail_jenis_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_kerusakan_id');
            $table->string('kode_material');
            $table->string('nama');
            $table->decimal('harga');
            $table->decimal('volume');
            $table->string('satuan');
            $table->decimal('total_harga');
            $table->date('tanggal_pengerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jenis_kerusakan');
    }
};
