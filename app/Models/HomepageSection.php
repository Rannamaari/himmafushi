<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = ['key', 'eyebrow', 'title', 'description', 'cta_label', 'cta_url', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}
