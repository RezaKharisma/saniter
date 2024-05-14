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
        Schema::create('history_prestasi_phisik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_pekerjaan_id');
            $table->unsignedBigInteger('detail_item_pekerjaan_id');
            $table->date('tanggal');
            $table->double('volume');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_prestasi_phisik');
    }
};
