<?php

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use App\Containers\AppSection\User\UI\API\Requests\UserStoreRequest;
use Illuminate\Support\Facades\App;

/**
 * Class CreateUserTest.
 *
 * @group user
 * @group unit
 */
class UserCreateTest extends TestCase
{
    public function testCreateUser(): void
    {
        $data = [
            'email' => 'Mahmoud@test.test',
            'password' => 'so-secret',
            'name' => 'Mahmoud',
        ];

        $request = new UserStoreRequest($data);
        $user = App::make(UserStoreRequest::class)->run($request);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($user->name, $data['name']);
    }
}
