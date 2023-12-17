<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadeEngineer extends Model
{
    use HasFactory;
    protected $table = 'dict_brigade_engineers';
    public function branch()
    {
        return $this->belongsTo('App\Model\Ejournal\Dicts\Branch','branch_id','id');
    }
    public static function getTableName()
    {
        return 'dict_brigade_engineers';
    }
}
