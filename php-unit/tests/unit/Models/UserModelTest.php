<?php

namespace Tests;

use Faker\Factory as Faker;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\User;
use PHPUnit\Framework\TestCase;

final class UserModelTest extends TestCase
{
    public function testUserWithPassword()
    {
        $randomStatus = Status::cases()[array_rand(Status::cases())];
        $randomRole = Role::cases()[array_rand(Role::cases())];

        $user = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: $randomRole,
            status: $randomStatus,
            password: Faker::create()->password()
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertIsString($user->id);
        $this->assertIsString($user->password);
        $this->assertIsString($user->firstName);
        $this->assertIsString($user->lastName);
        $this->assertIsString($user->email);
        $this->isInstanceOf(Role::class, $user->role);
    }

    public function testUserWithoutPassword()
    {
        $randomStatus = Status::cases()[array_rand(Status::cases())];
        $randomRole = Role::cases()[array_rand(Role::cases())];
        
        $user = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: $randomRole,
            status: $randomStatus
        );


        $this->assertInstanceOf(User::class, $user);
        $this->assertNull($user->password);
        $this->assertIsString($user->id);
        $this->assertIsString($user->firstName);
        $this->assertIsString($user->lastName);
        $this->assertIsString($user->email);
        $this->isInstanceOf(Role::class, $user->role);
    }


}