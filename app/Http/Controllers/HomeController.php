<?php

namespace App\Http\Controllers;

use App\Models\Account;

/**
 * Class HomeController
 * @package App\Http\Controllers *
 * @author  Gabriel Cruz
 * @since   1.0.0
 * @version 1.0.1
 */
class HomeController extends Controller
{
    public function index()
    {
        $accounts = Account::all()->where('done', '=' , 0);

        return view(
            'home.index',
            compact("accounts")
        );
    }
}
