<?php

use yii\db\Migration;

class m250312_152227_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'publish_year' => $this->smallInteger(4)->notNull(),
            'description' => $this->text()->null(),
            'isbn' => $this->char(13)->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-book-author_id',
            '{{%books}}',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-book-publish_year-author_id',
            '{{%books}}',
            ['publish_year', 'author_id']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-book-author_id', '{{%books}}');
        $this->dropIndex('idx-book-publish_year-author_id', '{{%books}}');
        $this->dropTable('{{%books}}');
    }
}
