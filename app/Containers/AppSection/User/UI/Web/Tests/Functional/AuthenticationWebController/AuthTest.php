<?php

namespace App\Containers\AppSection\User\UI\Web\Tests\Functional\AuthenticationWebController;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct users creating processes \
 *      Covered scenarios:
 *      1. Successful authentication of a user with correct credentials
 *      2. Fails authentication with 401 status when user's credentials are incorrect
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\Web\Controllers\AuthenticationWebController::auth
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
                'password' => Hash::make('secret'),
            ]
        );


        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
        ];

        $response = $this
            ->json(
                'post',
                route('api.private.users.auth'),
                $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertCookie(env('SESSION_COOKIE') ?? 'gamedp');

        $this->assertEquals(
            $data['login'],
            json_decode($response->getContent(), true)['data']['login']
        );
    }

    public function testAuthFailsWithWrongCredentials(): void
    {
        // 1. Initialization
        $this->seed();

        User::factory()->createOne(
            [
                'login' => 'admin-test',
                'password' => Hash::make('secret'),
            ]
        );

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'incorrect-password',
        ];

        $response = $this
            ->json('post', route('api.private.users.auth'), $data, [
                'Referer' => 'http://api.apiato.test/'
            ]);

        // 3. Assertion
        $response->assertStatus(401);
    }
}
