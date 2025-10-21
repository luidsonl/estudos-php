<?php

namespace App\Models;

use App\Enums\Subjects;

class Topic
{
    public function __construct(
        public string $title,
        /** @var Subjects[] */
        public array $subjects = []
    ) {
        $this->validateSubjects($subjects);
    }

    /**
     * @param array $subjects
     * @throws \InvalidArgumentException
     */
    private function validateSubjects(array $subjects): void
    {
        foreach ($subjects as $index => $subject) {
            if (!$subject instanceof Subjects) {
                throw new \InvalidArgumentException(
                    "Subject at index $index must be an instance of " . Subjects::class . 
                    ", got " . (is_object($subject) ? get_class($subject) : gettype($subject))
                );
            }
        }
    }
}