<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class NavigationItem extends Model
{
    protected $fillable = [
        'parent_id', 'key', 'label', 'route_name', 'url', 'active_route_pattern', 'menu_style',
        'menu_heading', 'sort_order', 'show_in_desktop', 'show_in_mobile', 'open_in_new_tab', 'active',
    ];

    protected function casts(): array
    {
        return [
            'show_in_desktop' => 'boolean',
            'show_in_mobile' => 'boolean',
            'open_in_new_tab' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('active', true)->orderBy('sort_order');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('active', true)->orderBy('sort_order');
    }

    public function destination(): string
    {
        if ($this->route_name && Route::has($this->route_name)) {
            return route($this->route_name);
        }

        return $this->url ?: '#';
    }

    public function isCurrent(): bool
    {
        return request()->routeIs($this->active_route_pattern ?: $this->route_name ?: '__none__');
    }
}
