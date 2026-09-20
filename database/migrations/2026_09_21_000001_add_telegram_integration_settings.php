<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('secret_value')->nullable()->after('value');
            $table->boolean('is_secret')->default(false)->after('secret_value');
            $table->string('group')->default('Tracking')->after('label');
        });

        $now = now();
        DB::table('site_settings')->insert([
            ['key' => 'telegram_bot_token', 'label' => 'Telegram bot token', 'group' => 'Telegram', 'value' => null, 'secret_value' => null, 'is_secret' => true, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'telegram_transfer_chat_id', 'label' => 'Transfer booking chat ID', 'group' => 'Telegram', 'value' => null, 'secret_value' => null, 'is_secret' => false, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'telegram_guesthouse_chat_id', 'label' => 'Guesthouse booking chat ID', 'group' => 'Telegram', 'value' => null, 'secret_value' => null, 'is_secret' => false, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'telegram_bot_token', 'telegram_transfer_chat_id', 'telegram_guesthouse_chat_id',
        ])->delete();

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['secret_value', 'is_secret', 'group']);
        });
    }
};
