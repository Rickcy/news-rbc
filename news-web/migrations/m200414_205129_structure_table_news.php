<?php

use yii\db\Migration;

/**
 * Class m200414_205129_structure_table_news
 */
class m200414_205129_structure_table_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'source' => $this->string(),
            'author' => $this->string(),
            'title' => $this->text()->notNull(),
            'description' => $this->text(),
            'content' => $this->text(),
            'url' => $this->string()->notNull()->unique(),
            'urlToImage' => $this->text(),
            'published_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('idx_source_news', 'news', 'source');
        $this->createIndex('idx_published_at_news', 'news', 'published_at');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_published_at_news', 'news');
        $this->dropIndex('idx_source_news', 'news');
        $this->dropTable('news');
    }

}
