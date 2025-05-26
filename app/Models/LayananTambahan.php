<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananTambahan extends Model
{
    use HasFactory;

    protected $table = 'layanan_tambahans';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'gambar',
    ];

    /**
     * Relasi ke pesanan melalui tabel pivot
     */
    public function pesanancucis()
    {
        return $this->belongsToMany(PesananCuci::class);
    }
}

