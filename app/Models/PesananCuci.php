<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananCuci extends Model
{
    use HasFactory;

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


    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }


    public function layananTambahan()
    {
        return $this->belongsToMany(LayananTambahan::class, 'pesanan_cuci_layanan_tambahan');
    }

 
    public function ukuranKendaraan()
    {
        return $this->belongsTo(UkuranKendaraan::class, 'ukuran_kendaraan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
