<?php

namespace Tests;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use PHPUnit\Framework\MockObject\MockObject;

final class UserModelTest extends TestCase
{
    private User $user;
    private \Faker\Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
    }

    private function mockUserModel(bool $generatePassword = true) : User
    {
        $params =[
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'role' => $this->faker->randomElement(Role::cases()),
            'status' => $this->faker->randomElement(Status::cases())
        ];

        if($generatePassword)
        {
            $params['password'] = password_hash($this->faker->password(), PASSWORD_BCRYPT);
        }

        $user = new User(
            firstname: $params['firstname'],
            lastname: $params['lastname'],
            email: $params['email'],
            role: $params['role'],
            status: $params['status'],
            password: $params['password'],
        );

        return $user;
    }

    public function testUserWithPassword()
    {
        $user = $this->mockUserModel(generatePassword: true);
        $this->assertTrue(true);
    }
}