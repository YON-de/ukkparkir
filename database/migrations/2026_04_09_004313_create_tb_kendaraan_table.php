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
        Schema::create('tb_kendaraan', function (Blueprint $table) {
    $table->id('id_kendaraan');
    $table->string('plat_nomor')->unique();
    $table->enum('jenis_kendaraan', ['motor','mobil','lainnya']);
    $table->string('warna');
    $table->string('pemilik');
    $table->unsignedBigInteger('id_user')->nullable();
    $table->foreign('id_user')->references('id_user')->on('tb_user')->nullOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kendaraan');
    }
};
