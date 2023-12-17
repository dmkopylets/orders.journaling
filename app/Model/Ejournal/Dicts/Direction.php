<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;
    protected $table = 'dict_station_types';

    public function type()
    {
        return $this->hasOne(Substation::class);
    }
}
