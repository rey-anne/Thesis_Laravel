<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function education()
    {
        return view('education');
    }

    public function crowdsource()
    {
        return view('crowdsource');
    }

    public function cybersecurity()
    {
        return view('cybersecurity');
    }

    public function about()
    {
        return view('about');
    }

    public function firefighterHome()
    {
        return view('firefighter.home');
    }

    public function firefighterReports()
    {
        return view('firefighter.reports');
    }

    public function firefighterProfile()
    {
        return view('firefighter.profile');
    }
}
