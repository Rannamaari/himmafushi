<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->maleHimmafushiTransfers()->update(['duration_minutes' => 20]);
    }

    public function down(): void
    {
        $this->maleHimmafushiTransfers()->update(['duration_minutes' => 45]);
    }

    private function maleHimmafushiTransfers()
    {
        return DB::table('transfers')->where(function ($query) {
            $query->where(function ($route) {
                $route->whereRaw('LOWER(from_location) LIKE ?', ['%male%'])
                    ->whereRaw('LOWER(to_location) LIKE ?', ['%himmafushi%']);
            })->orWhere(function ($route) {
                $route->whereRaw('LOWER(from_location) LIKE ?', ['%himmafushi%'])
                    ->whereRaw('LOWER(to_location) LIKE ?', ['%male%']);
            });
        });
    }
};
