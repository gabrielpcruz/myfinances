<?php

namespace App\Http\Controllers;

use App\Enum\TransactionType;
use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

/**
 * Class AccountController
 * @package App\Http\Controllers *
 * @author  Gabriel Cruz
 * @since   1.0.0
 * @version 1.0.0
 */
class AccountController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $account = new Account();
            $account->fill($request->all());

            $account->setAttribute(
                'balance',
                parse_db_value($request->get('balance'))
            );

            $account->setAttribute(
                'target',
                parse_db_value($request->get('target'))
            );

            $account->save();

            $transaction = new Transaction();
            $transaction->account_id = $account->id;
            $transaction->value = $account->balance;
            $transaction->type = TransactionType::INPUT;
            $transaction->save();

            DB::commit();

            return redirect('/')->with('success', 'Account created successfully!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $account = Account::query()->where('id', $id)->get()->first();

        return view(
            'account.edit',
            compact("account")
        );
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            Account::query()->where('id', $request->get('id'))->update([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ]);

            DB::commit();

            return redirect('/')->with('success', 'Account updated successfully!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function deposit()
    {
        $accounts = Account::all();

        return view(
            'account.deposit',
            compact("accounts")
        );
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function depositStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $account = Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->get()->first();

            $account->balance += parse_db_value($request->get('value'));

            Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->update([
                'balance' => $account->balance
            ]);

            $transaction = new Transaction();
            $transaction->value = parse_db_value($request->get('value'));
            $transaction->description = $request->get('description');
            $transaction->account_id = $account->id;
            $transaction->type = TransactionType::INPUT;
            $transaction->save();

            DB::commit();

            return redirect('/')->with('success', 'Deposit successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function draft()
    {
        $accounts = Account::all();

        return view(
            'account.draft',
            compact("accounts")
        );
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function draftStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $account = Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->get()->first();

            $account->balance -= parse_db_value($request->get('value'));

            Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->update([
                'balance' => $account->balance
            ]);

            $transaction = new Transaction();
            $transaction->value = parse_db_value($request->get('value'));
            $transaction->description = $request->get('description');
            $transaction->account_id = $account->id;
            $transaction->type = TransactionType::OUTPUT;
            $transaction->save();

            DB::commit();

            return redirect('/')->with('success', 'Draft successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function transfer()
    {
        $accounts = Account::all();

        return view(
            'account.transfer',
            compact("accounts")
        );
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function transferStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $accountOrigin = Account::query()->where([
                'id' => $request->get('origin')
            ])->get()->first();

            $accountOrigin->balance -= parse_db_value($request->get('value'));

            Account::query()->where([
                'id' => $accountOrigin->id
            ])->update([
                'balance' => $accountOrigin->balance
            ]);

            $transaction = new Transaction();
            $transaction->value = parse_db_value($request->get('value'));
            $transaction->description = $request->get('description');
            $transaction->account_id = $accountOrigin->id;
            $transaction->type = TransactionType::OUTPUT;
            $transaction->save();

            $accountTarget = Account::query()->where([
                'id' => $request->get('target')
            ])->get()->first();

            $accountTarget->balance += parse_db_value($request->get('value'));

            Account::query()->where([
                'id' => $accountTarget->id
            ])->update([
                'balance' => $accountTarget->balance
            ]);

            $transaction = new Transaction();
            $transaction->value = parse_db_value($request->get('value'));
            $transaction->description = $request->get('description');
            $transaction->account_id = $accountTarget->id;
            $transaction->type = TransactionType::INPUT;
            $transaction->save();

            DB::commit();

            return redirect('/')->with('success', 'Transfer successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }
}
