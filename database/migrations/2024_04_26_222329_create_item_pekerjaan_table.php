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
        Schema::create('item_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sub_kategori_pekerjaan');
            $table->string('nama');
            $table->decimal('volume');
            $table->decimal('harga', 25, 2);
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pekerjaan');
    }
};
