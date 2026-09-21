<?php

namespace App\Services;

use App\Models\NewsletterSubscriber;
use App\Models\SiteSetting;

class NewsletterTelegramNotifier
{
    public function __construct(protected TelegramService $telegram) {}

    public function subscribed(NewsletterSubscriber $subscriber): void
    {
        $chatId = SiteSetting::configuredValue('telegram_newsletter_chat_id')
            ?: SiteSetting::configuredValue('telegram_guesthouse_chat_id', config('services.telegram.guesthouse_chat_id'));

        $email = htmlspecialchars($subscriber->email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $message = "<b>NEW NEWSLETTER SIGNUP</b>\n\n".
            "<b>Email:</b> {$email}\n".
            '<b>Signed up:</b> '.$subscriber->consented_at?->format('d M Y, H:i')." Maldives time\n\n".
            'This guest agreed to receive Himmafushi news, guesthouse discounts, and offers.';

        $this->telegram->send($chatId, $message, [[
            ['text' => 'Open subscribers', 'url' => config('app.url').'/admin/newsletter-subscribers'],
        ]]);
    }
}
