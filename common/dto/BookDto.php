<?php

namespace common\dto;

class BookDto extends BaseDto
{
    public function __construct(
        public int $id = 0,
        public string $title = '',
        public string $description = '',
        public int $publishYear = 0,
        public string $isbn = '',
        public array $authorIds = []
    ) {}
}
