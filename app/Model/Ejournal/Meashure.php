<?php

namespace App\Model\Ejournal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meashure extends Model
{
    use HasFactory;
    protected $table='meashures';
    protected $fillable = [
        'order_id', 'licensor','lic_date'
    ];
}



