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
        Schema::create('detail_item_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_kerusakan_id');
            $table->unsignedBigInteger('item_pekerjaan_id');
            $table->string('nama');
            $table->decimal('harga', 25, 2);
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
        Schema::dropIfExists('detail_item_pekerjaan');
    }
};
