<?php

namespace app\src\parser;

use app\src\helpers\SimpleHtmlDom;

class HtmlDecoder extends Decoder
{

    /**
     * @return bool|SimpleHtmlDom
     */
    public function decode()
    {
        return self::getDecodingContent($this->getDataByUrl());
    }

    /**
     * @param string $content
     * @return SimpleHtmlDom|bool
     */
    public static function getDecodingContent(string $content)
    {
        return SimpleHtmlDom::str_get_html($content);
    }
}