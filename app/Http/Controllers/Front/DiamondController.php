<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiamondController extends Controller
{
    public function home(Request $request)
    {
        return view('front.search_diamonds');
    }
}
