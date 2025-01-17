<?php

namespace Laravie\DynamoDb;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

class DynamoDbClientService implements DynamoDbClientInterface
{
    /**
     * @var array
     */
    protected $clients;

    /**
     * @var \Aws\DynamoDb\Marshaler
     */
    protected $marshaler;

    /**
     * @var \Laravie\DynamoDb\EmptyAttributeFilter
     */
    protected $attributeFilter;

    public function __construct(Marshaler $marshaler, EmptyAttributeFilter $filter)
    {
        $this->marshaler = $marshaler;
        $this->attributeFilter = $filter;
        $this->clients = [];
    }

    /**
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function getClient($connection = null)
    {
        $connection = $connection ?: \config('dynamodb.default');

        if (isset($this->clients[$connection])) {
            return $this->clients[$connection];
        }

        $config = \config("dynamodb.connections.$connection", []);
        $config['version'] = '2012-08-10';
        $config['debug'] = $this->getDebugOptions($config['debug'] ?? false);

        $client = new DynamoDbClient($config);

        $this->clients[$connection] = $client;

        return $client;
    }

    /**
     * @return \Aws\DynamoDb\Marshaler
     */
    public function getMarshaler()
    {
        return $this->marshaler;
    }

    /**
     * @return \Laravie\DynamoDb\EmptyAttributeFilter
     */
    public function getAttributeFilter()
    {
        return $this->attributeFilter;
    }

    protected function getDebugOptions($debug = false)
    {
        if ($debug === true) {
            $logfn = static function ($msg) {
                \info($msg);
            };

            return ['logfn' => $logfn];
        }

        return $debug;
    }
}
