<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function send(
        string|int|null $chatId,
        string $message,
        array $buttons = []
    ): void {
        $token = SiteSetting::configuredValue('telegram_bot_token', config('services.telegram.bot_token'));

        if (! $token || ! $chatId) {
            return;
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        if (! empty($buttons)) {
            $payload['reply_markup'] = [
                'inline_keyboard' => $buttons,
            ];
        }

        Http::asJson()
            ->timeout(8)
            ->retry(2, 300)
            ->post(
                "https://api.telegram.org/bot{$token}/sendMessage",
                $payload
            )
            ->throw();
    }
}
