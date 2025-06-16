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
        // Tabel ini akan menghubungkan pesanan dengan layanan tambahannya
        Schema::create('pesanan_cuci_layanan_tambahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_cuci_id')->constrained()->onDelete('cascade');
            $table->foreignId('layanan_tambahan_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('pesanan_cuci_layanan_tambahan');
    }
};
