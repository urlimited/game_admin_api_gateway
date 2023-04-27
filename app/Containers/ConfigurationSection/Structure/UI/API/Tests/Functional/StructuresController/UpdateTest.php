<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Tests\Functional\StructuresController;


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
 * @covers \App\Containers\ConfigurationSection\Structure\UI\API\Controllers\StructuresController::update
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

        $userGameIds = $user->games->pluck('id')->first();

        $structure = Structure::factory()
            ->createOne(['game_id' => $userGameIds]);


        // 2. Scenario run
        $data = [
            'id'=>$structure->id,
            'name'=>'rerum',
            'game_id'=>$structure->game_id,
            'fields'=>[
                [
                    'path' => 'field1',
                    'data_type' => 'string',
                ]
            ],
            'version'=>'13.25.42',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.structures.update',
                    [
                        'game' => $userGameIds,
                        'structure'=>$data['id'],
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
                    'fields',
                ]
            ]
        );

        $this->assertEquals(
            $data['name'],
            json_decode($response->getContent(), true)['data']['name']
        );
    }


}
