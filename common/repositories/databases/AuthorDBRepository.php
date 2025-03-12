<?php

namespace common\repositories\databases;

use common\dto\AuthorDto;
use common\models\Author;
use common\repositories\interfaces\AuthorRepositoryInterface;

class AuthorDBRepository implements AuthorRepositoryInterface
{
    public function findOne(int $id): ?AuthorDto
    {
        $author = Author::findOne($id);
        return $author ? $this->mapToDto($author) : null;
    }

    public function findAll(): array
    {
        $authors = Author::find()->all();
        return array_map([$this, 'mapToDto'], $authors);
    }

    public function save(AuthorDto $authorDto): void
    {
        $author = $authorDto->id ? Author::findOne($authorDto->id) : new Author();

        if (!$author) {
            throw new \RuntimeException("Author not found.");
        }

        $author->full_name = $authorDto->full_name;

        if (!$author->save()) {
            throw new \RuntimeException("Error saving author.");
        }
    }

    public function delete(int $id): void
    {
        $author = Author::findOne($id);
        if ($author) {
            $author->delete();
        }
    }

    public function getTopAuthorsByBooksInYear(int $year): array
    {
        $authors = Author::find()
            ->select(['authors.id', 'authors.name', 'COUNT(books.id) AS book_count'])
            ->innerJoin('books', 'books.author_id = authors.id')
            ->where(['books.publish_year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $authors;
    }

    private function mapToDto(Author $author): AuthorDto
    {
        return new AuthorDto(
            $author->id,
            $author->full_name,
        );
    }
}
