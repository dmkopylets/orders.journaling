<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $table = 'dict_lines';

    public static function getTableName()
    {
        return 'dict_lines';
    }

    public function substation()
    {
        return $this->belongsTo(Substation::class,'substation_id','id');
    }
}
