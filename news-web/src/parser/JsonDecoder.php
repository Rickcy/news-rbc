<?php


namespace app\src\parser;


use yii\helpers\Json;

class JsonDecoder extends Decoder
{

    /**
     * @return null|array
     */
    public function decode(): ?array
    {
        return self::getDecodingContent($this->getDataByUrl());
    }

    public static function getDecodingContent(string $content)
    {
        return Json::decode($content);
    }
}