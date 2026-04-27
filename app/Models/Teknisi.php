<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    protected $table = "teknisi";
    protected $primaryKey = 'id_teknisi';
    protected $fillable = [
        "nama_teknisi",
        "status"
    ];

    public function tandaters(){
        return $this->belongsTo(Tandater::class, 'id_teknisi');
    }

    public function detailbarang(){
        return $this->belongsTo(Barang::class, 'id_teknisi');
    }
}
