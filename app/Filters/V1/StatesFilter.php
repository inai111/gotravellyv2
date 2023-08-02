<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class StatesFilter extends ApiFilter {
    protected $safeParms = [
        'name' => ['eq'],
        'countryId' => ['eq'],
    ];

    protected $columnMap = [
        'countryId'=>'country_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}