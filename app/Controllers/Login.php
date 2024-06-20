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

    public function loginevent()
    {
        echo view('login_umum');
    }

    public function ceklogin()
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $tanggalSekarang = date('Y-m-d');
        $tanggalTertentu = date('Y-m-d', strtotime('2024-04-21'));

        $ceklogin = $this->model_tppk->cekpsw($username, $password);

        if ($ceklogin > 0 && $tanggalSekarang < $tanggalTertentu) {
            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 99,
                'nama' => "Puspeka",
                'wilayah_akses' => "000000",
                'sekolah_id' => "",
                'npsn_user' => "000000",
                'username' => "puspeka_user",
                'peran' => 'viewersk',
                'ptk_id' => '',
                'asallogin' => 'internal',
                'statustppk' => 'viewersk',
                'sebagai' => 'viewersk',
                'loginnik' => false,
            ];
            session()->set($params);
            return redirect()->to("/");
        } else {
            session()->setFlashdata('pesan', 'Username atau password salah.');
            return redirect()->back();
        }
    }

    public function login_dapodik($opsilogin = "prod")
    {
        if ($opsilogin == "test")
            $viewlogin = "login_eksternal_test";
        else
            $viewlogin = "login_eksternal";
        return view($viewlogin);
    }

    public function login_satgas()
    {
        session()->set('lupa', false);
        return view("login_satgas");
    }

    public function lupa_password()
    {
        session()->set('lupa', true);
        return view("lupa_password");
    }

    public function reset_password()
    {
        session()->set('reset', true);
        return view("reset_password");
    }

    public function updatekodereset()
    {
        $username = $this->request->getPost("username");

        $ceklogin = $this->model_tppk->cekanggotasatgasemail($username);

        // die();
        if ($ceklogin) {

            // CEK BARUSAN SUDAH DIKIRIM BELUM (KODE 2) MAKSIMAL 5 MENIT
            $proseskirim = true;
            $cekantrian = $this->model_tppk->cek_antrian_email($username, 2);
            if ($cekantrian) {
                $tglantrian = strtotime($cekantrian['0']->created_at);
                // echo $cekantrian['0']->created_at;
                // die();
                $waktusekarang = time();
                $tglantrian_plus_5_menit = $tglantrian + (5 * 60);
                if ($tglantrian_plus_5_menit > $waktusekarang) {
                    $pesannya = "Permintaan sudah dikirim beberapa saat lalu";
                    $proseskirim = false;
                }
            }

            if ($proseskirim) {
                /// AKAN DI PROSES KIRIM KE EMAIL ----------------------

                // CEK KUOTA DULU, KALAU MASIH ADA LANGSUNG KIRIM, JIKA TIDAK MASUK ANTRIAN
                $getkuota = $this->model_tppk->cekkuotaemail();
                $kuota = $getkuota->kuota;
                $limit_time = $getkuota->limit_time;
                date_default_timezone_set('Asia/Jakarta');
                $now = date('Y-m-d H:i:s');
                if ($now > $limit_time) {
                    $kuota = 0;
                    $this->model_tppk->resetkuotaemail();
                }

                if ($kuota < 500) {
                    $updatekuota = $this->model_tppk->updatekuotaemail($kuota);

                    //// KIRIM KE EMAIL
                    if ($updatekuota) {
                        $kodeacak = $this->generateRandomCode();
                        $update = $this->model_tppk->update_data_kode_reset($username, $kodeacak);
                        if ($update) {
                            $this->model_tppk->masuk_antrian_email($kodeacak, $username, 2);
                            $this->model_tppk->update_antrian_email($username, 2, 0);
                            /// 2 itu artinya langsung dikirim
                            return $this->sendEmail($kodeacak, $username);
                        }
                    } else {
                        $pesannya = "ADA MASALAH DENGAN PROSES PENGIRIMAN EMAIL. HUBUNGI ADMIN";
                    }
                } else {
                    $cekantrian = $this->model_tppk->cek_antrian_email($username, 0); /// 0 berarti cek apakah ada daftar antrian pending
                    if (!$cekantrian) {
                        $kodeacak = $this->generateRandomCode();
                        $update = $this->model_tppk->update_data_kode_reset($username, $kodeacak);
                        if ($update) {
                            $this->model_tppk->masuk_antrian_email($kodeacak, $username, 0); /// 0 itu artinya masuk antrian
                            $pesannya = "Karena layanan email penuh, maka permintaan password masuk ke dalam antrian baru";
                        }
                    } else {
                        $pesannya = "Sudah masuk antrian, mohon ditunggu saja";
                    }
                }
            }
            session()->setFlashdata('pesan', $pesannya);
            return redirect()->back();
        } else {
            session()->setFlashdata('pesan', 'Alamat email ini tidak terdaftar dalam SK Satgas atau tidak ditunjuk sebagai operator Satgas.');
            return redirect()->back();
        }
    }

    private function generateRandomCode($length = 8)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomCode;
    }


    public function ubahpassword()
    {
        $loggedIn = session()->get('loggedIn');
        $sebagai = session()->get('sebagai');
        $peran = session()->get('peran');
        if ($loggedIn && $sebagai == "operatorsatgas" && ($peran == "ketua" || $peran == "anggota1"))
            return view('ubah_password');
        else
            return redirect()->to("/");
    }

    public function loginUser()
    {
        $email = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (is_array($password) || $password === null) {
            throw new InvalidArgumentException('Password must be a string.');
        }

        if ($email == "" || $email == null) {
            return redirect()->to('/');
        }

        $password = (string) $password;

        $hashedPassword = hash('sha256', $password);

        $storedHash = $this->model_tppk->getPasswordHashByEmail($email);

        if ($storedHash && $hashedPassword === $storedHash->password) {
            if ($storedHash->anggotake == 0)
                $peran = "ketua";
            else if ($storedHash->operator_satgas == 1)
                $peran = "anggota1";

            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 100,
                'nama' => $storedHash->nama,
                'wilayah_akses' => $storedHash->kode_wilayah,
                'sekolah_id' => "",
                'npsn_user' => "",
                'username' => $email,
                'peran' => $peran,
                'ptk_id' => $storedHash->pengguna_id,
                'asallogin' => 'op_satgas',
                'statustppk' => $storedHash->status_approval,
                'sebagai' => 'operatorsatgas',
                'loginnik' => false,
            ];
            session()->set($params);

            $perannya = '';
            $jabatan = $peran;
            $getdata = $this->model_tppk->getdataopsatgas($email);
            $telp = $getdata['telepon'];

            $this->model_tppk->simpan_log_userlogin(3, $perannya, $jabatan, $telp);

            // if ($storedHash->unggah_sk == 1) {
            //     if ($storedHash->status_approval < 2)
            //         return redirect()->to('/status_approval');
            //     else
            return redirect()->to('/');
            // } else
            //     return redirect()->to('/unggah_sk');
        } else {
            // if (session()->get('reset') == true) {
            //     $cekemailoperator = $this->model_tppk->cekEmailOperatorTerdaftar($email);
            //     if (!$cekemailoperator) {
            //         session()->setFlashdata('error', 'Username / Password salah atau Anda bukan Ketua Satgas ataupun anggota yang ditunjuk!<br>');
            //         return redirect()->back()->withInput();
            //     }
            // }
            // $cekloginbykode = $this->cekloginbynik($email, $password);
            if ($password == "-") {
                session()->setFlashdata('error', 'Username / Password salah atau Anda bukan Ketua Satgas ataupun anggota yang ditunjuk sebagai admin oleh Ketua Satgas.<br>');
                return redirect()->back()->withInput();
            }
            $cekloginbykode = $this->cekloginbykode($email, $password);
            if ($cekloginbykode) {
                $peran = "";
                if ($cekloginbykode->anggotake == 0)
                    $peran = "ketua";
                else if ($cekloginbykode->operator_satgas == 1)
                    $peran = "anggota1";

                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 20,
                    'nama' => $cekloginbykode->nama,
                    'wilayah_akses' => $cekloginbykode->kode_wilayah,
                    'sekolah_id' => $cekloginbykode->telepon,
                    'npsn_user' => "",
                    'username' => $email,
                    'peran' => $peran,
                    'ptk_id' => $cekloginbykode->nik,
                    'asallogin' => 'op_satgas',
                    'statustppk' => "",
                    'sebagai' => 'operatorsatgas',
                    'loginnik' => true,
                ];
                session()->set($params);
                return redirect()->to(base_url('ubah_password'));
            } else {
                session()->setFlashdata('error', 'Username / Password salah atau Anda bukan Ketua Satgas ataupun anggota yang ditunjuk sebagai admin oleh Ketua Satgas.<br>');
                return redirect()->back()->withInput();
            }
        }
    }

    private function cekloginbynik($email, $password)
    {
        $ceklogin = $this->model_tppk->cekanggotasatgas($email, $password);
        return $ceklogin;
    }

    private function cekloginbykode($email, $password)
    {
        $ceklogin = $this->model_tppk->cekanggotasatgaskode($email, $password);
        return $ceklogin;
    }

    public function register_satgas()
    {
        $getprovinsi = $this->model_tppk->get_daf_provinsi();
        $data['daf_provinsi'] = $getprovinsi;
        $viewlogin = "register_satgas";
        return view($viewlogin, $data);
    }

    public function update_operator_satgas()
    {
        $request = \Config\Services::request();
        $input = $request->getJSON();

        $email_ketua = $input->email_ketua;
        $email = $input->email;
        $satgas_id = $input->id;
        $sk_id = $input->sk_id;
        $kode_wilayah = $input->kode_wilayah;

        $update = $this->model_tppk->update_data_operator($email_ketua, $email, $satgas_id, $sk_id, $kode_wilayah);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'csrf' => csrf_hash()]);
        } else {
            return $this->response->setJSON(['success' => false, 'csrf' => csrf_hash()]);
        }
    }

    private function sendEmail($kode_pass, $alamatemail)
    {
        $email = \Config\Services::email();

        $email->setFrom('hardianto@kemdikbud.go.id', 'hardianto@kemdikbud.go.id');
        $email->setTo($alamatemail);

        $email->setSubject('Informasi Registrasi');
        $email->setMessage('Email ini dikirim secara otomatis oleh sistem aplikasi TPPK menggunakan alamat email hardianto.kemdikbud.go.id.

        Dengan dikirimkan email ini, maka diinformasikan terkait kode password yang dapat anda masukkan untuk Login ke alamat https://referensi.kemdikbud.go.id/tppk.

        Silakan klik menu <b>Masuk</b> lalu pilih <b>Sebagai Operator Satgas</b>.<br> Masukkan alamat email anda yang terdaftar dalam SK Satgas pada bagian Username, kemudian masukkan kode berikut ini pada bagian Password.<br><br>
        
        Kode password anda adalah: <b>' . $kode_pass . '</b><br><br>
        Terimakasih.<br>');

        if ($email->send()) {
            return redirect()->to('/info_reset_password');
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
            return redirect()->to('/info_reset_password');
        }
    }

    function generate_uuid_v4()
    {
        if (function_exists('random_bytes')) {
            $data = random_bytes(16);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $data = openssl_random_pseudo_bytes(16);
        } else {
            return false;
        }

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set versi 4 (0100)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set bit pengaturan (1000)

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function status_approval()
    {
        $email = session()->get('username');
        $data_user = $this->model_tppk->getPasswordHashByEmail($email);
        $statusfile = $data_user->unggah_sk;
        $statusapproval = $data_user->status_approval;
        if ($statusfile == 0)
            return redirect()->to('/unggah_sk');
        if ($statusapproval == 0)
            $txtstatus = "MENUNGGU PROSES APROVAL";
        else if ($statusapproval == 1)
            $txtstatus = "<span style='color:red'>Tidak disetujui</span>";
        else if ($statusapproval == 2) {
            session()->set('statustppk', 2);
            $txtstatus = "<span style='color:green'>Disetujui</span>";
        }
        $data['status'] = $statusapproval;
        $data['txtstatus'] = $txtstatus;
        $data['keterangan'] = $data_user->keterangan;
        return view('status_approval', $data);
    }

    public function add_operator_satgas()
    {
        $request = \Config\Services::request();

        $nik = $request->getVar('nik');
        $nama_lengkap = $request->getVar('nama_lengkap');
        $tempat_lahir = $request->getVar('tempat_lahir');
        $tanggal_lahir = $request->getVar('tanggal_lahir');
        $date = \DateTime::createFromFormat('d-m-Y', $tanggal_lahir);
        $formatted_date = $date->format('Y-m-d');
        $jenis_kelamin = $request->getVar('jenis_kelamin');
        $formatted_jk = substr($jenis_kelamin, 0, 1);
        $alamat_rumah = $request->getVar('alamat');
        $no_hp = $request->getVar('no_hp');
        $alamat_email = $request->getVar('email');
        $password = $request->getVar('password');
        $hashedPassword = hash('sha256', $password);
        $provinsi = $request->getVar('provinsi');
        $kota = $request->getVar('kota');

        $kode_wilayah = $provinsi;
        if ($kota != "0")
            $kode_wilayah = $kota;
        // $captcha = $request->getPost('captcha');

        $pengguna_id = $this->generate_uuid_v4();

        $data = [
            'pengguna_id' => $pengguna_id,
            'nik' => $nik,
            'nama' => $nama_lengkap,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $formatted_date,
            'jenis_kelamin' => $formatted_jk,
            'alamat' => $alamat_rumah,
            'telepon' => $no_hp,
            'email' => $alamat_email,
            'password' => $hashedPassword,
            'kode_wilayah' => trim($kode_wilayah),
        ];

        $simpan = $this->model_tppk->simpan_operator_satgas($data);

        if ($simpan) {
            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 100,
                'nama' => $nama_lengkap,
                'wilayah_akses' => trim($kode_wilayah),
                'sekolah_id' => "",
                'npsn_user' => "",
                'username' => $alamat_email,
                'peran' => 'pelapor',
                'ptk_id' => $pengguna_id,
                'asallogin' => 'op_satgas',
                'statustppk' => '',
                'sebagai' => '',
                'loginnik' => false,
            ];
            session()->set($params);
            return redirect()->to('/unggah_sk');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan data. Silakan hubungi admin.');
            return redirect()->back()->withInput();
        }
    }

    public function add_operator_satgas_password()
    {
        $request = \Config\Services::request();

        $nik = session()->get('ptk_id');
        $nama_lengkap = session()->get('nama');
        $tempat_lahir = "";
        $tanggal_lahir = substr(session()->get('ptk_id'), 6, 6);

        $tahun = intval(substr($tanggal_lahir, 4, 2));
        $bulan = substr($tanggal_lahir, 2, 2);
        $tanggal = substr($tanggal_lahir, 0, 2);

        if ($tanggal >= 40)
            $tanggal = $tanggal - 40;

        $tahun_4_digit = (intval($tahun) > date('y')) ? '19' . $tahun : '20' . $tahun;

        $formatted_date = "$tahun_4_digit-$bulan-$tanggal";

        $jenis_kelamin = "L";
        $jk = intval(substr($tanggal_lahir, 0, 2));
        if ($jk >= 40)
            $jenis_kelamin = "P";
        $alamat_rumah = "";
        $no_hp = session()->get('sekolah_id');
        $alamat_email = session()->get('username');
        $password = $request->getVar('password1');
        $hashedPassword = hash('sha256', $password);

        $kode_wilayah = session()->get('wilayah_akses');

        $pengguna_id = $this->generate_uuid_v4();

        $data = [
            'pengguna_id' => $pengguna_id,
            'nik' => $nik,
            'nama' => $nama_lengkap,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $formatted_date,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat_rumah,
            'telepon' => $no_hp,
            'email' => $alamat_email,
            'password' => $hashedPassword,
            'kode_wilayah' => $kode_wilayah,
        ];

        $simpan = $this->model_tppk->simpan_operator_satgas($data);


        if ($simpan) {
            session()->set('loginnik', false);
            session()->set('reset', false);
            $this->model_tppk->update_data_kode_reset($alamat_email, "-");
            return redirect()->to('/info_password');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan data. Silakan hubungi admin.');
            return redirect()->back()->withInput();
        }
    }

    public function info_password()
    {
        return view('info_password');
    }

    public function info_reset_password()
    {
        return view('info_reset_password');
    }

    public function cek_nik()
    {
        $request = \Config\Services::request();
        $nik = $request->getVar('nik');
        $exists = $this->model_tppk->nikExists($nik);

        return $this->response->setJSON(['exists' => $exists, 'csrf' => csrf_hash()]);
    }

    public function cek_email()
    {
        $request = \Config\Services::request();
        $email = $request->getVar('email');
        $exists = $this->model_tppk->emailExists($email);

        return $this->response->setJSON(['exists' => $exists, 'csrf' => csrf_hash()]);
    }

    public function sebagai($opsi = null, $wilayah = null)
    {
        $username = session()->get('username');
        if ($username == "hardianto@kemdikbud.go.id" || $username == "bintangakbar1219@gmail.com") {
            if ($opsi == "admin_satgas_provinsi") {
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 100,
                    'nama' => "Gatot kaca",
                    'wilayah_akses' => "880000",
                    'sekolah_id' => "",
                    'npsn_user' => "",
                    'username' => $username,
                    'peran' => "ketua",
                    'ptk_id' => "780C1E63-F280-44D4-8342-05192807D41F",
                    'asallogin' => 'op_satgas',
                    'statustppk' => 0,
                    'sebagai' => 'operatorsatgas',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else if ($opsi == "admin_satgas_kota") {
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 100,
                    'nama' => "Gareng",
                    'wilayah_akses' => "880100",
                    'sekolah_id' => "",
                    'npsn_user' => "",
                    'username' => $username,
                    'peran' => "anggota1",
                    'ptk_id' => "06E5202C-AD97-4BE6-B02C-5E4581684A64",
                    'asallogin' => 'op_satgas',
                    'statustppk' => 0,
                    'sebagai' => 'operatorsatgas',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else if ($opsi == "ketua_tppk") {
                $sekolah_id = '00E09B94-2BF5-E011-9894-31473205A536';
                $ptk_id = '66111A84-5B4D-11E5-94E2-A7F79F7D0280';
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 99,
                    'nama' => "Fajar M.",
                    'wilayah_akses' => '', //010101AB
                    'sekolah_id' => $sekolah_id,
                    'npsn_user' => '20104472',
                    'username' => $username,
                    'peran' => 'Koordinator',
                    'ptk_id' => $ptk_id,
                    'asallogin' => 'eksternal',
                    'statustppk' => 'ketua',
                    'tokenkey' => '',
                    'tokendapo' => '',
                    'sebagai' => 'sekolah',
                    'loginnik' => false,
                ];
                // cekstatuskeanggotaan($sekolah_id, $ptk_id);
                session()->set($params);
            } else if ($opsi == "anggota_tppk") {
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 99,
                    'nama' => "Meri",
                    'wilayah_akses' => '', //010101AB
                    'sekolah_id' => '00E09B94-2BF5-E011-9894-31473205A536',
                    'npsn_user' => '20104472',
                    'username' => $username,
                    'peran' => 'Guru Mapel',
                    'ptk_id' => 'D25DBF84-7822-E211-8A8B-7DB32FE8C53D',
                    'asallogin' => 'eksternal',
                    'statustppk' => 'anggota1',
                    'tokenkey' => '',
                    'tokendapo' => '',
                    'sebagai' => 'sekolah',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else if ($opsi == "dinas_prov") {
                if ($wilayah == null)
                    $wilayah = "250000";
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 2,
                    'nama' => 'Akun Dinprov',
                    'wilayah_akses' => $wilayah,
                    'sekolah_id' => '',
                    'npsn_user' => '',
                    'username' => $username,
                    'peran' => 'userverval',
                    'ptk_id' => '',
                    'asallogin' => 'internal',
                    'statustppk' => 'asing',
                    'sebagai' => 'dinasprovinsi',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else if ($opsi == "dinas_kota") {
                if ($wilayah == null)
                    $wilayah = "160100";
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 3,
                    'nama' => 'Akun Dinkot',
                    'wilayah_akses' => $wilayah,
                    'sekolah_id' => '',
                    'npsn_user' => '',
                    'username' => $username,
                    'peran' => 'userverval',
                    'ptk_id' => '',
                    'asallogin' => 'internal',
                    'statustppk' => 'asing',
                    'sebagai' => 'dinaskota',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else if ($opsi == "pusat") {
                $params = [
                    'loggedIn' => true,
                    'jenis_instansi_id' => 1,
                    'nama' => 'Akun Pusat',
                    'wilayah_akses' => '000000',
                    'sekolah_id' => '',
                    'npsn_user' => '',
                    'username' => $username,
                    'peran' => 'userverval',
                    'ptk_id' => '',
                    'asallogin' => 'internal',
                    'statustppk' => 'asing',
                    'sebagai' => 'pusat',
                    'loginnik' => false,
                ];
                session()->set($params);
            } else {
                echo "admin_satgas_provinsi, admin_satgas_kota, ketua_tppk, anggota_tppk, dinas_prov, dinas_kota, pusat";
                die();
            }

            return redirect()->to('/');
        }
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

        $sebagai = "";

        if ($asal == "internal") {
            $checkToken = $this->model_tppk->getTokenSSO($tokenKey);

            if ($checkToken->tokenStatus > 0) {
                $akun = $this->model_tppk->getAkunSSO($tokenKey);
                // echo "<pre>";
                // echo var_dump($akun);
                // echo "</pre>";
                // die();

                if ($akun->username == "" || $akun->username == null) {
                    return redirect()->to('/home');
                }

                $npsnuser = $akun->NPSN;
                if ($akun->jenis_instansi_id == 2 || $akun->jenis_instansi_id == 3)
                    $npsnuser = $akun->wilayah_akses;

                if ($akun->jenis_instansi_id == 1) {
                    $sebagai = "pusat";
                } else if ($akun->jenis_instansi_id == 2) {
                    $sebagai = "dinasprovinsi";
                } else if ($akun->jenis_instansi_id == 3) {
                    $sebagai = "dinaskota";
                }
                // else if ($akun->role_id == "C87CA49E-AD2E-4B2C-9BA2-9C7744EC5225") {
                //     $sebagai = "operatorsatgas";
                // }
                // echo var_dump($akun);
                // die();
                $user = $akun->pengguna_id;
                if ($user) {
                    $sekolah_id = $this->model_tppk->getSekolah($akun->NPSN);
                    $params = [
                        'loggedIn' => true,
                        'jenis_instansi_id' => $akun->jenis_instansi_id,
                        'nama' => str_replace("'", "_", $akun->nama),
                        'wilayah_akses' => $akun->wilayah_akses,
                        'sekolah_id' => $sekolah_id,
                        'npsn_user' => $npsnuser,
                        'username' => $akun->username,
                        'peran' => 'userverval',
                        'ptk_id' => '',
                        'asallogin' => 'internal',
                        'statustppk' => 'asing',
                        'sebagai' => $sebagai,
                        'loginnik' => false,
                    ];
                    session()->set($params);

                    $peran = '-';
                    $jabatan = 'operator';
                    $telp = '-';

                    $this->model_tppk->simpan_log_userlogin(1,  $peran, $jabatan, $telp);
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

            if ($data['username'] == "" || $data['username'] == null) {
                return redirect()->to('/home');
            }

            $sekolah_id = $data['sekolah_id'];
            $ptk_id = $data['ptk_id'];

            $npsn = $this->model_tppk->getNPSNSekolah($sekolah_id);

            $peran_dalam_tim = cekstatuskeanggotaan($sekolah_id, $ptk_id);

            $params = [
                'loggedIn' => true,
                'jenis_instansi_id' => 99,
                'nama' => str_replace("'", "_", $data['nama']),
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
                'sebagai' => 'sekolah',
                'loginnik' => false,
            ];
            session()->set($params);

            $peran = $data['peran'];
            $jabatan = $peran_dalam_tim;
            $getdata = $this->model_tppk->getdataptk($ptk_id);
            $telp = $getdata['no_kontak'];
            $this->model_tppk->simpan_log_userlogin(2, $peran, $jabatan, $telp);

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
                ($request->getVar('npsn')) ? session()->set('npsn_user', $request->getVar('npsn')) : "";
                ($request->getVar('wilayah')) ? session()->set('wilayah_akses', $request->getVar('wilayah')) : "";
                ($request->getVar('jenis_instansi')) ? session()->set('jenis_instansi_id', $request->getVar('jenis_instansi')) : "";
                // session()->set('npsn_user', $request->getVar('npsn') ?? null);
                // session()->set('ptk_id', $request->getVar('ptk_id') ?? null);
                // session()->set('wilayah_akses', $request->getVar('wilayah') ?? null);
                // session()->set('asallogin', $request->getVar('asallogin') ?? null);
                // session()->set('jenis_instansi_id', $request->getVar('jenis_instansi') ?? null);
                // session()->set('sekolah_id', $request->getVar('sekolah_id') ?? null);
                // session()->set('statustppk', $request->getVar('statustppk') ?? null);
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

    public function ceksebagai()
    {
        $username = session()->get('username');
        if ($username == "hardianto@kemdikbud.go.id") {
            // echo var_dump(session()->get());
        }
    }

    public function cronjob()
    {
        $kuotaterpakai = 0;
        $getkuota = $this->model_tppk->cekkuotaemail();
        $kuota = $getkuota->kuota;
        $limit_time = $getkuota->limit_time;
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        if ($now > $limit_time) {
            $kuota = 0;
            $this->model_tppk->resetkuotaemail();
        }
        if ($kuota < 500) {
            //// KIRIM SEMUA EMAIL PENDING SESUAI BATAS KUOTA DAN CEK APAKAH SUDAH ADA 
            $sisakuota = 500 - $kuota;
            $getdaftarantrian = $this->model_tppk->getPendingEmails($sisakuota);
            foreach ($getdaftarantrian as $email) {
                $kuotaterpakai++;
                $this->sendEmail($email['kode_pass'], $email['to_email']);
                echo "Mengirim email ke: " . $email['to_email'] . " dengan kode: " . $email['kode_pass'] . "\n";

                // Update status email menjadi 'sent'
                $this->model_tppk->update_antrian_email($email['to_email'], 1, 0);
            }
            $kuotaberjalan = $kuota + $kuotaterpakai;
            $this->model_tppk->updatekuotaemail($kuotaberjalan);
        }
        // if ($kuotaterpakai == 0) {
        //     echo "Tidak ada antrian email";
        // }
    }
}
