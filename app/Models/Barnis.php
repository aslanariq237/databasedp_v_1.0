<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barnis extends Model
{
    protected $table = 'barnis';
    protected $fillable = [
        'id_tandater',
        'id_barang',
        'id_transaksi'
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
