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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_izin');
            $table->date('tgl_mulai_izin');
            $table->date('tgl_akhir_izin');
            $table->integer('total_izin');
            $table->string('foto');
            $table->boolean('validasi_1');
            $table->string('validasi_1_by');
            $table->boolean('validasi_2');
            $table->string('validasi_2_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
