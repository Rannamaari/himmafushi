<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Transfer::query()->where('slug', 'like', 'n4seeb-%')->update(['active' => false]);
        $saturdayToThursday = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];
        $everyDay = [...$saturdayToThursday, 'friday'];

        $services = [
            ...$this->naseebServices($saturdayToThursday, $everyDay),
            ...$this->legionServices($saturdayToThursday, $everyDay),
        ];

        foreach ($services as $service) {
            Transfer::query()->updateOrCreate(['slug' => $service['slug']], $service + ['active' => true]);
        }

        Transfer::query()->where('slug', 'naseeb-himmafushi-airport-0800')->update(['featured' => true, 'featured_order' => 60]);
    }

    private function naseebServices(array $saturdayToThursday, array $everyDay): array
    {
        $services = [];

        foreach ([
            ['08:00', $everyDay], ['10:45', $saturdayToThursday], ['13:15', $saturdayToThursday], ['18:00', $everyDay],
        ] as [$time, $days]) {
            $services[] = $this->service('Naseeb Express', 'naseeb-himmafushi-male-'.$this->slugTime($time), 'Himmafushi Main Jetty', 'Male Jetty No. 1', $time, $days, 100, 10);
        }

        foreach ([
            ['08:00', $everyDay], ['10:45', $saturdayToThursday], ['13:15', $saturdayToThursday], ['18:00', $everyDay],
        ] as [$time, $days]) {
            $services[] = $this->service('Naseeb Express', 'naseeb-himmafushi-airport-'.$this->slugTime($time), 'Himmafushi Main Jetty', 'Velana International Airport', $time, $days, 100, 25, 'Airport transfer');
        }

        foreach ([
            ['09:45', $saturdayToThursday], ['12:00', $saturdayToThursday], ['16:00', $saturdayToThursday], ['22:00', $everyDay],
            ['09:00', ['friday']], ['15:00', ['friday']],
        ] as [$time, $days]) {
            $services[] = $this->service('Naseeb Express', 'naseeb-male-himmafushi-'.$this->slugTime($time), 'Male Jetty No. 1', 'Himmafushi Main Jetty', $time, $days, 100, 10);
        }

        return $services;
    }

    private function legionServices(array $saturdayToThursday, array $everyDay): array
    {
        $services = [];

        foreach ([
            ['08:00', $everyDay], ['13:00', $saturdayToThursday], ['16:00', $saturdayToThursday], ['18:30', $everyDay], ['20:45', $everyDay],
            ['14:00', ['friday']],
        ] as [$time, $days]) {
            $services[] = $this->service('Legion Travels', 'legion-himmafushi-male-'.$this->slugTime($time), 'Himmafushi Main Jetty', 'Male', $time, $days, 100, 10);
        }

        foreach ([
            ['11:30', $saturdayToThursday], ['15:00', $everyDay], ['17:00', $saturdayToThursday], ['20:00', $everyDay], ['22:30', $everyDay],
            ['09:00', ['friday']],
        ] as [$time, $days]) {
            $services[] = $this->service('Legion Travels', 'legion-male-himmafushi-'.$this->slugTime($time), 'Male', 'Himmafushi Main Jetty', $time, $days, 100, 10);
        }

        return $services;
    }

    private function service(string $name, string $slug, string $from, string $to, string $time, array $days, ?int $localPrice = null, ?int $touristPrice = null, ?string $notes = null): array
    {
        return [
            'name' => $name,
            'slug' => $slug,
            'from_location' => $from,
            'to_location' => $to,
            'type' => 'scheduled_speedboat',
            'departure_time' => $time,
            'operating_days' => $days,
            'local_price' => $localPrice,
            'tourist_price' => $touristPrice,
            'tourist_currency' => 'USD',
            'duration_minutes' => 45,
            'notes' => $notes,
        ];
    }

    private function slugTime(string $time): string
    {
        return str_replace(':', '', $time);
    }
}
