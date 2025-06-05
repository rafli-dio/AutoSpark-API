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
         Schema::create('pesanan_cucis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('layanan_tambahan_id')->nullable()->constrained('layanan_tambahans')->onDelete('set null');
            $table->foreignId('metode_pembayaran_id')->nullable()->constrained('metode_pembayarans')->onDelete('cascade');
            $table->text('alamat');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('plat_nomor');
            $table->foreignId('ukuran_kendaraan_id')->constrained('ukuran_kendaraans')->onDelete('cascade');
            $table->integer('subtotal');
            $table->integer('total');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
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
        Schema::dropIfExists('pesanan_cucis');
    }
};
