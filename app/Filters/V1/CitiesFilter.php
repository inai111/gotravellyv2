<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CitiesFilter extends ApiFilter {
    protected $safeParms = [
        'name' => ['eq','ne'],
        'stateId' => ['eq','ne'],
        'lat' => ['eq','ne'],
        'lng' => ['eq','ne'],
    ];

    protected $columnMap = [
        'stateId'=>'state_id'
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