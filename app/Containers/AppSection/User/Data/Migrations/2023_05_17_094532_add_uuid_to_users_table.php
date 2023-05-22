<?php

use App\Ship\Parents\Models\User;
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
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->binaryUuid('uuid')->nullable()->after('id');
        });

        User::all()
            ->each(
                fn(User $player) => $player->setAttribute(
                    'uuid',
                    Uuid::uuid1()->getBytes()
                )->save()
            );

        Schema::table('users', function (Blueprint $table) {
            $table->unique('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
