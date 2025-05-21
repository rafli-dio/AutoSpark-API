<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi (mass assignment).
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role_id',
        'nomor_telepon',
        'foto',
    ];

    /**
     * Kolom yang harus disembunyikan dari JSON/array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi many-to-one ke tabel `roles`.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}