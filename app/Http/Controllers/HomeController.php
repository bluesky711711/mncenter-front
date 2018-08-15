<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phase;
use App\Contract;
use App\Setting;
use Log;
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
        date_default_timezone_set('UTC');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [
          'page' => 'index',
        ]);
    }

    public function faq()
    {
        return view('faq', [
          'page' => 'faq',
        ]);
    }

}
