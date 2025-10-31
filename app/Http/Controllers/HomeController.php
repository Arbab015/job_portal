<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function aboutIndex()
    {
        return view('frontend.about');
    }
    public function shopIndex()
    {
        return view('frontend.shop');
    }

    public function shopSingleIndex()
    {
        return view('frontend.shop-single');
    }

    public function contactIndex()
    {
        return view('frontend.contact');
    }
}
