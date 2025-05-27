<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengembalians'; // Sesuaikan dengan nama tabel
    protected $fillable = [
        'peminjaman_id',
        'denda_id',
        'image_bukti',
        'kondisi_barang',
        'tanggal_dikembalikan',
    ];

    // Relasi dengan Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
    public function denda()
    {
        return $this->belongsTo(Denda::class);
    }
}
