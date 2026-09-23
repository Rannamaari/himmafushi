<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('activities')->where('partner_excursion', true)->get(['id', 'price_tiers'])->each(function (object $activity): void {
            $tiers = is_string($activity->price_tiers) ? json_decode($activity->price_tiers, true) : $activity->price_tiers;

            if (! is_array($tiers)) {
                return;
            }

            $updated = false;
            foreach ($tiers as &$tier) {
                if (($tier['label'] ?? null) === '4+ people') {
                    $tier['label'] = '5+ people';
                    $updated = true;
                }
            }
            unset($tier);

            if ($updated) {
                DB::table('activities')->where('id', $activity->id)->update(['price_tiers' => json_encode($tiers)]);
            }
        });
    }

    public function down(): void
    {
        DB::table('activities')->where('partner_excursion', true)->get(['id', 'price_tiers'])->each(function (object $activity): void {
            $tiers = is_string($activity->price_tiers) ? json_decode($activity->price_tiers, true) : $activity->price_tiers;

            if (! is_array($tiers)) {
                return;
            }

            foreach ($tiers as &$tier) {
                if (($tier['label'] ?? null) === '5+ people') {
                    $tier['label'] = '4+ people';
                }
            }
            unset($tier);

            DB::table('activities')->where('id', $activity->id)->update(['price_tiers' => json_encode($tiers)]);
        });
    }
};
