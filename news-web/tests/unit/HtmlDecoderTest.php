<?php


namespace unit;


use app\src\parser\HtmlDecoder;
use Codeception\Test\Unit;
use UnitTester;
use Yii;
use yii\base\InvalidConfigException;

class HtmlDecoderTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;


    public function testGetDecodingContentIsFalse(): void
    {
        $htmlDecoder = HtmlDecoder::getDecodingContent('');
        $this->assertFalse($htmlDecoder);
    }

    public function testGetDecodingContentValid(): void
    {
        $htmlDecoder = HtmlDecoder::getDecodingContent('<html><head></head><body><div></div></body></html>');
        $this->assertNotFalse($htmlDecoder);
    }

    public function testDecodeIsFail()
    {
        $htmlDecoder = new HtmlDecoder('');
        $document = $htmlDecoder->decode();
        $this->assertFalse($document);
    }

    /**
     * @throws InvalidConfigException
     */
    public function testDecodeIsSuccess(): void
    {
        $stub = $this->getMockBuilder(HtmlDecoder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataByUrl'])
            ->getMock();
        $stub->method('getDataByUrl')->willReturn('<html><head></head><body><div></div></body></html>');
        Yii::$container->set(HtmlDecoder::class, $stub);
        $xmlDecoder = Yii::createObject(HtmlDecoder::class, ['https://google.com']);
        $document = $xmlDecoder->decode();
        $this->assertNotFalse($document);
    }


}