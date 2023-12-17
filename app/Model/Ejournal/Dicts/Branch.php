<?php

namespace App\Model\Ejournal\Dicts;

use Illuminate\Database\Eloquent\Model;


class Branch extends Model
{
    public $timestamps = false;
    protected $table = 'dict_branches';
    protected $fillable = ['body', 'prefix'];
    protected $branch = ['id' => 0, 'body' => ''];

    public static function getTableName()
    {
        return 'dict_branches';
    }

    public function substations()
    {
        return $this->hasMany(Substation::class);
    }
}
