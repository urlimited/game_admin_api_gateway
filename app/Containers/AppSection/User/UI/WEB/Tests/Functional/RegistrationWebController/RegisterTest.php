<?php

namespace App\Containers\AppSection\User\UI\WEB\Tests\Functional\RegistrationWebController;

use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct users creating processes
 *  Covered scenarios:
 *      1. Successful Register user via frontend with origin
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\WEB\Controllers\RegistrationWebController::register
 */
class RegisterTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testRegisterUserViaFrontendWithOrigin(): void
    {
        // 1. Initialization
        $this->seed();

        // 2. Scenario run
        $data = [
            'login' => 'test@mail.ru',
            'password' => '08082001Edige$',
        ];
        //$response = $this->json('post', '/users/', $data);
        $response = $this
            ->json('post', route('api.private.users.register'), $data, [
                'Referer' => 'http://localhost'
            ]);

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertCookie(env('SESSION_COOKIE') ?? 'gamedp');

        $this->assertEquals(
            $data['login'],
            json_decode($response->getContent(), true)['data']['login']
        );

        $this->assertDatabaseHas('users', ['login' => $data['login']]);
    }
}
