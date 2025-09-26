<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }

    public function informacion(){
        return view('home.info');
    }
    public function sobreNosotros(){
        return view('home.sobre');
    }
}
