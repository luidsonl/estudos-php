<?php

namespace App\Models;

class Message
{
    public function __construct(
        public string $id,
        public string $content,
        public string $senderId,
        public string $receiverId,
        public \DateTime $timestamp
    ) {}
}
