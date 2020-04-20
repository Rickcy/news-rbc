<?php


namespace app\src\api;


interface IResponse
{
    public function toArray(): array;
}