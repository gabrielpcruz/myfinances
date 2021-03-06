<?php

namespace App\Http\Controllers;

use App\Enum\TransactionType;
use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $initialDate = "";
        $finalDate = "";
        $transactions = [];
        $accountSelected = "";
        $totalInputs = "";
        $totalOutputs = "";
        $transactionType = "";

        return view(
            'report.index',
            compact(
                "transactions",
                "accounts",
                "accountSelected",
                "initialDate",
                "finalDate",
                "totalInputs",
                "totalOutputs",
                "transactionType"
            )
        );
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show(Request $request)
    {
        $accountSelected = $request->get('selectAccount');
        $accounts = Account::all();

        $totalInputs = 0;
        $totalOutputs = 0;

        $initialDate = $request->initialDate;
        $finalDate = $request->finalDate;
        $transactionType = $request->transactionType;

        $query = Transaction::query()->where([
            'account_id' => $accountSelected
        ]);

        if ($initialDate && $finalDate) {
            $from = new Carbon($initialDate);
            $to = new Carbon($finalDate);

            $query->whereBetween('date', [$from->toDateTimeString(), $to->endOfDay()]);
        }

        if ($transactionType != "") {
            $query->where([
                'type' => $transactionType
            ]);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        foreach ($transactions as $transaction) {
            $totalInputs += $transaction->type == TransactionType::INPUT ? $transaction->value : 0;
            $totalOutputs += $transaction->type == TransactionType::OUTPUT ? $transaction->value : 0;
        }

        return view(
            'report.index',
            compact(
                "transactions",
                "accounts",
                "accountSelected",
                "initialDate",
                "finalDate",
                "totalInputs",
                "totalOutputs",
                "transactionType"
            )
        );
    }
}
