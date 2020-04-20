<?php


namespace app\src\repository;


use app\src\api\IResponse;

class NewsRedisRepository implements IRepository
{

    /**
     * @inheritDoc
     */
    public function insert(IResponse $response): bool
    {
        // TODO: Implement insert() method.
    }

    /**
     * @inheritDoc
     */
    public function batchInsert(array $responses): bool
    {
        // TODO: Implement batchInsert() method.
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, IResponse $response): bool
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?IResponse
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function getAllByCondition(array $condition): array
    {
        // TODO: Implement getAllByCondition() method.
    }

    /**
     * @inheritDoc
     */
    public function getOneByCondition(array $condition): ?IResponse
    {
        // TODO: Implement getOneByCondition() method.
    }
}