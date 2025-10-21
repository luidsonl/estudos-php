<?php

namespace App\Models;

class Message
{
    public function __construct(
        public string $id,
        public string $senderId,
        public string $receiverId,
        public string $topicId,
        public string $content,
        public \DateTime $timestamp
    ) {
        $this->validateId($id, 'id');
        $this->validateId($senderId, 'senderId');
        $this->validateId($receiverId, 'receiverId');
        $this->validateId($topicId, 'topicId');
        $this->validateContent($content);
        $this->timestamp = clone $timestamp;
    }

    /**
     * @param string $id
     * @param string $fieldName
     * @throws \InvalidArgumentException
     */
    private function validateId(string $id, string $fieldName): void
    {
        if (empty(trim($id))) {
            throw new \InvalidArgumentException("$fieldName cannot be empty");
        }

        if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $id)) {
            throw new \InvalidArgumentException("Invalid $fieldName format");
        }
    }

    /**
     * @param string $content
     * @throws \InvalidArgumentException
     */
    private function validateContent(string $content): void
    {
        if (empty(trim($content))) {
            throw new \InvalidArgumentException('Content cannot be empty');
        }
    }
}