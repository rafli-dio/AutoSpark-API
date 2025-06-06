<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan_cucis')->onDelete('cascade');
            $table->foreignId('metode_pembayaran_id')->nullable()->constrained('metode_pembayarans')->onDelete('cascade');
            $table->string('bukti_pembayaran')->nullable(); 
            $table->enum('status', ['menunggu verifikasi', 'berhasil', 'gagal'])->default('menunggu verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};
