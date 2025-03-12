<?php

namespace common\services;

use common\repositories\interfaces\AuthorRepositoryInterface;

class BookReportService
{

    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
    )
    {
    }

    public function getTopAuthorsByBooksInYear(int $year): array
    {
        return $this->authorRepository->getTopAuthorsByBooksInYear($year);
    }
}
