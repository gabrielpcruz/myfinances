<?php

namespace App\Http\Controllers;

/**
 * Class AccountController
 * @package App\Http\Controllers *
 * @author  Gabriel Cruz
 * @since   1.0.0
 * @version 1.0.0
 */
class AccountController extends Controller
{
    public function create()
    {
        return view('account.create');
    }
}
