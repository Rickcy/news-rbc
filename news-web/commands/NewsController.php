<?php


namespace app\commands;


use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use Amp\Loop;
use app\models\News;
use app\src\api\ApiService;
use app\src\api\IResponse;
use app\src\api\NewsDto;
use app\src\api\strategy\NewsJsonStrategy;
use app\src\api\strategy\NewsRssStrategy;
use app\src\parser\HtmlDecoder;
use app\src\helpers\SimpleHtmlDom;
use app\src\helpers\SimpleHtmlDomNode;
use app\src\repository\IRepository;
use app\src\repository\NewsActiveRecordRepository;
use Throwable;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;

/**
 * Class NewsController
 * @package app\commands
 */
class NewsController extends Controller
{

    /** @var NewsActiveRecordRepository */
    private $repository;

    /**
     * @var string
     */
    protected const RSS_URL = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
    /**
     * @var string
     */
    protected const JSON_URL = 'https://newsapi.org/v2/everything?sources=rbc&apiKey=21a0153720b649de960a45681095c91a';

    /**
     * NewsController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @param IRepository|null $repository
     */
    public function __construct($id, $module, $config = [], IRepository $repository = null)
    {
        $this->repository = $repository ?? new NewsActiveRecordRepository();
        parent::__construct($id, $module, $config);
    }


    /**
     * Команда для парсинга новостей с RSS ресурсов
     * @param string $url
     * @return int
     */
    public function actionLoadRss($url = self::RSS_URL): int
    {

        $tx = Yii::$app->db->beginTransaction();
        try {

            $api = new ApiService(new NewsRssStrategy($url));

            $this->stdout('Берём новости с ' . $url . "\n");
            /** Делаем запрос и получаем обработанныей ответ @see NewsDto */
            /** @var NewsDto[] $news */
            $news = $api->send();

            $this->stdout('Кол-во новостей: ' . count($news) . "\n");

            $this->process($news, false);

            $tx->commit();
        } catch (Throwable $e) {
            $tx->rollBack();
            $this->stdout($e->getMessage() . "\n");
            return ExitCode::DATAERR;
        }

        $this->stdout('Данные успешно сохранены' . "\n");

        return ExitCode::OK;
    }

    /**
     * Команда для парсинга новостей с JSON ресурсов
     * @param string $url
     * @return int
     */
    public function actionLoadJson($url = self::JSON_URL): int
    {

        $tx = Yii::$app->db->beginTransaction();
        try {


            $api = new ApiService(new NewsJsonStrategy($url));

            $this->stdout('Бёрем новости с ' . $url . "\n");

            /** Делаем запрос и получаем  ответ @see NewsDto */
            /** @var NewsDto[] $news */
            $news = $api->send();

            $this->stdout('Кол-во новостей: ' . count($news) . "\n");

            /* Обрабатываем и созраняем в базу */
            $this->process($news, false);

            $tx->commit();
        } catch (Throwable $e) {
            $tx->rollBack();
            $this->stdout($e->getMessage() . "\n");

            return ExitCode::DATAERR;
        }

        $this->stdout('Данные успешно сохранены' . "\n");

        return ExitCode::OK;
    }


    /**
     * @param array $news
     * @param bool $async
     * @throws Throwable
     */
    protected function process(array $news, bool $async = false): void
    {

        if ($async) {
            /* Асинхронно */
            $news = $this->async($news, 10);
        } else {
            /* Синхронно */
            $news = $this->sync($news);
        }

        /* Сохраняем в хранилище
         * Если новости не уникальны SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry
         */
        try {
            $this->repository->batchInsert($news);
        } catch (Exception $dbException) {
            $this->stdout($dbException->getMessage() . "\n");
            $this->stdout('Не удалось сохранить партией, нарушена уникальность' . "\n");
            $this->stdout('Пытаемся сохранить по одной' . "\n");
            foreach ($news as $article) {
                $this->repository->insert($article);
            }
        }
    }


    /**
     * Парсим страницы синхронно
     *
     * @param array $news
     * @return array
     */
    private function sync(array &$news): array
    {
        foreach ($news as $article) {
            $htmlDecoder = new HtmlDecoder($article->getUrl());

            /** @var SimpleHtmlDom $htmlDocument */
            $htmlDocument = $htmlDecoder->decode();

            /* Находим блоки с нашим текстом*/
            $pBlocks = $htmlDocument->find('.article__text_free p');

            $content = '';
            /** @var SimpleHtmlDomNode $p */
            foreach ($pBlocks as $p) {
                $content .= $p->text();
            }
            $article->setContent($content);
        }

        return $news;
    }

    /**
     *
     * Парсим страницы ассинхронно (быстрее 2-3 раза)
     *
     * @param array $news
     * @param int $numbersChunk
     * @return array
     */
    private function async(array &$news, $numbersChunk = 5): array
    {

        $newsChunks = array_chunk($news, $numbersChunk);

        Loop::run(static function () use ($newsChunks) {

            foreach ($newsChunks as $newsChunk) {

                $client = HttpClientBuilder::buildDefault();

                $responses = yield array_map(static function (NewsDto $article) use ($client) {
                    return $client->request(new Request($article->getUrl()));
                }, $newsChunk);

                /**
                 * @var  $key
                 * @var Response $response
                 */
                foreach ($responses as $key => $response) {
                    $content = yield $response->getBody()->buffer();
                    $uri = $response->getRequest()->getUri();
                    $url = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();
                    /** @var NewsDto $news */
                    foreach ($newsChunk as $news) {
                        if ($url === $news->getUrl()) {
                            $htmlDocument = HtmlDecoder::getDecodingContent($content);
                            /* Находим блоки с нашим текстом*/
                            $pBlocks = $htmlDocument->find('.article__text_free p');

                            $content = '';
                            /** @var SimpleHtmlDomNode $p */
                            foreach ($pBlocks as $p) {
                                $content .= $p->text();
                            }
                            $news->setContent($content);
                        }
                    }
                }
            }
        });

        return $news;
    }
}