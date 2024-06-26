<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function edit(){
        return view('user.edit');
    }

    public function page_not_found(){
        return view('errors.404');
    }

    public function search(){
        return view('user.search_mobile');
    }

    public function about(){
        return view('about');
    }
}
