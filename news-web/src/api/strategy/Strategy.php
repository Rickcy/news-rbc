<?php


namespace app\src\api\strategy;


/**
 * Class Strategy
 * @package app\src\api
 */
abstract class Strategy implements IStrategy
{
    /**
     * @var
     */
    private $url;

    /**
     * Strategy constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


    abstract protected function prepareResponse(array $response): array;


}