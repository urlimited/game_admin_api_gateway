<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\AuthenticationController;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct users creating processes
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\AuthenticationController::auth
 */
class AuthTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testAuthUserWithCorrectCredentials(): void
    {
        // 1. Initialization
        $this->seed();

        User::factory()->createOne(
            [
                'login' => 'admin-test',
                'password' => 'secret',
            ]
        );

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
        ];

        $response = $this
            ->json('post', route('api.private.users.auth'), $data, [
                'Referer' => 'http://api.apiato.test/'
            ]);

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertCookie('game');

        $this->assertEquals(
            $data['login'],
            json_decode($response->getContent(), true)['data']['login']
        );
    }

    public function testAuthFailsWithWrongCredentials(): void
    {
        // 1. Initialization
        // $this->seed();

        User::factory()->createOne(
            [
                'login' => 'admin-test',
                'password' => 'secret',
            ]
        );

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'wrong password',
        ];

        $response = $this
            ->json('post', route('api.private.users.auth'), $data, [
                'Referer' => 'http://api.apiato.test/'
            ]);

        // 3. Assertion
        $response->assertStatus(401);
    }
}
