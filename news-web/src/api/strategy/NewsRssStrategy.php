<?php


namespace app\src\api\strategy;


use app\src\api\NewsDto;
use app\src\parser\XmlDecoder;
use DateTime;
use Exception;
use Yii;

class NewsRssStrategy extends Strategy
{

    public const COUNT_NEWS = 20;

    /**
     * @return array|NewsDto[]
     * @throws Exception
     */
    public function execute(): array
    {
        $xmlDecoder = Yii::createObject(XmlDecoder::class, [$this->getUrl()]);
        $response = $xmlDecoder->decode();
        return $this->prepareResponse((array)$response);
    }


    /**
     * @param array $response
     * @return array
     * @throws Exception
     */
    protected function prepareResponse(array $response): array
    {
        $news = [];
        $source = isset($response['channel']->link) ? (string)$response['channel']->link : null;
        foreach ($response['channel']->item as $item) {
            $author = isset($item->author) ? (string)$item->author : '';
            $title = isset($item->title) ? (string)$item->title : '';
            $description = isset($item->description) ? (string)$item->description : '';
            $url = (string)$item->link;
            $publishedAt = (new DateTime((string)$item->pubDate))->format('Y-m-d H:i');
            $urlToImage = '';
            if (isset($item->enclosure['url'])) {
                $urlToImage = (string)$item->enclosure['url'][0];
            }
            $news[] = new NewsDto($author, $source, $title, $description, $url, $urlToImage, $publishedAt);

            if (count($news) === self::COUNT_NEWS) {
                break;
            }
        }


        return $news;
    }
}