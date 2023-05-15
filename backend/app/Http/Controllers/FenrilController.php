<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \App\Fenril;
use \App\Http\Requests\CreateFenril;

class FenrilController extends Controller
{
    public function index()
    {
        return view('fenril/index');
    }

}
