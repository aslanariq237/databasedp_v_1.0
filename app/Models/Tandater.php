<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tandater extends Model
{
    protected $table = "tandater"; 
    protected $fillable = [
        'id_tandater',
        'customer',
        'nama_usaha',
        'garansi'
    ];

    public function Teknisi(){
        return $this->hasMany(Teknisi::class, 'id_teknisi');
    }
    
    public function keluhan(){
        return $this->hasMany(Keluhan::class, 'id_keluhan');
    }

    public function Barang(){
        return $this->hasMany(Barang::class, 'id_tandater', 'id_tandater');
    }

    public function detkel(){
        return $this->hasMany(Detkel::class, 'id_tandater', 'id_tandater');
    }

    public function customer(){
        return $this->hasMany(Customer::class, 'id', 'id');
    }
}
