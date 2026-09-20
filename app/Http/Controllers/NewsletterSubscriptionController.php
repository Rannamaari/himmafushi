<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterSubscriptionController extends Controller
{
    public function store(StoreNewsletterSubscriptionRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => strtolower($request->string('email')->toString())],
            ['consented_at' => now(), 'status' => 'active'],
        );

        return back()->with('newsletter_success', 'You are on the list. We will send useful Himmafushi updates and offers, never spam.');
    }
}
