<?php


namespace app\src\parser;


interface IDecoder
{
    public function decode();

    public static function getDecodingContent(string $content);
}