<?php


namespace unit;


use app\src\api\NewsDto;
use app\src\api\strategy\NewsJsonStrategy;
use app\src\parser\JsonDecoder;
use Codeception\Test\Unit;
use Exception;
use UnitTester;
use Yii;

/**
 * Class NewsJsonStrategyTest
 * @package unit
 */
class NewsJsonStrategyTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $testDir = Yii::getAlias('@app') . '/tests';

        $stub = $this->getMockBuilder(JsonDecoder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDataByUrl'])
            ->getMock();
        $stub->method('getDataByUrl')->willReturn(file_get_contents($testDir . '/_data/news.json'));
        Yii::$container->set(JsonDecoder::class, $stub);

    }


    /**
     * @throws Exception
     */
    public function testExecuteSuccess(): void
    {
        $strategy = new NewsJsonStrategy('no matter which url');
        $news = $strategy->execute();
        $this->assertIsArray($news);
        $newItem = $news[0];
        $this->assertInstanceOf(NewsDto::class, $newItem);
    }

}