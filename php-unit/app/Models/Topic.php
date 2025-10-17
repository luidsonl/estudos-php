<?php

namespace App\Models;

class Topic
{
    public function __construct(
        public string $title,
        public array $subjects = []
    ){}
}
