<?php

namespace common\dto;

class SubscriptionDTO
{
    public int $userId;
    public int $authorId;

    public function __construct(int $userId, int $authorId)
    {
        $this->userId = $userId;
        $this->authorId = $authorId;
    }
}

