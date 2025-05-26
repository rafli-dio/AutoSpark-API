<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranKendaraan extends Model
{
    use HasFactory;

    protected $table = 'ukuran_kendaraans';

    protected $fillable = [
        'ukuran',
        'harga',
    ];

    public function pesanancucis()
    {
        return $this->belongsToMany(PesananCuci::class);
    }
}
