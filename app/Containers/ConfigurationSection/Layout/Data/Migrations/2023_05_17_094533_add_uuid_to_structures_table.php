<?php

use App\Containers\ConfigurationSection\Layout\Models\Layout;
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
        Schema::rename('structures', 'layouts');

        Schema::table('layouts', function (Blueprint $table) {
            $table->binaryUuid('uuid')->nullable()->after('id');
        });

        Layout::all()
            ->each(
                fn(Layout $player) => $player->setAttribute(
                    'uuid',
                    Uuid::uuid1()->getBytes()
                )->save()
            );

        Schema::table('layouts', function (Blueprint $table) {
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
        Schema::rename('layouts', 'structures');

        Schema::table('structures', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
