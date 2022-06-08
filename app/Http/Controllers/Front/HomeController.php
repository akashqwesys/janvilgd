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
            return view('front.blogs.blogs', ["data" => $blogs]);
        } else if ($request->slug == 'events') {
            $events = DB::table('events')
                ->select('event_id', 'title', 'image', 'video_link', 'description', 'slug')
                ->get();
            return view('front.events.events', ["data" => $events]);
        } else if ($request->slug == 'media') {
            $media = DB::table('media')
                ->select('media_id', 'title', 'image', 'video_link', 'description', 'slug')
                ->get();
            return view('front.media.media', ["data" => $media]);
        } else if ($request->slug == 'gallery') {
            $galleries = DB::table('galleries')
                ->select('gallery_id', 'title', 'image')
                ->get();
            return view('front.gallery', ["data" => $galleries]);
        } else if ($request->slug == 'contact') {
            $country = DB::table('country')
                ->select('country_id', 'name', 'country_code', DB::raw("cast (country_code as integer) as cc"))
                ->whereRaw('SUBSTRING(country_code, 1, 1) not in (\'+\',\'-\')')
                ->where('is_active', 1)->where('is_deleted', 0)
                ->orderBy('cc', 'asc')
                ->get();
            $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', $request->slug)->first();
            return view('front.contact', ["data" => $data, 'country' => $country]);
        } else {
            $data = DB::table('informative_pages')->select('informative_page_id', 'name', 'content', 'slug', 'updated_by', 'is_active', 'date_updated')->where('slug', $request->slug)->first();
            if ($data) {
                return view('front.common', ["slug" => $data->slug, "data" => $data]);
            } else {
                return abort(404);
            }
        }
    }

    public function blogDetail(Request $request, $blog_id, $blog_detail)
    {
        $data = DB::table('blogs')
            ->select('blog_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('blog_id', $blog_id)
            ->first();
        $recent = DB::table('blogs')
            ->select('blog_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('blog_id', '<>', $blog_id)
            ->orderBy('blog_id', 'desc')
            ->limit(5)
            ->get();
        return view('front.blogs.blogs-details', compact('data', 'recent'));
    }

    public function mediaDetail(Request $request, $media_id, $media_detail)
    {
        $data = DB::table('media')
            ->select('media_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('media_id', $media_id)
            ->first();
        $recent = DB::table('media')
            ->select('media_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('media_id', '<>', $media_id)
            ->orderBy('media_id', 'desc')
            ->limit(5)
            ->get();
        return view('front.media.media-details', compact('data', 'recent'));
    }

    public function eventDetail(Request $request, $event_id, $event_detail)
    {
        $data = DB::table('events')
            ->select('event_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('event_id', $event_id)
            ->first();
        $recent = DB::table('events')
            ->select('event_id', 'title', 'image', 'video_link', 'description', 'slug', 'created_at')
            ->where('event_id', '<>', $event_id)
            ->orderBy('event_id', 'desc')
            ->limit(5)
            ->get();
        return view('front.events.events-details', compact('data', 'recent'));
    }
}
