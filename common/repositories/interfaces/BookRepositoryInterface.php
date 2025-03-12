<?php

namespace common\repositories\interfaces;

use common\dto\BookDto;

interface BookRepositoryInterface
{
    public function findOne(int $id): ?BookDto;
    public function findAll(): array;
    public function save(BookDto $bookDto): void;
    public function delete(int $id): bool;
}
