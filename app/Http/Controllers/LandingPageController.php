<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('layouts.landing-page.main');
    }

    public function login()
    {
        return view('landing-page.login');
    }

    public function register()
    {
        return view('landing-page.register');
    }

    public function formPendaftaran()
    {
        return view('landing-page.form-pendafaran-periksa');
    }

    public function tiketAntrian()
    {
        return view('landing-page.tiket-antrian');
    }
}
