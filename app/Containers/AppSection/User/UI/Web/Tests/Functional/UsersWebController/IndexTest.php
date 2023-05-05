<?php

namespace App\Containers\AppSection\User\UI\Web\Tests\Functional\UsersWebController;

use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive users list
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\Web\Controllers\UsersWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllUsers(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asAdmin(User::factory())->createOne();

        User::factory()->count(10)->create();

        // 2. Scenarios run
        $response = $this
            ->actingAs($actor, 'api')
            ->json('get',
                route('api.private.users.index')
            );

        // 3. Assertion
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
