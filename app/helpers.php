<?php

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('getPercentAccount')) {
    function getPercentAccount( Account $account) {
        $value = ($account->balance * 100 ) / $account->target;

        return roundValue($value);
    }
}

if (!function_exists('roundValue')) {
    function roundValue($value) {
        return floatval(round($value, 2));
    }
}

if (!function_exists('parseDbValue')) {
    function parseDbValue($value) {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return floatval($value);
    }
}

if (!function_exists('reduce')) {
    function reduce(Collection $items, string $field) {
        return array_reduce($items->toArray(), function ($sum, $account) use ($field) {
            $sum += $account[$field];

            return $sum;
        });
    }
}

