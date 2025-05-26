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
        Schema::create('riwayat_pesanans', function (Blueprint $table) {
            $table->id();
             $table->foreignId('pesanan_id')->constrained('pesanan_cucis')->onDelete('cascade');
             $table->enum('status', ['pending', 'diproses', 'selesai']);
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
        Schema::dropIfExists('riwayat_pesanans');
    }
};
