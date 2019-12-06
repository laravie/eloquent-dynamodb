<?php

namespace Laravie\DynamoDb;

use Aws\DynamoDb\Marshaler;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Laravie\DynamoDb\DynamoDb\DynamoDbManager;

class DynamoDbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        DynamoDbModel::setDynamoDbClientService($this->app->make(DynamoDbClientInterface::class));

        $this->publishes([
            __DIR__.'/../config/dynamodb.php' => app()->basePath('config/dynamodb.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $marshalerOptions = [
            'nullify_invalid' => true,
        ];

        $this->app->singleton(DynamoDbClientInterface::class, static function () use ($marshalerOptions) {
            $client = new DynamoDbClientService(new Marshaler($marshalerOptions), new EmptyAttributeFilter());

            return $client;
        });

        $this->app->singleton('dynamodb', static function (Container $app) {
            return new DynamoDbManager($this->app->make(DynamoDbClientInterface::class));
        });
    }
}
