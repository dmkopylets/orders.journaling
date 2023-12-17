<?php

declare(strict_types=1);

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypicalTask extends Model
{
    use HasFactory;

    protected $table = 'dict_typicaltasks';

    public static function getTableName()
    {
        return 'dict_typicaltasks';
    }

    public function works_spec()
    {
        return $this->belongsTo(WorksSpec::class, 'works_specs_id', 'id');
    }
}
