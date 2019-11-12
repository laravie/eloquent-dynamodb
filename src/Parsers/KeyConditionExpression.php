<?php

namespace Laravie\DynamoDb\Parsers;

use Illuminate\Support\Arr;
use Laravie\DynamoDb\ComparisonOperator;

class KeyConditionExpression extends ConditionExpression
{
    protected function getSupportedOperators()
    {
        return Arr::only(static::OPERATORS, [
            ComparisonOperator::EQ,
            ComparisonOperator::LE,
            ComparisonOperator::LT,
            ComparisonOperator::GE,
            ComparisonOperator::GT,
            ComparisonOperator::BEGINS_WITH,
            ComparisonOperator::BETWEEN,
        ]);
    }
}
