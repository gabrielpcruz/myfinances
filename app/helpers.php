<?php

use App\Models\Account;

if (!function_exists('roundValue')) {
    function roundValue( Account $account) {
        $value = ($account->target / 100 ) * $account->balance;

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
