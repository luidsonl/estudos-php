<?php

namespace Tests;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Tests\mocks\Models\UserMocker;

final class UserModelTest extends TestCase
{
    public function testUserWithPassword()
    {
        $user = UserMocker::mockUserModel(generatePassword: true);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserWithoutPassword()
    {
        $user = UserMocker::mockUserModel(generatePassword: false);
        $this->assertInstanceOf(User::class, $user);
    }
}