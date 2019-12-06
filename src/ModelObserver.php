<?php

namespace Laravie\DynamoDb;

/**
 * Class ModelObserver.
 */
class ModelObserver
{
    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    protected $dynamoDbClient;

    /**
     * @var \Aws\DynamoDb\Marshaler
     */
    protected $marshaler;

    /**
     * @var \Laravie\DynamoDb\EmptyAttributeFilter
     */
    protected $attributeFilter;

    public function __construct(DynamoDbClientInterface $dynamoDb)
    {
        $this->dynamoDbClient = $dynamoDb->getClient();
        $this->marshaler = $dynamoDb->getMarshaler();
        $this->attributeFilter = $dynamoDb->getAttributeFilter();
    }

    private function saveToDynamoDb($model)
    {
        $attrs = $model->attributesToArray();

        \rescue(function () use ($model) {
            $this->dynamoDbClient->putItem([
                'TableName' => $model->getDynamoDbTableName(),
                'Item' => $this->marshaler->marshalItem($attrs),
            ]);
        });
    }

    private function deleteFromDynamoDb($model)
    {
        $key = [$model->getKeyName() => $model->getKey()];

        \rescue(function () use ($model) {
            $this->dynamoDbClient->deleteItem([
                'TableName' => $model->getDynamoDbTableName(),
                'Key' => $this->marshaler->marshalItem($key),
            ]);
        });
    }

    public function created($model)
    {
        $this->saveToDynamoDb($model);
    }

    public function updated($model)
    {
        $this->saveToDynamoDb($model);
    }

    public function deleted($model)
    {
        $this->deleteFromDynamoDb($model);
    }

    public function restored($model)
    {
        $this->saveToDynamoDb($model);
    }
}
