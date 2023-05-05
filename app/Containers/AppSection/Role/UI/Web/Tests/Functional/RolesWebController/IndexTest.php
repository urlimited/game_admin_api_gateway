<?php

namespace App\Containers\AppSection\Role\UI\Web\Tests\Functional\RolesWebController;

use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

/**
 * @desription Test receive roles list
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\Role\UI\Web\Controllers\RolesWebController::index
 */
class IndexTest extends TestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllUserRoles(): void
    {
        $user = User
            ::factory()
            ->createOne();

        Role::factory()->count(10)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.roles.index')
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'display_name',
                    ]
                ]
            ]
        );
    }
}
