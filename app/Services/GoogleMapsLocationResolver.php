<?php

namespace App\Services;

use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Http;

class GoogleMapsLocationResolver
{
    public function resolve(string $url): ?array
    {
        if (! $this->isTrustedGoogleMapsUrl($url)) {
            return null;
        }

        if ($coordinates = $this->extractCoordinates($url)) {
            return $coordinates;
        }

        $effectiveUrl = $url;

        try {
            $response = Http::timeout(10)
                ->withOptions([
                    'allow_redirects' => true,
                    'on_stats' => function (TransferStats $stats) use (&$effectiveUrl): void {
                        $effectiveUrl = (string) $stats->getEffectiveUri();
                    },
                ])
                ->get($url);

            return $this->extractCoordinates($effectiveUrl, $response->body(), $url);
        } catch (\Throwable) {
            return $this->extractCoordinates($url);
        }
    }

    public function extractCoordinates(string ...$values): ?array
    {
        $patterns = [
            '/@(-?\d{1,2}\.\d+),(-?\d{1,3}\.\d+)/',
            '/!3d(-?\d{1,2}\.\d+)!4d(-?\d{1,3}\.\d+)/',
            '/(?:[?&](?:q|query|ll)=)(-?\d{1,2}\.\d+)(?:,|%2C)(-?\d{1,3}\.\d+)/i',
        ];

        foreach ($values as $value) {
            $value = html_entity_decode(urldecode($value));
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value, $matches)) {
                    $latitude = (float) $matches[1];
                    $longitude = (float) $matches[2];
                    if (abs($latitude) <= 90 && abs($longitude) <= 180) {
                        return ['latitude' => $latitude, 'longitude' => $longitude];
                    }
                }
            }
        }

        return null;
    }

    private function isTrustedGoogleMapsUrl(string $url): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host === 'goo.gl' || str_ends_with($host, '.goo.gl')
            || $host === 'google.com' || str_ends_with($host, '.google.com');
    }
}
