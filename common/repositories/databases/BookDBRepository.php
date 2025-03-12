<?php

namespace common\repositories\databases;

use common\dto\BookDto;
use common\models\Author;
use common\models\Book;
use common\repositories\interfaces\BookRepositoryInterface;

class BookDBRepository implements BookRepositoryInterface
{
    public function findOne(int $id): ?BookDto
    {
        $book = Book::findOne($id);
        return $book ? $this->mapToDto($book) : null;
    }

    public function findAll(): array
    {
        $books = Book::find()->all();
        return array_map(fn($book) => $this->mapToDto($book), $books);
    }

    public function save(BookDto $bookDto): void
    {
        $book = $bookDto->id ? Book::findOne($bookDto->id) : new Book();

        $book->title = $bookDto->title;
        $book->description = $bookDto->description;
        $book->publish_year = $bookDto->publishYear;
        $book->isbn = $bookDto->isbn;

        if (!$book->save()) {
            throw new \RuntimeException('Ошибка сохранения книги.');
        }

        $this->linkAuthors($book, $bookDto->authorIds);
    }

    private function linkAuthors(Book $book, array $authorIds): void
    {
        $book->unlinkAll('authors', true);

        foreach ($authorIds as $authorId) {
            $author = Author::findOne($authorId);
            if ($author) {
                $book->link('authors', $author);
            }
        }
    }

    public function delete(int $id): bool
    {
        $book = Book::findOne($id);
        if ($book) {
            return $book->delete() > 0;
        }
        return false;
    }

    private function mapToDto(Book $book): BookDto
    {
        $authorIds = $book->authors ? array_map(fn($author) => $author->id, $book->authors) : [];
        return new BookDto(
            id: $book->id,
            title: $book->title,
            description: $book->description,
            publishYear: $book->publish_year,
            isbn: $book->isbn,
            authorIds: $authorIds
        );
    }
}
