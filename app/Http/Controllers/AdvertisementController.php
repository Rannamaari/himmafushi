<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class AdvertisementController extends Controller
{
    public function impression(Advertisement $advertisement): Response
    {
        abort_unless($this->isLive($advertisement), 404);
        $advertisement->increment('impressions');

        return response()->noContent();
    }

    public function click(Advertisement $advertisement): RedirectResponse
    {
        abort_unless($this->isLive($advertisement) && $advertisement->destination_url, 404);
        $advertisement->increment('clicks');

        return str_starts_with($advertisement->destination_url, '/')
            ? redirect($advertisement->destination_url)
            : redirect()->away($advertisement->destination_url);
    }

    private function isLive(Advertisement $advertisement): bool
    {
        return $advertisement->active
            && (! $advertisement->starts_at || $advertisement->starts_at->isPast())
            && (! $advertisement->ends_at || $advertisement->ends_at->isFuture());
    }
}
