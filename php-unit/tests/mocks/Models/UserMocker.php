<?php

namespace Tests\mocks\Models;

use Faker\Factory;
use App\Models\User;

final class UserMocker{

    public static function mockUserModel(bool $generatePassword = true) : User
    {
        $faker = Factory::create();
        $params =[
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'email' => $faker->email(),
            'role' => $faker->randomElement(\App\Enums\Role::cases()),
            'status' => $faker->randomElement(\App\Enums\Status::cases())
        ];

        if($generatePassword)
        {
            $params['password'] = password_hash($faker->password(), PASSWORD_BCRYPT);
            
            $user = new User(
                firstName: $params['firstName'],
                lastName: $params['lastName'],
                email: $params['email'],
                role: $params['role'],
                status: $params['status'],
                password: $params['password'],
            );

            return $user;
        }

        $user = new User(
            firstName: $params['firstName'],
            lastName: $params['lastName'],
            email: $params['email'],
            role: $params['role'],
            status: $params['status']
        );

        return $user;
    }
}