<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CitiesFilter extends ApiFilter {
    protected $safeParms = [
        'name' => ['eq'],
        'stateId' => ['eq'],
        'lat' => ['eq'],
        'lng' => ['eq'],
    ];

    protected $columnMap = [
        'stateId'=>'state_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}