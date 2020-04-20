<?php


namespace unit;


use app\src\api\ApiService;
use app\src\api\NewsDto;
use app\src\api\strategy\NewsRssStrategy;
use app\src\parser\XmlDecoder;
use Codeception\Test\Unit;
use Exception;
use UnitTester;
use Yii;

class NewsRssStrategyTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $testDir = Yii::getAlias('@app') . '/tests';

        $stub = $this->getMockBuilder(XmlDecoder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataByUrl'])
            ->getMock();
        $stub->method('getDataByUrl')->willReturn(file_get_contents($testDir . '/_data/news-rss.xml'));
        Yii::$container->set(XmlDecoder::class, $stub);

    }


    /**
     * @throws Exception
     */
    public function testExecuteSuccess(): void
    {
        $strategy = new NewsRssStrategy('no matter which url');
        $news = $strategy->execute();
        $this->assertIsArray($news);
        $newItem = $news[0];
        $this->assertInstanceOf(NewsDto::class, $newItem);
    }

}