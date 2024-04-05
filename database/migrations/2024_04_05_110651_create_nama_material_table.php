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
        Schema::create('nama_material', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material');
            $table->string('nama_material');
            $table->string('jenis_pekerjaan');
            $table->string('jenis_material');
            $table->string('nama_perusahaan');
            $table->string('brand');
            $table->string('qty');
            $table->string('harga_beli');
            $table->string('ongkir');
            $table->string('harga_modal');
            $table->string('total_modal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nama_material');
    }
};
