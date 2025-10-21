<?php

namespace App\Models;

use App\Enums\Subjects;

class Topic
{
    public function __construct(
        public string $id,
        public string $title,
        /** @var Subjects[] */
        public array $subjects = []
    ) {
        $this->validateTitle($title);
        $this->validateSubjects($subjects);
    }

    /**
     * @param string $title
     * @throws \InvalidArgumentException
     */
    private function validateTitle(string $title): void
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }
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

        $uniqueSubjects = [];
        foreach ($subjects as $subject) {
            if (in_array($subject, $uniqueSubjects, true)) {
                throw new \InvalidArgumentException('Duplicate subjects are not allowed');
            }
            $uniqueSubjects[] = $subject;
        }
    }
}