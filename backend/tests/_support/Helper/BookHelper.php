<?php

namespace backend\tests\_support\Helper;

use common\models\Book;
use common\models\Author;

class BookHelper
{
    public static function createBook($attributes = [])
    {
        $book = new Book([
            'title' => $attributes['title'] ?? 'Test Book',
            'publish_year' => $attributes['publish_year'] ?? 2021,
            'isbn' => $attributes['isbn'] ?? '1234567890123',
            'description' => $attributes['description'] ?? 'Test Description',
        ]);
        $book->save();
        return $book;
    }

    public static function createAuthor($attributes = [])
    {
        $author = new Author([
            'name' => $attributes['name'] ?? 'Test Author',
        ]);
        $author->save();
        return $author;
    }
}
