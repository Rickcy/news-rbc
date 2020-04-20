<?php


namespace app\src\repository;


use app\models\News;
use app\src\api\IResponse;
use app\src\api\NewsDto;
use Throwable;
use Yii;
use yii\helpers\StringHelper;

class NewsActiveRecordRepository implements IRepository
{

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function insert(IResponse $response): bool
    {
        $newsItem = new News($response->toArray());
        return $newsItem->insert();
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function batchInsert(array $responses): bool
    {

        $columns = News::getTableSchema()->columns;
        unset($columns['id']);

        $numbersRow = Yii::$app->db->createCommand()
            ->batchInsert(
                News::tableName(),
                array_keys($columns),
                array_map(static function (IResponse $response) {
                    return $response->toArray();
                }, $responses))
            ->execute();

        return $numbersRow > 0;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function update(int $id, IResponse $response): bool
    {
        $news = News::findOne($id);
        if ($news) {
            $news->setAttributes($response->toArray(), false);
            $news->update(false);
        }
        return true;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function get(int $id): IResponse
    {
        $news = News::find()->where(['id' => $id])->asArray()->one();
        if ($news) {
            return new NewsDto(
                $news['author'],
                $news['source'],
                $news['title'],
                $news['description'],
                $news['url'],
                $news['urlToImage'],
                $news['published_at'],
                $news['content'],
                $news['id']
            );
        }

        return null;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function all(): array
    {
        $news = News::find()->asArray(true)->all();
        if (count($news)) {
            return array_map(static function ($news) {
                return new NewsDto(
                    $news['author'],
                    $news['source'],
                    $news['title'],
                    StringHelper::truncate($news['description'], 200),
                    $news['url'],
                    $news['urlToImage'],
                    $news['published_at'],
                    $news['content'],
                    $news['id']
                );
            }, $news);
        }

        return [];
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function getAllByCondition(array $condition): array
    {
        $news = News::find()->where($condition)->asArray(true)->all();
        if (count($news)) {
            return array_map(static function ($news) {
                return new NewsDto(
                    $news['author'],
                    $news['source'],
                    $news['title'],
                    StringHelper::truncate($news['description'], 200),
                    $news['url'],
                    $news['urlToImage'],
                    $news['published_at'],
                    $news['content'],
                    $news['id']
                );
            }, $news);
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getOneByCondition(array $condition): ?IResponse
    {
        $news = News::find()->where($condition)->asArray(true)->one();
        if ($news) {
            return new NewsDto(
                $news['author'],
                $news['source'],
                $news['title'],
                $news['description'],
                $news['url'],
                $news['urlToImage'],
                $news['published_at'],
                $news['content'],
                $news['id']
            );
        }
        return null;
    }
}