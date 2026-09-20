<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantMenuItem extends Model
{
    protected $fillable = ['restaurant_menu_category_id', 'name', 'description', 'price', 'currency', 'image', 'available', 'featured', 'sort_order'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'available' => 'boolean', 'featured' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RestaurantMenuCategory::class, 'restaurant_menu_category_id');
    }
}
