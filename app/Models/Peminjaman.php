<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjamen'; // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'user_id',
        'barang_id',
        'kelas_peminjam',
        'alasan_peminjam',
        'tanggal_peminjaman',
        'status',
        'alasan_penolakan', // added rejection reason
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

     // Relasi dengan Pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
