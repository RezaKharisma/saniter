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
            $table->string('satuan');
            $table->enum('kategori_material', ['Material Lantai, Kolom, Dinding', 'Material Pengecatan', 'Material Perekat', 'Material Plafond', 'Material Pintu, Jendela, Kusen, dan Aksesoris', 'Material Aksesoris Toilet']);
            $table->double('harga', 25, 2);
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
