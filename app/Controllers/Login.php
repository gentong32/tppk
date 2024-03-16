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
        if (isset($_GET['tokenKey'])) {
            $asal = "internal";
            $tokenKey = $_GET['tokenKey'];
        } else if (isset($_GET['code'])) {
            $asal = "eksternal";
            $tokenKey = $_GET['code'];
        } else {
            echo "Failed";
        }

        if ($asal == "internal") {
            $checkToken = $this->model_tppk->getTokenSSO($tokenKey);
            if ($checkToken->tokenStatus > 0) {
                $akun = $this->model_tppk->getAkunSSO($tokenKey);

                $npsnuser = $akun->NPSN;
                if ($akun->jenis_instansi_id == 2 || $akun->jenis_instansi_id == 3)
                    $npsnuser = $akun->wilayah_akses;
                // echo var_dump($akun);
                // die();
                $user = $akun->pengguna_id;
                if ($user) {
                    $sekolah_id = $this->model_tppk->getSekolah($akun->NPSN);
                    $params = [
                        'loggedIn' => true,
                        'jenis_instansi_id' => $akun->jenis_instansi_id,
                        'nama' => $akun->nama,
                        'wilayah_akses' => $akun->wilayah_akses,
                        'sekolah_id' => $sekolah_id,
                        'npsn_user' => $npsnuser,
                        'username' => $akun->username,
                        'peran' => 'userverval',
                        'ptk_id' => '',
                        'asallogin' => 'internal',
                        'statustppk' => 'asing',
                    ];
                    session()->set($params);
                    $this->model_tppk->simpan_log_userlogin();
                }

                $username = session()->get('username');
                if ($username == "hardianto@kemdikbud.go.id") {
                    // session()->set('ptk_id', '66111A84-5B4D-11E5-94E2-A7F79F7D0280'); ketuaTPPK
                    // session()->set('ptk_id', 'D25DBF84-7822-E211-8A8B-7DB32FE8C53D'); anggota1
                    // session()->set('wilayah_akses', '191400');
                    // session()->set('asallogin', 'eksternal');
                    // session()->set('npsn_user', 'NP751295');
                    // session()->set('ptk_id', 'A7CAC384-7822-E211-8A8D-7DB32FE8C53D');
                    // session()->set('jenis_instansi_id', '5');
                    // session()->set('sekolah_id', '00E09B94-2BF5-E011-9894-31473205A536');
                    // session()->set('statustppk', 'anggotalain');
                }

                return redirect()->to('/home');
            }
        } else if ($asal == "eksternal") {
            $opsilogin = session()->get('opsilogin');
            if ($opsilogin == "test") {
                $tokendapo = $this->getTokenDapo($tokenKey);
                $profile = $this->getProfile($tokendapo);
            } else {
                $tokendapo = $this->getTokenDapoProduction($tokenKey);
                $profile = $this->getProfileProduction($tokendapo);
            }

            $username = session()->get('username');
            // if ($username == "hardianto@kemdikbud.go.id") {
            // echo "TokenKey:$tokenKey";
            // echo "TokenDapo:$tokendapo";
            // echo "Redirecting...";
            // sleep(5);
            // }
            $data = json_decode($profile, true);

            $sekolah_id = $data['sekolah_id'];
            $ptk_id = $data['ptk_id'];

            $npsn = $this->model_tppk->getNPSNSekolah($sekolah_id);

            $peran_dalam_tim = cekstatuskeanggotaan($sekolah_id, $ptk_id);

            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => '99',
                'nama' => $data['nama'],
                'wilayah_akses' => $data['kode_wilayah'],
                'sekolah_id' => $sekolah_id,
                'npsn_user' => $npsn->npsn,
                'username' => $data['username'],
                'peran' => $data['peran'],
                'ptk_id' => $ptk_id,
                'asallogin' => 'eksternal',
                'statustppk' => $peran_dalam_tim,
                'tokenkey' => $tokenKey,
                'tokendapo' => $tokendapo,
            ];
            session()->set($params);
            $this->model_tppk->simpan_log_userlogin();

            $cektews = session()->get('tes');
            if ($cektews) {
                $pesan = "<script>window.parent.postMessage('Granted', '*');</script>";
                echo $pesan;
            } else
                return redirect()->to('/inputdata/daftar_laporan');

            // echo var_dump($profile);
        }
    }

    private function getTokenDapodik($kode)
    {
        $url = 'https://dev-sso.datadik.kemdikbud.go.id/token';
        $data = 'app_id=60B05B81-79A8-46D0-9458-7B10E5B7606C&code=' . $kode . '&client_secret=162ad1abebf1410aa85e4e5b172942ae';

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => $data,
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        return $response;
    }

    private function getTokenDapo($kode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev-sso.datadik.kemdikbud.go.id/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 30,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'app_id=60B05B81-79A8-46D0-9458-7B10E5B7606C&code=' . $kode . '&client_secret=162ad1abebf1410aa85e4e5b172942ae',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    private function getTokenDapoProduction($kode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sso.datadik.kemdikbud.go.id/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 30,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'app_id=20415431-3207-4FC5-828A-6EDA56CA5F64&code=' . $kode . '&client_secret=56690624b6ec4beba12471eb531c0180',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    private function getProfileProduction($token)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sso.datadik.kemdikbud.go.id/profile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $token,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    private function getProfile($token)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev-sso.datadik.kemdikbud.go.id/profile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'token=' . $token,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
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

    public function pindah($opsi = null)
    {
        $username = session()->get('username');
        if ($username == "hardianto@kemdikbud.go.id") {
            if ($opsi == "help") {
                echo "npsn,ptk_id,wilayah,asallogin,jenis_instansi,sekolah_id,statustppk";
            } else {
                $request = \Config\Services::request();
                session()->set('npsn_user', $request->getVar('npsn') ?? null);
                session()->set('ptk_id', $request->getVar('ptk_id') ?? null);
                session()->set('wilayah_akses', $request->getVar('wilayah') ?? null);
                session()->set('asallogin', $request->getVar('asallogin') ?? null);
                session()->set('jenis_instansi_id', $request->getVar('jenis_instansi') ?? null);
                session()->set('sekolah_id', $request->getVar('sekolah_id') ?? null);
                session()->set('statustppk', $request->getVar('statustppk') ?? null);
                return redirect()->to('/home');
            }
        }
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
