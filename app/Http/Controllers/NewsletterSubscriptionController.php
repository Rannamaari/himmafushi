<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\NewsletterSubscriber;
use App\Services\NewsletterTelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Throwable;

class NewsletterSubscriptionController extends Controller
{
    public function store(StoreNewsletterSubscriptionRequest $request, NewsletterTelegramNotifier $notifier): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::query()->firstOrNew([
            'email' => strtolower($request->string('email')->toString()),
        ]);
        $shouldNotify = ! $subscriber->exists || $subscriber->status !== 'active';
        $subscriber->fill(['consented_at' => now(), 'status' => 'active'])->save();

        if ($shouldNotify) {
            try {
                $notifier->subscribed($subscriber);
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return back()->with('newsletter_success', 'You are on the list. We will send useful Himmafushi updates and offers, never spam.');
    }
}
