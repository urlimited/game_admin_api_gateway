<?php

namespace App\Containers\ConfigurationSection\Structure\UI\Web\Tests\Functional\StructuresWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * * @desription Successfully update structure
 * Covered scenarious
 *       1.specific game structure updated with Authenticated user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\Web\Controllers\StructuresWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateStructure(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $structure = Structure::factory()
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
                route('api.private.games.structures.update',
                    [
                        'structure' => $structure->getAttribute('id'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
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
