<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananCuci extends Model
{
    use HasFactory;

    protected $table = 'pesanan_cucis';

    protected $fillable = [
        'user_id',
        'layanan_id',
        'layanan_tambahan_id',
        'alamat',
        'tanggal',
        'waktu',
        'plat_nomor',
        'ukuran_kendaraan_id',
        'subtotal',
        'total',
        'status',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Relasi dengan Layanan Tambahan (nullable)
    public function layananTambahan()
    {
        return $this->belongsTo(LayananTambahan::class);
    }

    // Relasi dengan Ukuran Kendaraan
    public function ukuranKendaraan()
    {
        return $this->belongsTo(UkuranKendaraan::class);
    }

    // Relasi dengan Riwayat Pesanan
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pesanan_id');
    }


}
