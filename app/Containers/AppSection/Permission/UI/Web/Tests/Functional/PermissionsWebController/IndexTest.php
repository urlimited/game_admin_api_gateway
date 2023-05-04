<?php

namespace App\Containers\AppSection\Permission\UI\Web\Tests\Functional\PermissionsWebController;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use App\Containers\AppSection\Permission\Models\Permission;

/**
 * @desription Test receive permissions list
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\Permission\UI\Web\Controllers\PermissionsWebController::index
 */
class IndexTest extends TestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllUserPermissions(): void
    {
        $user = User
            ::factory()
            ->createOne();

        Permission::factory()->count(10)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.permissions.index')
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
