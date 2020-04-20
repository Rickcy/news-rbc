<?php

namespace app\src\parser;

use SimpleXMLElement;

class XmlDecoder extends Decoder
{
    /**
     * @return bool|SimpleXMLElement
     */
    public function decode()
    {
        return self::getDecodingContent($this->getDataByUrl());
    }

    /**
     * @param string $content
     * @return bool|SimpleXMLElement
     */
    public static function getDecodingContent(string $content)
    {
        return simplexml_load_string($content);
    }
}