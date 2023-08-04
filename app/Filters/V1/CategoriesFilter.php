<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CategoriesFilter extends ApiFilter {
    protected $safeParms = [
        'name' => ['eq','ne'],
        'active' => ['eq','ne'],
        'priorityOrder' => ['eq','ne','lt','lte','gt','gte'],
    ];

    protected $columnMap = [
        'priorityOrder'=>'priority_order'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];
}