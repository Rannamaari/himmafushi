<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HomepageFeature extends Model
{
    protected $fillable = ['title', 'type_label', 'summary', 'image', 'badge', 'price_text', 'url', 'cta_label', 'sort_order', 'starts_at', 'ends_at', 'active'];

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'active' => 'boolean'];
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query->where('active', true)
            ->where(fn (Builder $dates) => $dates->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }
}
