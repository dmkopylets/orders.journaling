<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    use HasFactory;
    protected $table = 'dict_substations';

    public function lines()
    {
        return $this->hasMany(Line::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }


    public function stationType()
    {
        return $this->belongsTo(StationType::class,'type_id','id');
    }

     public static function getTableName()
    {
        return 'dict_substations';
    }
}
