<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CountriesFilter extends ApiFilter {
    protected $safeParms = [
        'shortCode' => ['eq','ne'],
        'name' => ['eq','ne'],
        'timezone' => ['eq','ne'],
        'phoneCode' => ['eq','ne'],
        'continentId' => ['eq','ne'],
    ];

    protected $columnMap = [
        'shortCode'=>'short_code',
        'phoneCode'=>'phone_code',
        'continentId'=>'continent_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}