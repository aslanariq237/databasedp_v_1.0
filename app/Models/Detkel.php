<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detkel extends Model
{
    protected $table = 'detkel';
    protected $fillable = [
        'id_barang',
        'id_tandater',
        'nama_keluhan',
        'biaya_keluhan'
    ];

    public function tandater(){
        return $this->belongsTo(Tandater::class, 'id_tandater', 'id_tandater');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }
}
