<?php


namespace app\src\api;


use app\src\api\strategy\IStrategy;

/**
 *
 * Сервис предназначен для работы с внешними ресурсами
 *
 * Class ApiService
 * @package app\src\api
 */
class ApiService
{
    /** @var IStrategy */
    private $strategy;

    /**
     * ApiService constructor.
     * @param IStrategy $strategy
     */
    public function __construct(IStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Делаем запрос на ресурс согласно выбранной стратегии
     *
     * @return array|IResponse[]
     */
    public function send(): array
    {
        return $this->strategy->execute();
    }
}