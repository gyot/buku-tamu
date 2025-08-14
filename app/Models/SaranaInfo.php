<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaInfo extends Model
{
    protected $fillable = [
        'sarana',
        'status',
        'keterangan',
        'mulai',
        'sampai',
        'ditampilkan'
    ];
}
