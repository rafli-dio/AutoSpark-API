<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MetodePembayaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'tipe',
        'nomor',
        'atas_nama',
        'logo', 
    ];

    /**
     * The accessors to append to the model's array form.
     * Ini memberi tahu Laravel untuk SELALU menyertakan atribut 'logo_url' saat model diubah menjadi JSON.
     *
     * @var array
     */
    protected $appends = ['logo_url'];

    /**
     * Accessor untuk atribut 'logo_url'.
     * Nama fungsi ini (getLogoUrlAttribute) harus cocok dengan nilai di $appends.
     *
     * @return string|null
     */
    public function getLogoUrlAttribute() 
    {
        if ($this->logo) {
            return Storage::disk('public')->url($this->logo);
        }

        return null;
    }
}
