<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific user
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\UsersController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveUserById(): void
    {
        // 1. Initialization
        $this->seed();

        $user = User::factory()->createOne();

        $userB = User::factory()->createOne();

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.users.show',
                    [
                        'user' => $userB->id,
                    ]
                )
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'login',
                ]
            ]
        );
    }
}
