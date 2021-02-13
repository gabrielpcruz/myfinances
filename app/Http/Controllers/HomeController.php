<?php

namespace App\Http\Controllers;

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
        return view('home.index');
    }
}
