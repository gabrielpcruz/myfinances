<?php

namespace App\Http\Controllers;

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
                parseDbValue($request->get('balance'))
            );

            $account->setAttribute(
                'target',
                parseDbValue($request->get('target'))
            );

            $account->save();


            $transaction = new Transaction();
            $transaction->account_id = $account->id;

            $transaction->value = $account->balance;

            $transaction->save();

            DB::commit();

            return redirect('/')->with('success', 'Cadastrou');
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

            return redirect('/')->with('success', 'Cadastrou');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/')->with('error', $exception->getMessage());
        }
    }
}
