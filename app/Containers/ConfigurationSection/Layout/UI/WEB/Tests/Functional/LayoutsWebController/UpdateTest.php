<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Tests\Functional\LayoutsWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * * @desription Successfully update layout
 * Covered scenarious
 *       1.specific game layout updated with Authenticated user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers\LayoutsWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateLayout(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $json = '[{"name": "A","data_type": "list","rules": null,"children": [{"name": "A-C","data_type": "string","rules": null,"children": [{"name": "A-C-G","data_type": "string", "rules": null}]}, {"name": "A-E","data_type": "string","rules": null}]},{"name": "B", "data_type": "string", "rules": null, "children": [{"name": "B-D","data_type": "string","rules": null}]}]';
        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'schema' => $array,
            'version' => '13.25.42',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.layouts.update',
                    [
                        'layout' => $layout->getAttribute('uuidText'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'name',
                    'version',
                    'schema',
                ]
            ]
        );

        $this->assertEquals(
            $data['name'],
            json_decode($response->getContent(), true)['data']['name']
        );
    }


}
