<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function home(Request $request)
    {        
        $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', 'index')->orWhere('slug', 'home')->first();
        if ($data) {
            return view('front.common', ["slug" => $data->slug, "data" => $data]);
        } else {
            return abort(404);
        }
    }

    public function pages(Request $request)
    {
        if (in_array($request->slug, ['cart', 'wishlist', 'my-account', 'search-for-diamonds', 'rough-diamonds', '4p-diamonds', 'polish-diamonds'])) {
            if (!Auth::check()) {
                return redirect('/');
            }
        }
        $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', $request->slug)->first();
        if ($data) {
            return view('front.common', ["slug" => $data->slug, "data" => $data]);
        } else {
            return abort(404);
        }
    }   
}
