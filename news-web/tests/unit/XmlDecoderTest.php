<?php


namespace unit;


use app\src\parser\XmlDecoder;
use Codeception\Test\Unit;
use Exception;
use UnitTester;
use Yii;
use yii\base\InvalidConfigException;

class XmlDecoderTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;


    public function testGetDecodingContentIsFalse(): void
    {
        $htmlDecoder = XmlDecoder::getDecodingContent('');
        $this->assertFalse($htmlDecoder);
    }

    public function testGetDecodingContentValid(): void
    {
        $htmlDecoder = XmlDecoder::getDecodingContent('<html><head></head><body><div></div></body></html>');
        $this->assertNotFalse($htmlDecoder);
    }


    public function testGetDecodingContentNotValid(): void
    {
        $this->expectException(Exception::class);
        XmlDecoder::getDecodingContent('1<html><head></head><body><div></div></body></html>');

    }


    public function testDecodeIsFail()
    {
        $xmlDecoder = new XmlDecoder('');
        $document = $xmlDecoder->decode();
        $this->assertFalse($document);
    }

    /**
     * @throws InvalidConfigException
     */
    public function testDecodeIsSuccess(): void
    {
        $stub = $this->getMockBuilder(XmlDecoder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataByUrl'])
            ->getMock();
        $stub->method('getDataByUrl')->willReturn('<html><head></head><body><div></div></body></html>');
        Yii::$container->set(XmlDecoder::class, $stub);
        $xmlDecoder = Yii::createObject(XmlDecoder::class, ['https://google.com']);
        $document = $xmlDecoder->decode();
        $this->assertNotFalse($document);
    }
}