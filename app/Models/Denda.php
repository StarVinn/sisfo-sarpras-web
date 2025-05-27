<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $fillable = ['name', 'description', 'nominal'];

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class);
    }
}
