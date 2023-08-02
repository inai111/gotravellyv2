<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CountriesFilter extends ApiFilter {
    protected $safeParms = [
        'shortCode' => ['eq'],
        'name' => ['eq'],
        'timezone' => ['eq'],
        'phoneCode' => ['eq'],
        'continentId' => ['eq'],
    ];

    protected $columnMap = [
        'shortCode'=>'short_code',
        'phoneCode'=>'phone_code',
        'continentId'=>'continent_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}