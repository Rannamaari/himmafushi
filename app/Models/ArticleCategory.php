<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
