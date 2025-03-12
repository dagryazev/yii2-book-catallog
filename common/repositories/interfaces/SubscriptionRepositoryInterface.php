<?php

namespace common\repositories\interfaces;

use common\dto\SubscriptionDTO;

interface SubscriptionRepositoryInterface
{
    public function create(int $userId, int $authorId): SubscriptionDTO;
    public function findByUserAndAuthor(int $userId, int $authorId): ?SubscriptionDTO;
    public function findByUser(int $userId): array;
    public function findByAuthor(int $authorId): array;
    public function delete(int $userId, int $authorId): void;
}
