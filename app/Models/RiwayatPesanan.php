<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPesanan extends Model
{
    use HasFactory;

    protected $fillable = ['pesanan_id', 'status'];

    public function pesanan()
    {
        return $this->belongsTo(PesananCuci::class, 'pesanan_id');
    }
}
