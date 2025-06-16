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
            $table->text('alamat');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('plat_nomor');
            $table->foreignId('ukuran_kendaraan_id')->constrained('ukuran_kendaraans')->onDelete('cascade');
            $table->integer('subtotal');
            $table->integer('total');
            $table->enum('status', ['proses', 'berangkat','sampai', 'dicuci','selesai', 'gagal'])->default('proses');

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
