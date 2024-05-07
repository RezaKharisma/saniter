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
        Schema::create('detail_pekerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_kerusakan_id');
            $table->unsignedBigInteger('pekerja_id');
            $table->string('nama');
            $table->decimal('upah', 25, 2);
            $table->decimal('volume');
            $table->string('satuan');
            $table->decimal('total_harga', 25, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pekerja');
    }
};
