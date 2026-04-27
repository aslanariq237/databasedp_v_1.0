<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_customer',
        'id_final',
        'no_invoice',
        'id_tandater',
        'total_biaya',
        'ppn',
        'jasa_service'
    ];

    protected $primarykey = 'id_transaksi';

    protected $casts = [
        'created_at' => 'datetime',
    ];    

    public function final()
    {
        return $this->belogsTo(Finish::class, 'id_final', 'id_final');
    }
    public function finishes()
    {
        return $this->belogsTo(Finish::class, 'id_final', 'id_final');
    }

    public function tandater()
    {
        return $this->belongsTo(Tandater::class, 'id_tandater', 'id_tandater');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'id');
    }

    public function barnis()
    {
        return $this->hasMany(Barnis::class, 'id_transaksi', 'id_transaksi');
    }

}
