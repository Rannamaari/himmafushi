<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'seo_title', 'seo_description', 'image', 'published_at', 'featured', 'active'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'featured' => 'boolean', 'active' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('active', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
