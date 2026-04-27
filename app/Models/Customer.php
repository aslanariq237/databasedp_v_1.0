<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";
    protected $fillable = [
        "nama_toko",
        "kode_toko",
        "Toko",
        "pic",
        "NPWP",
        "no_telp",
        "alamat"
    ];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_customer');
    }
}
