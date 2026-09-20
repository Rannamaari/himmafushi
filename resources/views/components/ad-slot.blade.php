@if($advertisement)
    @if($head)
        {!! $advertisement->embed_code !!}
    @elseif($compact)
        <a class="search-sponsor" href="{{ route('ads.click', $advertisement) }}" target="_blank" rel="sponsored noopener" data-ad-impression="{{ route('ads.impression', $advertisement) }}" data-ad-key="{{ $advertisement->id }}-{{ $position }}">
            <span>Sponsored by</span><strong>{{ $advertisement->advertiser }}</strong>
        </a>
    @else
        <aside class="ad-slot {{ $advertisement->embed_code ? 'ad-slot-embed' : '' }}" aria-label="Advertisement" data-ad-impression="{{ route('ads.impression', $advertisement) }}" data-ad-key="{{ $advertisement->id }}-{{ $position }}">
            @if($advertisement->embed_code)
                <span class="ad-embed-label">Advertisement</span>
                <div class="ad-embed-code">{!! $advertisement->embed_code !!}</div>
            @else
            <div class="ad-slot-media">
                @if($advertisement->mobile_image || $advertisement->image)
                    <picture>
                        @if($advertisement->mobile_image)<source media="(max-width: 640px)" srcset="{{ asset('storage/'.$advertisement->mobile_image) }}">@endif
                        <img src="{{ asset('storage/'.($advertisement->image ?: $advertisement->mobile_image)) }}" alt="{{ $advertisement->advertiser }} advertisement" width="1200" height="420" loading="lazy">
                    </picture>
                @endif
            </div>
            <div class="ad-slot-content"><span>Advertisement</span><p class="ad-advertiser">{{ $advertisement->advertiser }}</p>@if($advertisement->headline)<h2>{{ $advertisement->headline }}</h2>@endif @if($advertisement->copy)<p>{{ $advertisement->copy }}</p>@endif @if($advertisement->destination_url)<a class="button button-small" href="{{ route('ads.click', $advertisement) }}" target="_blank" rel="sponsored noopener">{{ $advertisement->cta_label ?: 'Learn more' }}</a>@endif</div>
            @endif
        </aside>
    @endif
@endif
