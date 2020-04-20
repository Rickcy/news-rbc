<?php


namespace unit;


use app\src\parser\JsonDecoder;
use Codeception\Test\Unit;
use UnitTester;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

class JsonDecoderTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;


    public function testGetDecodingContentIs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        JsonDecoder::getDecodingContent('{asd}xxzc');
    }


    public function testGetDecodingContentIsEmpty(): void
    {
        $htmlDecoder = JsonDecoder::getDecodingContent('');
        $this->assertNull($htmlDecoder);
    }

    public function testGetDecodingContentValid(): void
    {
        $htmlDecoder = JsonDecoder::getDecodingContent('{"news" : [{"title": "Новость 1"}, {"title" : "Новость 2"}]}');
        $this->assertNotFalse($htmlDecoder);
    }


    public function testDecodeIsFail(): void
    {
        $jsonDecoder = new JsonDecoder('');
        $document = $jsonDecoder->decode();
        $this->assertFalse((bool)$document);
    }

    /**
     * @throws InvalidConfigException
     */
    public function testDecodeIsSuccess(): void
    {
        $stub = $this->getMockBuilder(JsonDecoder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataByUrl'])
            ->getMock();
        $stub->method('getDataByUrl')->willReturn('{"news" : [{"title": "Новость 1"}, {"title" : "Новость 2"}]}');
        Yii::$container->set(JsonDecoder::class, $stub);
        $xmlDecoder = Yii::createObject(JsonDecoder::class, ['https://google.com']);
        $document = $xmlDecoder->decode();
        $this->assertNotFalse($document);
    }

}