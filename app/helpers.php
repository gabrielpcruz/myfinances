<?php

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('get_percent_account')) {
    function get_percent_account(Account $account) {
        $value = ($account->balance * 100 ) / $account->target;

        return round_value($value);
    }
}

if (!function_exists('round_value')) {
    function round_value($value) {
        return floatval(round($value, 2));
    }
}

if (!function_exists('parse_db_value')) {
    function parse_db_value($value) {
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

if (!function_exists('is_account_selected')) {
    function is_account_selected(Account $account, $accountSelected) {
        if (!$accountSelected) {
            return "";
        }

        return $accountSelected == $account->id ? "selected=selected" : "";
    }
}

if (!function_exists('is_transaction_type_selected')) {
    function is_transaction_type_selected($transactionSelected, $value) {
        if (!$transactionSelected) {
            return "";
        }

        return $transactionSelected == $value ? "selected=selected" : "";
    }
}



