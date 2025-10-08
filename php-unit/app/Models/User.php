<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\Status;

class User
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public Role $role,
        public Status $status,
        public ?string $password = null
    ) {}
}