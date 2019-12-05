<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\News\Models\News;
use App\Modules\Gallery\Models\Gallery;
use App\Modules\Match\Models\Match;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news        = $this->getNewsLatest();
        $latestPhoto = $this->getGalleryLatest();
        $upcoming    = $this->getUpcomingMatch();
       
        return view('frontend.index', ['news'=> $news, 'latestPhoto' => $latestPhoto, 'upcoming'=>$upcoming]);
    }

    // Home features image and Latest News data
    protected function getNewsLatest()
    {
        $data = News::orderByDesc('id')->limit(11)->get();
        return $data;
    }

    // Home Latest Photos
    protected function getGalleryLatest()
    {
        $data = Gallery::orderByDesc('id')->limit(6)->get();
        return $data;
    }

    // Home Upcomig Matches
    protected function getUpcomingMatch()
    {
        $data = Match::where('match_date','>', date('Y-m-d'))->orderby('match_date', 'ASC')->limit(4)->get();
        return $data;
    }
}
