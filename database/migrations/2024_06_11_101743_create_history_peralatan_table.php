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
        Schema::create('history_peralatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peralatan_id');
            $table->unsignedBigInteger('detail_peralatan_id');
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
        Schema::dropIfExists('history_peralatan');
    }
};
