<?php

use App\Containers\GameManagementSection\Player\Models\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->binaryUuid('uuid')->nullable()->after('id');
        });

        Player::all()
            ->each(
                fn(Player $player) => $player->setAttribute(
                    'uuid',
                    Uuid::uuid1()->getBytes()
                )->save()
            );

        Schema::table('players', function (Blueprint $table) {
            $table->unique('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
