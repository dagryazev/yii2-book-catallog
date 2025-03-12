<?php

namespace backend\tests\functional;

use backend\tests\_support\Helper\BookHelper;
use backend\tests\FunctionalTester;
use common\models\Book;

class BookControllerCest
{
    // Тест на создание книги
    public function createBookTest(FunctionalTester $I)
    {
        $author = BookHelper::createAuthor();

        $I->amOnPage('/backend/book/create');
        $I->see('Create Book');

        $I->fillField('BookDto[title]', 'New Book');
        $I->fillField('BookDto[description]', 'New Book Description');
        $I->fillField('BookDto[publishYear]', 2022);
        $I->fillField('BookDto[isbn]', '9876543210123');
        $I->selectOption('BookDto[authorIds][]', $author->id);

        $I->click('Save');

        $I->seeInDatabase('book', ['title' => 'New Book']);
        $I->seeInDatabase('book_author', ['book_id' => Book::find()->where(['title' => 'New Book'])->one()->id, 'author_id' => $author->id]);
        $I->see('Book has been created');
    }

    // Тест на обновление книги
    public function updateBookTest(FunctionalTester $I)
    {
        $book = BookHelper::createBook(['title' => 'Old Title']);
        $author = BookHelper::createAuthor();

        $I->amOnPage("/backend/book/update?id={$book->id}");
        $I->see('Update Book');

        $I->fillField('BookDto[title]', 'Updated Book');
        $I->fillField('BookDto[description]', 'Updated Description');
        $I->fillField('BookDto[publishYear]', 2023);
        $I->fillField('BookDto[isbn]', '9876543210124');
        $I->selectOption('BookDto[authorIds][]', $author->id);

        $I->click('Save');

        $I->seeInDatabase('book', ['title' => 'Updated Book']);
        $I->seeInDatabase('book_author', ['book_id' => $book->id, 'author_id' => $author->id]);
        $I->see('Book has been updated');
    }

    public function deleteBookTest(FunctionalTester $I)
    {
        $book = BookHelper::createBook(['title' => 'Book to Delete']);

        $I->amOnPage("/backend/book/delete?id={$book->id}");
        $I->see('Are you sure you want to delete this item?');

        $I->click('Delete');

        $I->dontSeeInDatabase('book', ['title' => 'Book to Delete']);
        $I->dontSeeInDatabase('book_author', ['book_id' => $book->id]);
        $I->see('Book has been deleted');
    }

    public function createBookErrorTest(FunctionalTester $I)
    {
        $I->amOnPage('/backend/book/create');
        $I->see('Create Book');

        $I->fillField('BookDto[title]', '');
        $I->fillField('BookDto[description]', 'Invalid Book Description');
        $I->fillField('BookDto[publishYear]', 'invalid_year');
        $I->fillField('BookDto[isbn]', '');

        $I->click('Save');

        $I->see('Title cannot be blank');
        $I->see('Publish Year must be an integer');
    }

    public function updateBookNotFoundTest(FunctionalTester $I)
    {
        $I->amOnPage('/backend/book/update?id=999999');
        $I->see('Page not found');
    }
}
