<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationType extends Model
{
    use HasFactory;
    protected $table = 'dict_station_types';

    /**
     * Отримати всі лінії станції цього первного типу станцій.
     */
    public function lines()
    {
        return $this->hasManyThrough(Line::class, Substation::class,
        	'type_id',         // Foreign key on substations table...
        	'substation_id',   // Foreign key on lines table..
            'id',              // Local key on station_type table...
            'id'               // Local key on substations table...
        );
    }
}
