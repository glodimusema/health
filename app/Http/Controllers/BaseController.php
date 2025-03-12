<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    public function executeWithoutReturn (string $procedureName, array $params)
    {
        $params = collect($params);

        $queryParams = $params->map(fn() => '?')->join(',');

        $query = "call $procedureName($queryParams)";

        // dd($query);
        // $params = $params->mapWithKeys(fn($value, $key) => [":$key" => $value])->toArray();

        // $params = $params->mapWithKeys(function ($value, $key) {
        //     return [":$key" => $value];
        // })->toArray();

        return DB::select($query, $params->values()->toArray());  
    }

    public function deleteAll (string $tableName, string $field, string $value)
    {
        return DB::table($tableName)->where($field, $value)->delete();
    }
}
