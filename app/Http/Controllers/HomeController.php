<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $country = Country::where('status', 1)->get();
        $tags = Tag::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        return view('lead.index', compact('tags', 'cities', 'country'));
    }
}
