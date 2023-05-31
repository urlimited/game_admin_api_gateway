<?php

use App\Containers\ConfigurationSection\Setting\Models\Setting;
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
        Schema::rename('configurations', 'settings');

        Schema::table('settings', function (Blueprint $table) {
            $table->binaryUuid('uuid')->nullable()->after('id');
        });

        Setting::all()
            ->each(
                fn(Setting $player) => $player->setAttribute(
                    'uuid',
                    Uuid::uuid1()->getBytes()
                )->save()
            );

        Schema::table('settings', function (Blueprint $table) {
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
        Schema::rename('settings', 'configurations');

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
