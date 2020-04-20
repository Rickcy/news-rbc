<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $source
 * @property string|null $author
 * @property string $title
 * @property string|null $description
 * @property string $url
 * @property string|null $urlToImage
 * @property string $published_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url', 'published_at'], 'required'],
            [['title', 'description', 'urlToImage', 'content'], 'string'],
            [['published_at'], 'safe'],
            [['source', 'author', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'author' => 'Author',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'url' => 'Url',
            'urlToImage' => 'Url To Image',
            'published_at' => 'Published At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }
}
