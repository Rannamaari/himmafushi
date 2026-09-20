<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'label', 'group', 'value', 'secret_value', 'is_secret', 'active'];

    protected function casts(): array
    {
        return ['secret_value' => 'encrypted', 'is_secret' => 'boolean', 'active' => 'boolean'];
    }

    public static function configuredValue(string $key, mixed $fallback = null): mixed
    {
        $setting = static::query()->where('key', $key)->where('active', true)->first();

        if (! $setting) {
            return $fallback;
        }

        return $setting->is_secret ? ($setting->secret_value ?: $fallback) : ($setting->value ?: $fallback);
    }
}
