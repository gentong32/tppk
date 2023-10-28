<?php

namespace App\Controllers;

class Informasi extends BaseController
{
    public function index()
    {
        return view('informasi');
    }

    public function peraturan()
    {
        return view('info_peraturan');
    }

    public function tppk()
    {
        return view('info_tppk');
    }

    public function satgas()
    {
        return view('info_satgas');
    }

    public function syarat()
    {
        return view('info_syarat');
    }
}
