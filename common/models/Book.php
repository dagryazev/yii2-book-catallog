<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['title', 'publish_year', 'isbn'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['publish_year'], 'integer'],
            [['isbn'], 'string', 'max' => 13],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }
}
