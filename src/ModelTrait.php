<?php

namespace Laravie\DynamoDb;

use Illuminate\Support\Facades\App;

trait ModelTrait
{
    public static function boot()
    {
        parent::boot();

        $observer = static::getObserverClassName();

        static::observe(new $observer(
            App::make('Laravie\DynamoDb\DynamoDbClientInterface')
        ));
    }

    public static function getObserverClassName()
    {
        return 'Laravie\DynamoDb\ModelObserver';
    }

    public function getDynamoDbTableName()
    {
        return $this->getTable();
    }
}
