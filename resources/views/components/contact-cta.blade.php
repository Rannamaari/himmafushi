@props([
    'title' => 'Call us for more information',
    'message' => 'Tell us what you need and we will help you plan the next step.',
    'label' => 'Call +960 7779493',
])
<aside class="contact-cta">
    <div><p class="eyebrow">Speak with our team</p><h2>{{ $title }}</h2><p>{{ $message }}</p></div>
    <div class="contact-cta-actions"><a class="button" href="tel:+9607779493">{{ $label }}</a><a class="text-link" href="https://wa.me/9607779493" target="_blank" rel="noopener">WhatsApp us</a></div>
</aside>
