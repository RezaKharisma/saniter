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
        Schema::create('list_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->enum('lantai',['Lantai 1','Lantai 2','Lantai 3']);
            $table->string('nama');
            $table->string('denah')->nullable()->default('default.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_area');
    }
};
