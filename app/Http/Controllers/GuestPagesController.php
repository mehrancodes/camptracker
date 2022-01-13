<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestPagesController extends Controller
{
    public function howItWorks()
    {
        return view('howitworks');
    }

    public function pricing()
    {
        return view('pricing');
    }
}
