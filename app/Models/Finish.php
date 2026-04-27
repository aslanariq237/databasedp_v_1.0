<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $protected = 'final';

    protected $primaryKey = 'id_final';
    
    protected $fillable = [
        'id_tandater',        
        'total_biaya',
        'no_invoice',
        'jasa_service',
        'ppn',
        'status_pay'
    ];
}
