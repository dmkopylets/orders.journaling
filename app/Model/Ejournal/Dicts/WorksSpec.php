<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorksSpec extends Model
{
    use HasFactory;
    protected $table = 'dict_works_specs';
    public static function getTableName()
    {
        return 'dict_works_spec';
    }
}
