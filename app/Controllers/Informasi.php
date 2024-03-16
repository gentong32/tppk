<?php

namespace App\Controllers;

class Informasi extends BaseController
{
    public function index()
    {
        $instansiid = 0;
        if (session()->get('jenis_instansi_id'))
            $instansiid = session()->get('jenis_instansi_id');
        $data = [];
        $data['instansiid'] = $instansiid;
        return view('informasi', $data);
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

    public function ketunaan()
    {
        return view('informasiketunaan');
    }
}
