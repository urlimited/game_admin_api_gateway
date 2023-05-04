<?php

namespace App\Containers\AppSection\User\UI\Web\Tests\Functional\RegistrationWebController;

use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct users creating processes
 *  Covered scenarios:
 *      1. Successful Register user via frontend with origin
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\Web\Controllers\RegistrationWebController::register
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
            'login' => 'admin-test',
            'password' => 'secret',
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
