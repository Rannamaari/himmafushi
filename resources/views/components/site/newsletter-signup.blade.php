@props(['compact' => false, 'id' => 'newsletter-email'])
<section class="newsletter-signup {{ $compact ? 'newsletter-compact' : '' }}">
    <div><p class="eyebrow {{ $compact ? 'light' : '' }}">Himmafushi updates</p><h2>Island news, offers and practical travel notes.</h2><p>Occasional useful updates only. No spam.</p></div>
    <div>
        @if(session('newsletter_success'))<p class="newsletter-success">{{ session('newsletter_success') }}</p>@endif
        @if($errors->has('email') || $errors->has('accept_terms'))<p class="newsletter-error">Please enter a valid email and accept the terms to join.</p>@endif
        <form method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <label for="{{ $id }}">Email address</label><div class="newsletter-email-row"><input id="{{ $id }}" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@example.com" required><button class="button" type="submit">Get offers</button></div>
            <label class="newsletter-consent"><input type="checkbox" name="accept_terms" value="1" @checked(old('accept_terms')) required><span>I agree to the <a href="{{ route('terms') }}">Terms</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>, and want occasional Himmafushi news and offers.</span></label>
        </form>
    </div>
</section>
