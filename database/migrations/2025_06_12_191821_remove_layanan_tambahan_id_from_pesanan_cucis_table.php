<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan_cucis', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['layanan_tambahan_id']);
            // Hapus kolomnya
            $table->dropColumn('layanan_tambahan_id');
        });
    }

    public function down()
    {
        Schema::table('pesanan_cucis', function (Blueprint $table) {
            $table->foreignId('layanan_tambahan_id')->nullable()->constrained('layanan_tambahans')->onDelete('set null');
        });
    }
};
