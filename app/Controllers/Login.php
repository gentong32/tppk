<?php

namespace App\Controllers;

use App\Models\M_tppk;

class Login extends BaseController
{

    function __construct()
    {
        $this->model_tppk = new M_tppk();
    }

    public function index()
    {
        //
    }

    public function sebagai($opsi)
    {
        session()->set('loggedIn', true); // Menyimpan data sesi
        session()->set('sebagai', $opsi);
        return redirect()->to('/home');
    }

    public function actionLoginsso()
    {
        session()->remove('loggedIn');
        $tokenKey = $_GET['tokenKey'];
        $checkToken = $this->model_tppk->getTokenSSO($tokenKey);
        if ($checkToken->tokenStatus > 0) {
            $akun = $this->model_tppk->getAkunSSO($tokenKey);
            // echo var_dump($akun);
            // die();
            $user = $akun->pengguna_id;
            if ($user) {
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => $akun->jenis_instansi_id,
                    'nama' => $akun->nama,
                    'wilayah_akses' => $akun->wilayah_akses,
                    'npsn_user' => $akun->NPSN,
                    'username' => $akun->username
                ];
                session()->set($params);
                $this->model_tppk->simpan_log_userlogin();
            }

            return redirect()->to('/home');
        }
    }

    /////////////////// [sdm].[dbo].[app], [sdm].[dbo].[role], [sdm].[dbo].[role], [sdm].[dbo].[userrole], [sdm].[dbo].[instansi_pengguna] [sdm].[dbo].[pengguna]

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/home');
    }

    public function login_dummy()
    {
        $session = session();
        $flashMessage = $session->getFlashdata('flash_message');
        return view('loginpalsu', ['flashMessage' => $flashMessage]);
    }

    public function cek_dummy()
    {
        $user = $this->request->getPost("Pengguna[email]");
        $password = $this->request->getPost("Pengguna[password]");

        $sebagai = session()->get('sebagai');
        $instansiid = session()->get('jenis_instansi_id');

        if ($user == "operatorsekolah" && $password == "os12345") {
            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 5,
                'nama' => "Operator Sekolah",
                'wilayah_akses' => 000000,
                'npsn_user' => 99999999,
                'sebagai' => 'os'
            ];
            session()->set($params);
            return redirect()->to('/home');
        } else if ($user == "dinasprovinsi" && $password == "dp12345") {
            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 1,
                'nama' => "Dinas Provinsi",
                'wilayah_akses' => 000000,
                'npsn_user' => 99999999,
                'sebagai' => 'dp'
            ];
            session()->set($params);
            return redirect()->to('/home');
        } else if ($user == "dinaskota" && $password == "dk12345") {
            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 1,
                'nama' => "Dinas Kabupaten",
                'wilayah_akses' => 000000,
                'npsn_user' => 99999999,
                'sebagai' => 'dk'
            ];
            session()->set($params);
            return redirect()->to('/home');
        } else {
            $session = session();
            $session->setFlashdata('flash_message', 'Email atau password salah!');
            return redirect()->to('/login/login_dummy');
        }
    }
}
