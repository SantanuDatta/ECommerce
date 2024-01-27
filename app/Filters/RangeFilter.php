<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class RangeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (!is_string($value)) {
            // Value is not a string, so we don't filter on this property
            return $query;
        }

        [$min, $max] = explode(',', $value);

        return $query->whereBetween('regular_price', [$min, $max]);
    }
}
