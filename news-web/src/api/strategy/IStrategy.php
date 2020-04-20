<?php


namespace app\src\api\strategy;


use app\src\api\IResponse;

/**
 * Interface IStrategy
 * @package app\src\api\strategy
 */
interface IStrategy
{

    /**
     * @return array|IResponse[]
     */
    public function execute(): array;

}