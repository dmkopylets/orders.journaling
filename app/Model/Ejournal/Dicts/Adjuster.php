<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjuster extends Model
{
    use HasFactory;
    protected $table = 'dict_adjusters';
    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Model\Ejournal\Dicts\Branch','branch_id','id');
    }

    public static function getTableName(): string
    {
        return 'dict_adjusters';
    }

}
