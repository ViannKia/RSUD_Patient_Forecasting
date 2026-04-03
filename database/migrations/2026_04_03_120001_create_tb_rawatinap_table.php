<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_rawatinap', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 255);
            $table->string('bulan', 255);
            $table->string('jumlah_inap', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_rawatinap');
    }
};
