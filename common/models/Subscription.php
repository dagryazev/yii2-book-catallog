<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return 'subscriptions';
    }

    public function rules()
    {
        return [
            [['user_id', 'author_id'], 'required'],
            [['user_id', 'author_id'], 'integer'],
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
