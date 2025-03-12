<?php

use yii\db\Migration;

class m250312_164942_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-subscription-user_id-author_id',
            '{{%subscriptions}}',
            ['user_id', 'author_id'],
            true
        );

        $this->addForeignKey(
            'fk-subscription-user',
            '{{%subscriptions}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-subscription-author',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscription-user', '{{%subscriptions}}');
        $this->dropForeignKey('fk-subscription-author', '{{%subscriptions}}');
        $this->dropIndex('idx-subscription-user_id-author_id', '{{%subscriptions}}');
        $this->dropTable('{{%subscriptions}}');
    }
}
