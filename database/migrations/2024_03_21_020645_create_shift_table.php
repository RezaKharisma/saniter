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
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('regional_id');
            $table->boolean('is_diff_day')->default(0);
            $table->string('timezone');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->integer('terlambat_1');
            $table->double('potongan_1');
            $table->integer('terlambat_2');
            $table->double('potongan_2');
            $table->integer('terlambat_3');
            $table->double('potongan_3');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift');
    }
};
