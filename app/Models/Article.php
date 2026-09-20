<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\HtmlString;

class Article extends Model
{
    protected $fillable = ['article_category_id', 'title', 'slug', 'excerpt', 'body', 'seo_title', 'seo_description', 'image', 'published_at', 'featured', 'active'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'featured' => 'boolean', 'active' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('active', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function renderedBody(): HtmlString
    {
        if ($this->body !== strip_tags($this->body)) {
            return new HtmlString($this->body);
        }

        return new HtmlString(nl2br(e($this->body)));
    }
}
