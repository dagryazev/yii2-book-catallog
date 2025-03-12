<?php

use yii\db\Migration;

class m250312_153223_create_book_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'PRIMARY KEY(book_id, author_id)',
        ]);

        $this->addForeignKey(
            'fk-book_author-book_id',
            '{{%book_author}}',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            '{{%book_author}}',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-book_author-book_id',
            '{{%book_author}}',
            'book_id'
        );

        $this->createIndex(
            'idx-author_book-author_id',
            '{{%book_author}}',
            'author_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-book_author-book_id', '{{%book_author}}');
        $this->dropForeignKey('fk-book_author-author_id', '{{%book_author}}');
        $this->dropTable('{{%book_author}}');
    }
}
