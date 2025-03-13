<?php

namespace common\dto;

class AuthorDto extends BaseDto
{
    public int $id;
    public string $full_name;

    public function __construct(int $id, string $full_name)
    {
        $this->id = $id;
        $this->full_name = $full_name;
    }
}
