<?php

namespace App\Support;

use ResourceBundle;

class Countries
{
    public static function all(): array
    {
        if (! class_exists(ResourceBundle::class)) {
            return ['Maldives' => 'Maldives'];
        }

        $regions = ResourceBundle::create('en', 'ICUDATA-region')?->get('Countries');
        $countries = [];
        $nonCountries = ['AC', 'CP', 'DG', 'EA', 'EU', 'EZ', 'IC', 'QO', 'TA', 'UN', 'XA', 'XB'];

        if ($regions instanceof ResourceBundle) {
            foreach ($regions as $code => $name) {
                if (preg_match('/^[A-Z]{2}$/', (string) $code) && ! in_array($code, $nonCountries, true) && $name !== 'Unknown Region') {
                    $countries[(string) $name] = (string) $name;
                }
            }
        }

        ksort($countries);

        return $countries ?: ['Maldives' => 'Maldives'];
    }
}
