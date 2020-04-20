<?php


namespace app\src\repository;


use app\src\api\IResponse;

interface IRepository
{
    /**
     * Сохраняем в хранилище
     *
     * @param IResponse $response
     * @return bool
     */
    public function insert(IResponse $response): bool;


    /**
     * Сохраняем в хранилище партией
     *
     * @param array $responses
     * @return mixed
     */
    public function batchInsert(array $responses): bool;


    /**
     *
     * Изменяем сущность
     *
     * @param int $id
     * @param IResponse $response
     * @return bool
     */
    public function update(int $id, IResponse $response): bool;


    /**
     *
     * Выбираем запись по id
     *
     * @param int $id
     * @return IResponse
     */
    public function get(int $id): ?IResponse;


    /**
     *  Выбираем все записи
     *
     * @return array|IResponse[]
     */
    public function all(): array;


    /**
     *
     * Выбираем записи по условию
     *
     * @param array $condition
     * @return mixed
     */
    public function getAllByCondition(array $condition): array;


    /**
     *
     * Выбираем запись по условию
     *
     * @param array $condition
     * @return IResponse|null
     */
    public function getOneByCondition(array $condition): ?IResponse;
}