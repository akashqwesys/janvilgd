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
        if ($request->slug == 'blog') {
            $blogs = DB::table('blogs')
                ->select('blog_id', 'title', 'image', 'video_link', 'description', 'slug')
                ->get();
            return view('front.blogs', ["data" => $blogs]);
        } else if ($request->slug == 'events') {
            $events = DB::table('events')
                ->select('event_id', 'title', 'image', 'video_link', 'description', 'slug')
                ->get();
            return view('front.events', ["data" => $events]);
        } else if ($request->slug == 'media') {
            $media = DB::table('media')
                ->select('media_id', 'title', 'image', 'video_link', 'description', 'slug')
                ->get();
            return view('front.media', ["data" => $media]);
        } else if ($request->slug == 'gallery') {
            $galleries = DB::table('galleries')
                ->select('gallery_id', 'title', 'image')
                ->get();
            return view('front.gallery', ["data" => $galleries]);
        } else {
            $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', $request->slug)->first();
            if ($data) {
                return view('front.common', ["slug" => $data->slug, "data" => $data]);
            } else {
                return abort(404);
            }
        }
    }
}
