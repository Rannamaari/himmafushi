<div class="newsletter-popup" hidden data-newsletter-popup data-newsletter-success="{{ session('newsletter_success') ? 'true' : 'false' }}" data-newsletter-errors="{{ ($errors->has('email') || $errors->has('accept_terms')) ? 'true' : 'false' }}">
    <div class="newsletter-popup-panel" role="dialog" aria-modal="true" aria-labelledby="newsletter-popup-title">
        <button class="newsletter-popup-close" type="button" aria-label="Close newsletter signup" data-newsletter-close>&times;</button>
        <div class="newsletter-popup-offer"><p class="eyebrow light">Himmafushi offers</p><h2 id="newsletter-popup-title">Get better island deals.</h2><p>Be first to hear about discounted guesthouse rates, transfer offers, packages, and useful Himmafushi updates.</p><ul><li>Guesthouse discounts</li><li>Transfer offers</li><li>Island packages</li></ul></div>
        <x-site.newsletter-signup id="newsletter-popup-email" />
    </div>
</div>
