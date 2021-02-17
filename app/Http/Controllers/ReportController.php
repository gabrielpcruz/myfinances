<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return view(
            'report.index',
            compact("accounts")
        );
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        $accountSelected = $request->get('selectAccount');

        $account = Account::query()->where([
            'id' => $accountSelected
        ])->with('transactions')->get()->first();

        $accounts = Account::all();

        $transactions = $account->transactions;

        return view(
            'report.index',
            compact("transactions", "accounts", "accountSelected")
        );
    }
}
