<?php


namespace app\src\api\strategy;


use app\src\api\NewsDto;
use app\src\parser\JsonDecoder;
use DateTime;
use Exception;
use Yii;
use yii\helpers\Json;

/**
 *
 * Class NewsJsonStrategy
 * @package app\src\api\strategy
 */
class NewsJsonStrategy extends Strategy
{

    /**
     * Выполняем
     *
     * @return array|NewsDto[]
     * @throws Exception
     */
    public function execute(): array
    {
        $jsonDecoder = Yii::createObject(JsonDecoder::class, [$this->getUrl()]);
        $response = $jsonDecoder->decode();
        return $this->prepareResponse($response);
    }

    /**
     *
     * Подготавливаем ответ
     *
     * @param array|NewsDto[] $response
     * @return array
     * @throws Exception
     */
    protected function prepareResponse(array $response): array
    {
        $news = [];

        foreach ($response['articles'] as $article) {
            $author = $article['author'] ?? '';
            $source = $article['source']['id'] ?? '';
            $title = $article['title'] ?? '';
            $description = $article['description'] ?? '';
            $url = $article['url'];
            $publishedAt = (new DateTime($article['publishedAt']))->format('Y-m-d H:i');
            $urlToImage = $article['urlToImage'] ?? '';
            $news[] = new NewsDto($author, $source, $title, $description, $url, $urlToImage, $publishedAt);
        }

        return $news;
    }
}