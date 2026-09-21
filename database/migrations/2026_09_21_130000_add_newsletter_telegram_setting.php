<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'telegram_newsletter_chat_id'],
            [
                'label' => 'Newsletter signup chat ID',
                'group' => 'Telegram',
                'value' => null,
                'secret_value' => null,
                'is_secret' => false,
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'telegram_newsletter_chat_id')->delete();
    }
};
