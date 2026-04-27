<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $table = "keluhan";
    protected $fillable = [
        "keluhan",
        "biaya_keluhan"
    ];

    public function tandater(){
        return $this->belogsTo(Tandater::class, 'id_keluhan');
    }       
}
