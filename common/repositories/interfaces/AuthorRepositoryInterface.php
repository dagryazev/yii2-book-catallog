<?php

namespace common\repositories\interfaces;

use common\dto\AuthorDto;

interface AuthorRepositoryInterface
{
    public function findOne(int $id): ?AuthorDto;
    public function findAll(): array;
    public function save(AuthorDto $authorDto): void;
    public function delete(int $id): void;
    public function getTopAuthorsByBooksInYear(int $year): array;
}
