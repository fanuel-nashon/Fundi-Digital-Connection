<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function resolveLocationSearch(string $location): array
    {
        $location = trim($location);
        $normalized = strtolower($location);

        $mappings = [
            'dar es salaam' => ['Dar es Salaam'],
            'dar es' => ['Dar es Salaam'],
            'dar' => ['Dar es Salaam'],
            'dsm' => ['Dar es Salaam'],
            'dodoma' => ['Dodoma'],
            'dod' => ['Dodoma'],
            'zanzibar' => ['Zanzibar'],
            'stone town' => ['Zanzibar'],
            'arusha' => ['Arusha'],
            'mwanza' => ['Mwanza'],
            'mbeya' => ['Mbeya'],
            'tanga' => ['Tanga'],
            'morogoro' => ['Morogoro'],
            'mtwara' => ['Mtwara'],
            'kigoma' => ['Kigoma'],
            'pwani' => ['Pwani'],
            'manyara' => ['Manyara'],
            'iringa' => ['Iringa'],
        ];

        if (isset($mappings[$normalized])) {
            return $mappings[$normalized];
        }

        foreach ($mappings as $key => $values) {
            if (str_contains($normalized, $key)) {
                return $values;
            }
        }

        return [$location];
    }
}
