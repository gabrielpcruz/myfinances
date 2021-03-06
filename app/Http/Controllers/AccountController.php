<?php

namespace App\Http\Controllers;

use App\Enum\TransactionType;
use App\Exceptions\AccountException;
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
            return redirect('/account/create')->with('error', $exception->getMessage());
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
            return redirect('/account/edit')->with('error', $exception->getMessage());
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

            /** @var Account $account */
            $account = Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->get()->first();

            $this->toDeposit($account, $request, TransactionType::INPUT);

            DB::commit();

            return redirect('/')->with('success', 'Deposit successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/deposit')->with('error', $exception->getMessage());
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

            /** @var Account $account */
            $account = Account::query()->where([
                'id' => $request->get('selectAccount')
            ])->get()->first();

            $this->toDraft($account, $request, TransactionType::OUTPUT);

            DB::commit();

            return redirect('/')->with('success', 'Draft successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/draft')->with('error', $exception->getMessage());
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

            if ($request->origin == $request->target) {
                throw new AccountException("The target account can't be the same of origin!");
            }

            /** @var Account $account */
            $accountOrigin = Account::query()->where([
                'id' => $request->origin
            ])->get()->first();

            $this->toDraft($accountOrigin, $request, TransactionType::OUTPUT);

            /** @var Account $account */
            $accountTarget = Account::query()->where([
                'id' => $request->target
            ])->get()->first();

            $this->toDeposit($accountTarget, $request, TransactionType::INPUT);

            DB::commit();

            return redirect('/')->with('success', 'Transfer successful!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect('/transfer')->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Account $account
     * @param Request $request
     * @param string $transactionType
     */
    protected function toDeposit(
        Account $account,
        Request $request,
        string $transactionType
    ): void {
        $account->deposit($request->value);
        $account->save();

        $this->doTransaction($request, $account, $transactionType);
    }

    /**
     * @param Account $account
     * @param Request $request
     * @throws AccountException
     */
    protected function toDraft(
        Account $account,
        Request $request,
        string $transactionType
    ): void {
        $account->draft($request->value);
        $account->save();

        $this->doTransaction($request, $account, $transactionType);
    }

    /**
     * @param Request $request
     * @param Account $account
     * @param string $transactionType
     */
    protected function doTransaction(
        Request $request,
        Account $account,
        string $transactionType
    ): void {
        $transaction = new Transaction();
        $transaction->value = $request->value;
        $transaction->description = $request->description;
        $transaction->account_id = $account->id;
        $transaction->type = $transactionType;
        $transaction->save();
    }
}
