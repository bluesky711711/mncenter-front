<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use App\Video;
class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        date_default_timezone_set('UTC');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function videos()
    {
        $videos = Video::all();
        return view('videos', [
          'page' => 'videos',
          'videos' => $videos
        ]);
    }
}
