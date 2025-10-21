<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\Status;

class User
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public Role $role,
        public Status $status,
        public ?string $password = null
    ) {
        $this->validateId($id);
        $this->validateName($firstName, 'firstName');
        $this->validateName($lastName, 'lastName');
        $this->validateEmail($email);
        $this->validatePassword($password);
    }

    /**
     * @param string $id
     * @param string $fieldName
     * @throws \InvalidArgumentException
     */
    private function validateId(string $id): void
    {
        if (empty(trim($id))) {
            throw new \InvalidArgumentException("id cannot be empty");
        }

        if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $id)) {
            throw new \InvalidArgumentException("Invalid id format");
        }
    }

    private function validateName(string $name, string $fieldName): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException("$fieldName cannot be empty");
        }
    }

    private function validateEmail(string $email): void
    {
        if (empty(trim($email))) {
            throw new \InvalidArgumentException("Email cannot be empty");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format");
        }
    }

    private function validatePassword(?string $password): void
    {
        if ($password !== null && empty(trim($password))) {
            throw new \InvalidArgumentException("Password cannot be empty string");
        }
    }
}