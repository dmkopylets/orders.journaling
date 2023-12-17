<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Http\Controllers\Ejournal\BaseController;
use Illuminate\Http\Request;

class DictBaseController extends BaseController
{
    public function getList(Request $request, string $repertory)
    {
        $searchMyBody = '%' . $request->input('searchMybody') . '%';
        $searchMyPrefix = '%' . $request->input('searchMyprefix') . '%';
        $records =  $repertory::
        where('body', 'like', $searchMyBody)->
        where('prefix', 'like', $searchMyPrefix)->
        orderBy('id')->get();
        return ($records);
    }
}
