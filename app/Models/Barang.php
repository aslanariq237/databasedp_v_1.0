<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'detailbarang';
    protected $fillable = [
        'id_customer',
        'id_tandater',
        'nama_barang',
        'SN',
        'banyak_barang'
    ];

    public function tandater()
    {
        return $this->belongsTo(Tandater::class, 'id_tandater', 'id_tandater');
    }

    public function detkel(){
        return $this->hasMany(Detkel::class, 'id', 'id_barang');
    }

    public function barnis(){
        return $this->belongsTo(Barnis::class, 'id_barang', 'id');
    }

    public function teknisi(){
        return $this->belongsTo(Teknisi::class, 'id_teknisi');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'id_customer','id');
    }    
}

