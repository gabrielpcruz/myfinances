<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BackupController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $accounts = Account::all()->toJson();
        $transactions = Transaction::all()->toJson();

        return view(
            'backup.index',
            compact("accounts", "transactions")
        );
    }
}
