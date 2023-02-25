<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive users list
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\UsersController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllUsers(): void
    {
        // 1. Initialization
        $this->seed();

        $user = User::factory()->createOne();

        User::factory()->count(10)->create();

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.users.index')
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'login',
                    ]
                ]
            ]
        );
    }
}
