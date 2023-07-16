<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

class PostFilter extends ApiFilter
{
    protected array $safeParams = [
        'title' => ['eq'],
        'likesCount' => ['eq','gt','lt'],
        'publishDate' => ['eq','gt','lt']
    ];

    protected array $columnMap = [
        'likesCount' => 'likes_count',
        'publishDate' => 'publish_date'
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '=>'
    ];

}
