<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class StatesFilter extends ApiFilter {
    protected $safeParms = [
        'name' => ['eq','ne'],
        'countryId' => ['eq','ne'],
    ];

    protected $columnMap = [
        'countryId'=>'country_id'
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