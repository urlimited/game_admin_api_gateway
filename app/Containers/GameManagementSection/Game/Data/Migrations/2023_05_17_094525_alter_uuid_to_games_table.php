<?php

use App\Containers\GameManagementSection\Game\Models\Game;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->binaryUuid('uuid')->after('id');
        });

        Game::all()
            ->each(
                fn(Game $player) => $player->setAttribute(
                    'uuid',
                    Uuid::uuid1()->getBytes()
                )->save()
            );

        Schema::table('games', function (Blueprint $table) {
            $table->unique('uuid')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
