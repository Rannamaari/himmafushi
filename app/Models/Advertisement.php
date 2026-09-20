<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'advertiser', 'placement', 'ad_type', 'headline', 'copy', 'image', 'mobile_image', 'cta_label', 'destination_url',
        'embed_code', 'priority', 'starts_at', 'ends_at', 'active', 'impressions', 'clicks',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'active' => 'boolean',
            'impressions' => 'integer',
            'clicks' => 'integer',
        ];
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query
            ->where('active', true)
            ->where(fn (Builder $dates) => $dates->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }
}
