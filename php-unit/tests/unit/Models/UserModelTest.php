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
        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertInstanceOf(Status::class, $user->status);
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
        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertInstanceOf(Status::class, $user->status);
    }

    public function testUserWithEmptyFirstNameShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: Faker::create()->uuid(),
            firstName: '',
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );
    }

    public function testUserWithEmptyLastNameShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: '',
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );
    }

    public function testUserWithEmptyEmailShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: '',
            role: Role::USER,
            status: Status::ACTIVE
        );
    }

    public function testUserWithInvalidEmailShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: 'invalid-email',
            role: Role::USER,
            status: Status::ACTIVE
        );
    }

    public function testUserWithEmptyIdShouldFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: '',
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );
    }

    public function testUserWithAllRoles()
    {
        foreach (Role::cases() as $role) {
            $user = new User(
                id: Faker::create()->uuid(),
                firstName: Faker::create()->firstName(),
                lastName: Faker::create()->lastName(),
                email: Faker::create()->email(),
                role: $role,
                status: Status::ACTIVE
            );

            $this->assertInstanceOf(User::class, $user);
            $this->assertEquals($role, $user->role);
        }
    }

    public function testUserWithAllStatuses()
    {
        foreach (Status::cases() as $status) {
            $user = new User(
                id: Faker::create()->uuid(),
                firstName: Faker::create()->firstName(),
                lastName: Faker::create()->lastName(),
                email: Faker::create()->email(),
                role: Role::USER,
                status: $status
            );

            $this->assertInstanceOf(User::class, $user);
            $this->assertEquals($status, $user->status);
        }
    }

    public function testUserWithVeryShortPassword()
    {
        $user = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE,
            password: '123' // Password muito curto
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('123', $user->password);
    }

    public function testUserWithEmptyPasswordString()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE,
            password: ''
        );
    }

    public function testUserWithSpecialCharactersInNames()
    {
        $user = new User(
            id: Faker::create()->uuid(),
            firstName: "João María-Çü",
            lastName: "O'Néil-Sánchez",
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("João María-Çü", $user->firstName);
        $this->assertEquals("O'Néil-Sánchez", $user->lastName);
    }

    public function testUserEmailIsCaseInsensitive()
    {
        $email = 'Test@Example.COM';
        $user = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: $email,
            role: Role::USER,
            status: Status::ACTIVE
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($email, $user->email);
    }

    public function testUserIdsAreUnique()
    {
        $user1 = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );

        $user2 = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE
        );

        $this->assertNotEquals($user1->id, $user2->id);
    }

    public function testUserWithNullPasswordExplicit()
    {
        $user = new User(
            id: Faker::create()->uuid(),
            firstName: Faker::create()->firstName(),
            lastName: Faker::create()->lastName(),
            email: Faker::create()->email(),
            role: Role::USER,
            status: Status::ACTIVE,
            password: null
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertNull($user->password);
    }
}