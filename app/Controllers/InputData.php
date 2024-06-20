<?php

namespace App\Controllers;

use App\Models\M_tppk;
use PHPExcel;
use Xlsx;
use PHPExcel_IOFactory;
use ZipArchive;

class InputData extends BaseController
{

    function __construct()
    {
        $this->model_tppk = new M_tppk();
    }

    public function index()
    {
        $userlogin = session()->get('loggedIn');
        if (!$userlogin) {
            return redirect()->to('/home');
        } else {
            $instansiid = session()->get('jenis_instansi_id');
            $sebagai = session()->get('sebagai');
            $npsn = session()->get('npsn_user');
            $kodewilayah = session()->get('wilayah_akses');
            $username = session()->get('username');


            if ($instansiid == 2) {
                session()->set('sebagai', 'dinasprovinsi');
                return $this->satgasprov();
            } else if ($instansiid == 4) {
                session()->set('sebagai', 'bpmp');
                return $this->satgasprov();
            } else if ($instansiid == 18) {
                session()->set('sebagai', 'bppmpv');
                return $this->satgasprov();
            } else if ($instansiid == 3) {
                session()->set('sebagai', 'dinaskota');
                return $this->satgaskota();
            } else if ($instansiid == 5) {
                session()->set('sebagai', 'operatorsekolah');
                return $this->npsn($npsn);
            } else {
                echo "Belum terdaftar .... Hubungi admin!";
            }
        }
    }

    public function edit()
    {
        $instansiid = session()->get('jenis_instansi_id');
        $sebagai = session()->get('sebagai');
        $npsn = session()->get('npsn_user');
        $kodewilayah = session()->get('wilayah_akses');
        $username = session()->get('username');

        if ($instansiid == 2) {
            session()->set('sebagai', 'dinasprovinsi');
            return $this->satgasprov('edit');
        } else if ($instansiid == 4) {
            session()->set('sebagai', 'bpmp');
            return $this->satgasprov('view');
        } else if ($instansiid == 18) {
            session()->set('sebagai', 'bppmpv');
            return $this->satgasprov('view');
        } else if ($instansiid == 3) {
            session()->set('sebagai', 'dinaskota');
            return $this->satgaskota('edit');
        } else if ($instansiid == 5) {
            session()->set('sebagai', 'operatorsekolah');
            return $this->npsn($npsn);
        } else {
            echo "Belum terdaftar .... Hubungi admin!";
        }
    }

    public function ubahfile()
    {
        $instansiid = session()->get('jenis_instansi_id');
        $sebagai = session()->get('sebagai');
        $npsn = session()->get('npsn_user');
        $kodewilayah = session()->get('wilayah_akses');
        $username = session()->get('username');

        if ($instansiid == 2) {
            session()->set('sebagai', 'dinasprovinsi');
            return $this->satgasprov('ubahfile');
        } else if ($instansiid == 3) {
            session()->set('sebagai', 'dinaskota');
            return $this->satgaskota('ubahfile');
        } else {
            echo "Belum terdaftar .... Hubungi admin!";
        }
    }

    public function skbaru()
    {
        $instansiid = session()->get('jenis_instansi_id');
        $sebagai = session()->get('sebagai');
        $npsn = session()->get('npsn_user');
        $kodewilayah = session()->get('wilayah_akses');
        $username = session()->get('username');

        if ($instansiid == 2) {
            session()->set('sebagai', 'dinasprovinsi');
            return $this->satgasprov('skbaru');
        } else if ($instansiid == 3) {
            session()->set('sebagai', 'dinaskota');
            return $this->satgaskota('skbaru');
        } else {
            echo "Belum terdaftar .... Hubungi admin!";
        }
    }

    public function tppk($mstWilayah = '000000', $level = 1)
    {
        $sebagai = session()->get('sebagai');
        $instansiid = session()->get('jenis_instansi_id');
        if (trim($sebagai) != "os" && $instansiid != "1") {
            return redirect()->to('/home');
        }

        // $validation = session('validation');

        // if (empty($validation)) {
        //     $validation = [];
        // }

        $data = array();
        $data['namaPropinsi'] = $this->model_tppk->getNamaWilayah($mstWilayah, $level);
        // $data['validation'] = $validation;
        // dd($data['namaWilayah']);
        return view('inputtppk', $data);
    }

    public function satgasprov($opsi = null)
    {
        $sebagai = session()->get('sebagai');
        if (trim($sebagai) != "dp" && $sebagai != "dinasprovinsi") {
            return redirect()->to('/home');
        }

        session()->set('pilihan', 1);
        $data = array();

        $fileada = false;
        $nomor_sk = "";
        $tanggal_sk = date("d-m-Y");
        $namafileskok = "";
        $skid = "";
        $adasatgas = 0;

        $ceksk = $this->model_tppk->getSKProv(session()->get('wilayah_akses'));

        if ($ceksk) {
            $nomor_sk = $ceksk['nomor_sk'];
            $tanggal_sk = $ceksk['tanggal_sk'];
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $nomor_sk);
            $namafiletanpaekstensi = "sk_" . trim(session()->get('wilayah_akses')) . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk) {
                $fileada = true;
                $namafileskok = $namafilesk['filename'];
            }


            $adasatgas = 0;
            $skid = $ceksk['sk_id'];
            $dafanggota = $this->model_tppk->getAnggotaProv($skid);
            $data['anggotasatgas'] = $dafanggota;

            if ($dafanggota) {
                $adasatgas = 1;
            }
        }

        $data['nomor_sk'] = $nomor_sk;
        $data['tanggal_sk'] = $tanggal_sk;
        $data['nama_file'] = $namafileskok;

        $data['skid'] = $skid;

        if ($opsi == "edit" && $adasatgas == 0)
            return redirect()->to('/inputdata');

        if ($opsi != "edit" && $adasatgas)
            return redirect()->to('/tppk/anggota2/' . substr(session()->get('wilayah_akses'), 0, 2) . '0000');

        $data['namaPropinsi'] = $this->model_tppk->getNamaWilayah('000000', 1);
        $kodeprovsaya = substr(session()->get('wilayah_akses'), 0, 2) . '0000';

        $data['wilayahsaya'] = $kodeprovsaya;
        $data['sebagai'] = session()->get('sebagai');
        $data['opsi'] = $opsi;

        /////////// BYPASSSS TIDAK PERLU FILE UNGGAH DULU////////////////
        $data['opsi'] = "add";
        if ($ceksk) {
            $data['opsi'] = "edit";
        }
        return view('inputsatgasprovnofile', $data);
        ////////////////////////////////////////////////////////////////

        if ($fileada) {
            $data['opsi'] = "edit";
            return view('inputsatgasprov', $data);
        } else {
            if ($adasatgas == 1)
                $data['opsi'] = "ubahfile";
            else
                $data['opsi'] = "skbaru";
            return view('inputsatgasprov_file', $data);
        }

        // $datask = $this->model_tppk->getSKProv($kodeprovsaya);
        // if ($datask) {
        //     $data['datask'] = $datask;
        //     $skid = $datask['sk_id'];
        //     $data['skid'] = $skid;
        //     $data['anggotasatgas'] = $this->model_tppk->getAnggotaProv($skid);
        // }

        // if ($opsi == null) {
        //     $ceksatgaskota = $this->model_tppk->getSKProv(session()->get('wilayah_akses'));
        //     if ($ceksatgaskota) {
        //         return redirect()->to('/tppk/anggota2/' . substr(session()->get('wilayah_akses'), 0, 2) . '0000');
        //     }
        // }

        return view('inputsatgasprov', $data);
    }

    public function satgaskota($opsi = null)
    {
        $sebagai = session()->get('sebagai');
        if (trim($sebagai) != "dk" && $sebagai != "dinaskota") {
            return redirect()->to('/home');
        }

        session()->set('pilihan', 2);
        $data = array();

        $fileada = false;
        $nomor_sk = "";
        $tanggal_sk = date("d-m-Y");
        $namafileskok = "";
        $skid = "";
        $adasatgas = 0;

        $ceksk = $this->model_tppk->getSKProv(session()->get('wilayah_akses'));

        if ($ceksk) {
            $nomor_sk = $ceksk['nomor_sk'];
            $tanggal_sk = $ceksk['tanggal_sk'];
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $nomor_sk);
            $namafiletanpaekstensi = "sk_" . trim(session()->get('wilayah_akses')) . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "") {
                $fileada = true;
                $namafileskok = $namafilesk['filename'];
            }


            $adasatgas = 0;
            $skid = $ceksk['sk_id'];
            $dafanggota = $this->model_tppk->getAnggotaProv($skid);
            $data['anggotasatgas'] = $dafanggota;

            if ($dafanggota) {
                $adasatgas = 1;
            }
        }

        $data['nomor_sk'] = $nomor_sk;
        $data['tanggal_sk'] = $tanggal_sk;
        $data['nama_file'] = $namafileskok;

        $data['skid'] = $skid;

        if ($opsi == "edit" && $adasatgas == 0)
            return redirect()->to('/inputdata');

        if ($opsi != "edit" && $adasatgas)
            return redirect()->to('/tppk/anggota2/' . substr(session()->get('wilayah_akses'), 0, 4) . '00');

        $data['namaPropinsi'] = $this->model_tppk->getNamaWilayah('000000', 1);
        $kodeprovsaya = substr(session()->get('wilayah_akses'), 0, 2) . '0000';
        $kodekotasaya = substr(session()->get('wilayah_akses'), 0, 4) . '00';

        if ($sebagai == "dinaskota") {
            $data['namaKota'] = $this->model_tppk->getNamaWilayah($kodeprovsaya, 2);
        }
        // echo $kodekotasaya;
        // die();
        $data['wilayahsaya'] = $kodeprovsaya;
        $data['wilayahkotasaya'] = $kodekotasaya;
        $data['sebagai'] = session()->get('sebagai');
        $data['opsi'] = $opsi;


        /////////// BYPASSSS TIDAK PERLU FILE UNGGAH DULU////////////////
        $data['opsi'] = "add";
        if ($ceksk) {
            $data['opsi'] = "edit";
        }
        return view('inputsatgaskabkotnofile', $data);
        ////////////////////////////////////////////////////////////////

        if ($fileada) {
            $data['opsi'] = "edit";
            return view('inputsatgaskabkot', $data);
        } else {
            if ($adasatgas == 1)
                $data['opsi'] = "ubahfile";
            else
                $data['opsi'] = "skbaru";
            return view('inputsatgaskabkot_file', $data);
        }
    }

    public function getNamaWilayah()
    {
        $request = \Config\Services::request();
        $mstWilayah = $request->getVar('kode');
        $level = $request->getVar('level');
        $hasil = $this->model_tppk->getNamaWilayah($mstWilayah, $level);
        echo json_encode($hasil);
    }

    public function getNamaInstansi($jenisinstansi)
    {
        $request = \Config\Services::request();
        $kodewilayah = $request->getVar('kode');
        $hasil = $this->model_tppk->getNamaSekolah($kodewilayah);
        echo json_encode($hasil);
    }

    public function getNPSN()
    {
        $request = \Config\Services::request();
        $kodeinstansi = $request->getVar('kode');
        $hasil = $this->model_tppk->getNPSN($kodeinstansi);
        echo json_encode($hasil->kode_instansi);
    }

    public function getPTK()
    {
        $request = \Config\Services::request();
        $kodeinstansi = $request->getVar('kode');
        $hasil = $this->model_tppk->getPTK($kodeinstansi);
        echo json_encode($hasil);
    }

    public function getAuto()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();
        // $response['token'] = csrf_hash();

        $data = array();

        if (isset($postData['search'])) {
            $search = $postData['search'];
            $kodepropinsi = $postData['kodepropinsi'];
            $kodekota = $postData['kodekota'];
            $kodekecamatan = $postData['kodekecamatan'];

            $result = $this->model_tppk->search_sekolah($search, $kodepropinsi, $kodekota, $kodekecamatan);

            $data = array();

            foreach ($result as $row) {
                $data[] = array(
                    "value" => $row->kode_wilayah,
                    "label" => $row->nama,
                    "npsn" => $row->kode_instansi,
                    "sekolahid" => $row->instansi_id,
                );
            }
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function getAutoPTK()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();
        // $response['token'] = csrf_hash();

        $data = array();

        if (isset($postData['search'])) {
            $search = $postData['search'];
            $sekolah_id = $postData['sekolah_id'];

            $result = $this->model_tppk->search_ptk($search, $sekolah_id);

            $data = array();

            foreach ($result as $row) {
                $data[] = array(
                    "label" => $row->nama,
                    "ptk_id" => $row->ptk_id
                );
            }
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    private function generateRandomString($length = 3)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function simpan()
    {
        echo "HUBUNGI ADMIN";
        die();
        // $request = service('request');
        $request = \Config\Services::request();
        $postData = $request->getPost();
        $jmlpetugas = $request->getPost('jmlpengguna');
        $filesk = $request->getFile('file_sk');
        $namafile = $filesk->getName();

        // if ($filesk->isValid()) {
        //     $namaFile = $filesk->getName(); // Mendapatkan nama file
        //     $ukuranFile = $filesk->getSize(); // Mendapatkan ukuran file
        //     $tipeFile = $filesk->getMimeType(); // Mendapatkan tipe MIME file
        // } else {
        //     echo $filesk->getError(); // Mendapatkan pesan kesalahan
        // }
        return redirect()->to('/tppk/wilayah');
        die();

        $ext = $filesk->getClientExtension();

        $namafilebaru = "sk_" . $this->request->getPost('iinstansi') . "_" . $this->generateRandomString() . "." . $ext;

        $filesk->move(ROOTPATH . '/uploads', $namafilebaru);

        $data = [];

        $tgl = $request->getPost('tanggal_sk');
        $tanggal = substr($tgl, 0, 2);
        $bulan = substr($tgl, 3, 2);
        $tahun = substr($tgl, 6, 4);
        $tanggalbaru = date($bulan . "/" . $tanggal . "/" . $tahun);

        $dataptkid = [];

        $rowdata =  [
            'instansi_pengguna_id' => $this->guidv4(),
            'jabatan_id' => $request->getPost('ijabatan'),
            'pengguna_id' => $request->getPost('inamaketua'),
            'instansi_id' => $request->getPost('iinstansi'),
            'penugasan' => '1',
            'sk' => $namafile,
            'tanggal_sk' => $tanggalbaru
        ];
        $data[] = $rowdata;
        $dataptkid[] = $request->getPost('inamaketua');

        for ($a = 1; $a < $jmlpetugas; $a++) {
            $rowdata =  [
                'instansi_pengguna_id' => $this->guidv4(),
                'jabatan_id' => $request->getPost('ijabatan' . $a),
                'pengguna_id' => $request->getPost('inamaanggota' . $a),
                'instansi_id' => $request->getPost('iinstansi'),
                'penugasan' => '2',
                'sk' => $namafile,
                'tanggal_sk' => $tanggalbaru
            ];
            $data[] = $rowdata;
            $dataptkid[] = $request->getPost('inamaanggota' . $a);
        }

        // echo $request->getPost('iinstansi');
        // echo "<pre>";
        // echo var_dump($dataptkid);
        // echo "</pre>";

        // die();
        $this->model_tppk->insert_batch($data);
        $this->model_tppk->insert_pengguna($dataptkid);
        // die();

        return redirect()->to('/tppk/wilayah');
    }

    public function simpansatgastes()
    {
        $request = \Config\Services::request();
        $jmlpetugas = $request->getPost('jmlpengguna');
        $addedit = $request->getPost('addedit');
        $skid = $request->getPost('skid');
        $level_wilayah = $request->getVar('id_level_wilayah');
        if ($level_wilayah == 1)
            $kodeprov = $request->getVar('ipropinsion');
        else if ($level_wilayah == 2)
            $kodeprov = $request->getVar('ikotaon');

        return redirect()->to('/tppk/anggota2/' . $kodeprov);
    }

    public function simpansatgas()
    {
        $request = \Config\Services::request();
        $jmlpetugas = $request->getVar('jmlpengguna');
        $addedit = $request->getVar('addedit');
        $skid = $request->getVar('skid');

        $namasaya = session()->get('nama');

        $level_wilayah = $request->getVar('id_level_wilayah');
        if ($level_wilayah == 1)
            $kodeprov = $request->getVar('ipropinsion');
        else if ($level_wilayah == 2)
            $kodeprov = $request->getVar('ikotaon');

        $uuid = $this->generate_uuid_v4();

        //////////////SEMENTARA SIMPAN SK TANPA FILE /////////////////////
        $tglsk = $request->getVar('tanggal_sk');
        $nmrsk = $request->getVar('nomor_sk');
        $skid = $request->getVar('skid');

        $namasaya = session()->get('nama');

        $tanggalsk = substr($tglsk, 6, 4) . "-" . substr($tglsk, 3, 2) . "-" . substr($tglsk, 0, 2);

        $level_wilayah = $request->getVar('id_level_wilayah');
        if ($level_wilayah == 1)
            $kodeprov = $request->getVar('ipropinsion');
        else if ($level_wilayah == 2)
            $kodeprov = $request->getVar('ikotaon');

        if ($addedit == "add") {
            $datask = array('sk_id' => $uuid, 'kode_wilayah' => $kodeprov, 'id_level_wilayah' => $level_wilayah, 'nomor_sk' => $nmrsk, 'tanggal_sk' => $tanggalsk, 'nama_operator' => $namasaya);
            $this->model_tppk->insert_sk_baru($datask);
        } else {
            $datask = array('nomor_sk' => $nmrsk, 'tanggal_sk' => $tanggalsk, 'nama_operator' => $namasaya);
            $this->model_tppk->update_sk($datask, $skid);
        }

        //////////////////////////////////

        if ($jmlpetugas > 0) {

            $this->model_tppk->hapus_satgas_lama($skid);

            for ($a = 1; $a <= $jmlpetugas; $a++) {
                $ke = $a - 1;

                $uuidn = $this->generate_uuid_v4();
                if ($addedit == "edit") {
                    $uuid = $skid;
                }
                $tglhr = $request->getVar('itglahir' . $ke);
                $tgllahirnya = substr($tglhr, 6, 4) . "-" . substr($tglhr, 3, 2) . "-" . substr($tglhr, 0, 2);

                $datan =  array(
                    'satgas_id' => $uuidn, 'sk_id' => $uuid, 'jenis_instansi_id' => $request->getVar('idinas' . $ke),
                    'nama' => $request->getVar('inama' . $ke), 'nik' => $request->getVar('inik' . $ke), 'sex' => $request->getVar('isex' . $ke), 'telepon' => $request->getVar('ihp' . $ke), 'email' => $request->getVar('iemail' . $ke), 'tanggal_lahir' => $tgllahirnya, 'status_dukcapil' => $request->getVar('istatusdukcapil' . $ke), 'anggotake' => $ke
                );

                $this->model_tppk->insert_satgas_baru($datan);
            }
            $this->model_tppk->updaterekapwilayah($level_wilayah, $kodeprov, 1);
            $this->model_tppk->update_jumlah_satgas($kodeprov, $jmlpetugas);
            if ($skid != "")
                $this->model_tppk->setsksesuai($skid, 0, "");
        }

        return redirect()->to('/tppk/anggota2/' . $kodeprov);
    }

    public function simpanfilesatgas()
    {
        $request = \Config\Services::request();
        $postData = $request->getPost();
        $addedit = $request->getPost('addedit');
        $tglsk = $request->getPost('tanggal_sk');
        $nmrsk = $request->getPost('nomor_sk');
        $filesk = $request->getFile('file_sk');
        $skid = $request->getPost('skid');
        $namafile = $filesk->getName();

        $namasaya = session()->get('nama');

        $tanggalsk = substr($tglsk, 6, 4) . "-" . substr($tglsk, 3, 2) . "-" . substr($tglsk, 0, 2);

        $level_wilayah = $request->getPost('id_level_wilayah');
        if ($level_wilayah == 1)
            $kodeprov = $request->getPost('ipropinsion');
        else if ($level_wilayah == 2)
            $kodeprov = $request->getPost('ikotaon');

        $uuid = $this->generate_uuid_v4();
        if ($addedit == "skbaru") {
            $datask = array('sk_id' => $uuid, 'kode_wilayah' => $kodeprov, 'id_level_wilayah' => $level_wilayah, 'nomor_sk' => $nmrsk, 'tanggal_sk' => $tanggalsk, 'nama_operator' => $namasaya);
            $this->model_tppk->insert_sk_baru($datask);
        } else {
            $datask = array('nomor_sk' => $nmrsk, 'tanggal_sk' => $tanggalsk, 'nama_operator' => $namasaya);
            $this->model_tppk->update_sk($datask, $skid);
        }

        $filesk = $request->getFile('file_sk');

        if ($filesk->isValid()) {
            $namaFile = $filesk->getName();
            $ukuranFile = $filesk->getSize();
            $tipeFile = $filesk->getMimeType();
            $ext = $filesk->getClientExtension();

            if ($ukuranFile > 2000 * 1024 || $ext !== 'pdf') {
                return redirect()->back()->with('error', 'Gagal unggah file. File harus berukuran kurang dari 2 MB dan berformat PDF.');
            }

            $namafileoke = preg_replace("/[^a-zA-Z0-9]/", "", $nmrsk);
            $namafilebaru = "sk_" . trim($kodeprov) . "_" . $namafileoke . "." . $ext;
            if (strlen($kodeprov) >= 6) {
                $files = glob('public/uploads/sk_' . trim($kodeprov) . '*.*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        // unlink($file);
                    }
                }
            }
            $filesk->move('public/uploads/', $namafilebaru);
        } else {
            echo $filesk->getError();
        }

        return redirect()->to('/inputdata');
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

    // Contoh pemanggilan fungsi untuk menghasilkan UUID v4

    public function upload_sk()
    {
        $request = \Config\Services::request();
        $npsn = $request->getPost('npsn');
        $sktugas = $request->getPost('sk_tugas');
        $tanggalsk = $request->getPost('tanggal_sk');
        $filesk = $request->getFile('file_sk');
        $namasaya = session()->get('nama');

        $tipeoke = false;
        $tipeFile = $filesk->getMimeType();
        $allowedMimeTypes = ['application/pdf'];
        if (in_array($tipeFile, $allowedMimeTypes)) {
            $tipeoke = true;
        }

        if ($filesk->isValid() && $tipeoke == true) {

            $namaFile = $filesk->getName();
            $ukuranFile = $filesk->getSize();
            $tipeFile = $filesk->getMimeType();
            $ext = $filesk->getClientExtension();

            if ($ukuranFile > 750 * 1024 || $ext !== 'pdf') {
                return redirect()->back()->with('error', 'Gagal unggah file. File harus berukuran kurang dari 750 KB dan berformat PDF.');
            }

            $namafileoke = preg_replace("/[^a-zA-Z0-9]/", "", $sktugas);
            $namafilebaru = "sk_" . $npsn . "_" . $namafileoke . "." . $ext;

            // $lokasiFile = WRITEPATH . 'uploads/' . $namafilebaru;
            $lokasiFile = 'public/uploads/' . $namafilebaru;
            if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                $lokasiFile = 'public/uploads2/' . $namafilebaru;
            }

            // Cek apakah file dengan nama yang sama sudah ada
            if (strlen($npsn) >= 6) {
                if (is_file($lokasiFile)) {
                    // Jika ada, hapus file lama
                    //unlink($lokasiFile);
                }
            }

            $files = glob('public/uploads/' . 'sk_' . $npsn . '_*');

            foreach ($files as $file) {
                //unlink($file);
            }

            if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                $filesk->move('public/uploads2/', $namafilebaru);
            } else {
                $filesk->move('public/uploads/', $namafilebaru);
            }

            $getSKSekolah = $this->model_tppk->getSKSekolah($npsn);
            $getsekolah = $this->model_tppk->getSekolah($npsn)->getRowArray();
            $sekolah_id = $getsekolah['instansi_id'];
            if (!$getSKSekolah) {
                $tanggalsknya = substr($tanggalsk, 8, 2) . "-" . substr($tanggalsk, 5, 2) . "-" . substr($tanggalsk, 0, 4);
                $nomorsk = str_replace("'", "`", $sktugas);
                $nomorsk = str_replace('"', '`', $nomorsk);
                $datask = array('sekolah_id' => $sekolah_id, 'npsn' => $npsn, 'nomor_sk' => $nomorsk, 'tanggal_sk' => $tanggalsknya, 'nama_operator' => $namasaya);
                // if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                //     echo $tanggalsk . "<br>";
                //     echo $sekolah_id . "<br>";
                //     echo var_dump($datask);
                //     die();
                // }
                $this->model_tppk->insert_sk_tppk_baru($datask);
            } else {
                $skid = $getSKSekolah['sk_id'];
                $datask = array('nama_operator' => $namasaya);
                // if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                //     echo var_dump($datask);
                //     die();
                // }
                $this->model_tppk->update_sk_tppk($datask, $skid);
            }
            ///////////////////////////////////////////////
            $tanggalsknya = substr($tanggalsk, 8, 2) . "-" . substr($tanggalsk, 5, 2) . "-" . substr($tanggalsk, 0, 4);
            $data = array();
            $data['sekolah_id'] = $sekolah_id;
            $data['npsn'] = $npsn;
            $nomorsk = str_replace("'", "`", $sktugas);
            $nomorsk = str_replace('"', '`', $nomorsk);
            $data['nomor_sk'] = $nomorsk;
            $data['status_sk'] = 1;
            $data['tanggal_sk'] = $tanggalsk;
            // if (session()->get('username') == "hardianto@kemdikbud.go.id") {
            //     echo var_dump($data);
            //     die();
            // }
            $this->model_tppk->input_data_sk($data);
            $this->clear_residu_upload_sk($npsn);


            //////////////////////////////////////////////
        } else {
            echo $filesk->getError();
            if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                echo "Eror file sk";
                die();
            }
        }
        return redirect()->to('/tppk/anggota/' . $npsn);
    }

    function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return strtoupper(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public function getDataAnggota($npsn)
    {
        $query1 = $this->model_tppk->getSekolah($npsn);
        $hasil = $query1->getRowArray();
        $idinstansi = $hasil['instansi_id'];
        $query2 = $this->model_tppk->getDaftarAnggota($idinstansi);
        $data['daftaranggota'] = $query2->getResultArray();
    }

    public function npsn($npsn)
    {
        session()->set('pilihan', 1);
        if ($npsn == "99999999") {
            die();
        }

        $query1 = $this->model_tppk->getSekolah($npsn);
        $hasil = $query1->getRowArray();

        $data['namasekolah'] = $hasil;

        $idinstansi = $hasil['instansi_id'];
        $daftarNamaWilayah = $this->model_tppk->getDataWilayah($hasil['kode_wilayah']);
        $NamaWilayah = $daftarNamaWilayah->getResult();

        $jmlPTK = $this->model_tppk->getPTKRes($npsn);
        if (!$jmlPTK) {
            echo "Data tidak ditemukan";
            die();
        } else {
            $data['jumlah_ptk'] = $jmlPTK['total'];
        }
        $data['kepalasekolah'] = "-";

        $daftarPTK = $this->model_tppk->getPTK($idinstansi);
        foreach ($daftarPTK as $row) {
            if ($row->jenis_ptk_id == 20) {
                $data['kepalasekolah'] = $row->nama;
                break;
            }
        }

        $data['provinsi'] = $NamaWilayah[0]->propinsi;
        $data['kota'] = $NamaWilayah[0]->kota;
        $data['kecamatan'] = $NamaWilayah[0]->kecamatan;

        $daftarPD = $this->model_tppk->getPDRes($npsn);
        $data['jumlah_pd'] = $daftarPD['total_pd'];

        //$idinstansi = '00A490FB-30F5-E011-A488-CDC073892C5F';
        $query2 = $this->model_tppk->getDaftarAnggota($idinstansi);
        $dafanggota = $query2->getResultArray();
        $data['daftaranggota'] = $dafanggota;
        $queryop2 = $this->model_tppk->getOperator($idinstansi);
        $data['operator'] = $queryop2;
        $data['instansiid'] = $idinstansi;
        $data['sk_tugas'] = "-";
        $data['tgl_sk'] = "-";
        $data['tanggalberakhir'] = "-";
        $data['sudah_upload'] = false;
        $data['kadaluwarsa'] = true;

        ////////////////////cek file sk
        $linknomorsk = "-";
        if ($dafanggota) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['sk_tugas']);
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "" && $dafanggota) {
                $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $dafanggota[0]['sk_tugas'] . ' <span style="font-weight:bold; font-style:italic">[unduh]</span></a>';
                $data['sudah_upload'] = true;
            } else {
                if ($dafanggota > 1)
                    $linknomorsk = $dafanggota[0]['sk_tugas'];
                else {
                    $linknomorsk = "-";
                }
            }
            $data['sk_tugas'] = $dafanggota[0]['sk_tugas'];
            $data['tgl_sk'] = $dafanggota[0]['tmt_sk_tugas'];
            $data['tanggalberakhir'] = date('Y-m-d', strtotime($data['tgl_sk'] . ' +2 years'));

            if ($data['tanggalberakhir'] > date('Y-m-d')) {
                $data['kadaluwarsa'] = false;
            }
        }
        $data['linknomorsk'] = $linknomorsk;
        $data['daftar_residu'] = $this->model_tppk->getResiduSekolah($npsn);

        $username = session()->get('username');
        if ($data['sudah_upload'] == true && $data['daftar_residu']['residu_upload_sk'] == 1) {
            $this->clear_residu_upload_sk($npsn);
        }

        return view('tppk/input_sk', $data);
    }

    public function cek_sk_gagal_upload()
    {
        $getdaftarsk_satgas = $this->model_tppk->getAllSKSatgas();
        $nomor = 0;
        foreach ($getdaftarsk_satgas as $data) {
            $kode_wilayah = $data['kode_wilayah'];
            $sktugas = $data['nomor_sk'];
            $nama_wilayah = $data['nama'];
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $sktugas);
            $namafiletanpaekstensi = "sk_" . $kode_wilayah . "_" . $fileabjad;
            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);
            if ($namafilesk == "") {
                $nomor++;
                echo "SK KodeWilayah $kode_wilayah ($nama_wilayah) gagal upload!<br>";
            }
        }
    }

    private function cekfilesk($namafiletanpaekstensi)
    {
        $folders = [
            './public/uploads/',
            './public/uploads/var/www/html/tppk/public/uploads/'
        ];

        $fileName = $namafiletanpaekstensi;
        $extensions = ['jpg', 'jpeg', 'png', 'pdf'];

        foreach ($folders as $folderPath) {
            foreach ($extensions as $extension) {
                $filePath = $folderPath . $fileName . '.' . $extension;
                if (file_exists($filePath)) {
                    // Mengembalikan jalur lengkap ke file
                    return [
                        'filename' => $fileName,
                        'path' => $filePath,
                        'relativePath' => str_replace('./public/', '', $filePath)
                    ];
                }
            }
        }

        return false;
    }


    private function cekfilesk_old($namafiletanpaekstensi)
    {
        // $folderPath = WRITEPATH . 'uploads/';
        $folderPath = './public/uploads/';
        $fileName = $namafiletanpaekstensi;

        // echo $folderPath; //

        $extensions = ['jpg', 'jpeg', 'png', 'pdf'];

        $found = false;
        $ekstensi = "";
        foreach ($extensions as $extension) {
            $filePath = $folderPath . $fileName . '.' . $extension;
            if (file_exists($filePath)) {
                $found = true;
                $ekstensi = $extension;
                break;
            }
        }

        if ($found) {
            $namafile = $fileName . "." . $ekstensi;
        } else {
            $namafile = "";
        }
        return $namafile;
    }

    public function download_sk($namafile)
    {
        // $folderPath = WRITEPATH . 'uploads/';
        $folderPath = 'public/uploads/';
        $filePath = $folderPath . $namafile;
        return $this->response->download($filePath, null);
    }

    public function download_sk_new($nama_file)
    {
        $data['file_path'] = WRITEPATH . 'uploads/nama_file.pdf';
        return view('pdf_viewer', $data);
    }

    public function download_panduan()
    {
        $namafile = "panduan_tppk.pdf";
        $folderPath = WRITEPATH . 'uploads/';
        $filePath = $folderPath . $namafile;
        return $this->response->download($filePath, null);
    }

    private function padankandatakasus($nik, $nama, $tglahir, $sex)
    {

        $request = \Config\Services::request();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => '172.16.101.25/api/dukcapil',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => 'nik=' . $nik . '&nama=' . $nama . '&tempat_lahir=pass&tanggal_lahir=' . $tglahir . '&jenis_kelamin=' . $sex . '&nama_ibu_kandung=pass&threshold=85',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private function padankandatakasusmasy($nik, $nama, $sex)
    {

        $request = \Config\Services::request();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => '172.16.101.25/api/dukcapil',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => 'nik=' . $nik . '&nama=' . $nama . '&tempat_lahir=pass&tanggal_lahir=18-01-1978&jenis_kelamin=' . $sex . '&nama_ibu_kandung=pass&threshold=85',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function padankandata()
    {

        $request = \Config\Services::request();
        $nik = $request->getVar('nik');
        $nama = $request->getVar('nama');
        $tptlahir = $request->getVar('tptahir');
        $tglahir = $request->getVar('tglahir');
        $sex = $request->getVar('sex');

        if (!isset($tptlahir))
            $tptlahir = "pass";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => '172.16.101.25/api/dukcapil',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => 'nik=' . $nik . '&nama=' . $nama . '&tempat_lahir=' . $tptlahir . '&tanggal_lahir=' . $tglahir . '&jenis_kelamin=' . $sex . '&nama_ibu_kandung=pass&threshold=85',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // echo json_encode($response);
        $responseData = json_decode($response, true);

        // Add CSRF token to the response array
        $csrfToken = csrf_hash();
        $responseData['csrf'] = $csrfToken;

        // Encode the modified array back to JSON
        echo json_encode($responseData);
    }

    public function daftar_skbaru($kodeprov = null)
    {
        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid == 1) {
            $daftar_sksatgas_baru = $this->model_tppk->getDaftarSKSatgasBaru($kodeprov);
            // echo var_dump($daftar_sksatgas_baru);
            // die();
            if ($daftar_sksatgas_baru) {
                $data['daftar_sksatgas'] = $daftar_sksatgas_baru;
                $data['kode'] = $kodeprov;
                if ($kodeprov == null)
                    return view('tppk/daftar_sk_satgas', $data);
                else if ($kodeprov == "kota")
                    return view('tppk/daftar_sk_satgas2', $data);
                else if ($kodeprov == "op_prov")
                    return view('tppk/daftar_skop_satgas', $data);
                else if ($kodeprov == "op_kota")
                    return view('tppk/daftar_skop_satgas2', $data);
            } else {
                return view('tppk/daftar_sk_kosong');
            }
        } else if ($instansiid == 3) {
            $kodekota = session()->get('wilayah_akses');
            $daftar_sktppk = $this->model_tppk->getDaftarSKKab($kodekota);
            if ($daftar_sktppk) {
                $data['daftar_sktppk'] = $daftar_sktppk;
                return view('tppk/daftar_sk_tppk', $data);
            } else {
                return view('tppk/daftar_sk_kosong');
            }
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $kodeprovinsi = session()->get('wilayah_akses');
            $daftar_sktppk = $this->model_tppk->getDaftarSKProv($kodeprovinsi);
            if ($daftar_sktppk) {
                $data['daftar_sktppk'] = $daftar_sktppk;
                return view('tppk/daftar_sk_tppk', $data);
            } else {
                return view('tppk/daftar_sk_kosong');
            }
        }
    }

    public function statistik_user()
    {
        $request = \Config\Services::request();
        $vartanggal = $request->getVar('tanggal');
        $varprovinsi = $request->getVar('provinsi');
        $varkota = $request->getVar('kota');
        $varasal = $request->getVar('asal');
        $asal = (isset($varasal) && $varasal != "") ? $varasal : 1;
        $tanggal = (isset($vartanggal)) ? $vartanggal : "";
        $provinsi = (isset($varprovinsi)) ? $varprovinsi : "";
        $kota = (isset($varkota)) ? $varkota : "";

        $wilayah = "";
        if ($provinsi != "")
            $wilayah = $provinsi;
        if ($kota != "")
            $wilayah = $kota;

        $tanggalmodel = $tanggal;
        $filteraktif = "filteraktif";
        if ($provinsi == "" && $wilayah == "" && ($tanggal == "" || $tanggal == date('Y-m-d'))) {
            $filteraktif = "";
            $tanggalmodel = date('Y-m-d');
        }

        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid != 1) {
            return redirect()->to('/');
        }

        $getrekap = $this->model_tppk->getDaftarStatistik($tanggalmodel, $asal, $wilayah);
        $getprovinsi = $this->model_tppk->get_daf_provinsi();

        $data['formattedtanggal'] = namabulan_panjang($tanggalmodel);;
        $data['rekap'] = $getrekap;
        $data['asal'] = $asal;
        $data['tanggal'] = $tanggal;
        $data['provinsi'] = $provinsi;
        $data['kota'] = $kota;
        $data['wilayah'] = $wilayah;
        $data['dafprovinsi'] = $getprovinsi;
        $data['filteraktif'] = $filteraktif;
        return view('tppk/statistik_user', $data);
    }

    public function lihatanggota($npsn)
    {
        $tanggalSekarang = date('Y-m-d');
        $tanggalTertentu = date('Y-m-d', strtotime('2024-04-21'));
        if ($tanggalSekarang < $tanggalTertentu) {
        } else {
            $userlogin = session()->get('loggedIn');
            if (!$userlogin) {
                return redirect()->to('/home');
            }
        }

        $query1 = $this->model_tppk->getSekolah($npsn);
        $hasil = $query1->getRowArray();

        $data['npsn'] = $npsn;
        $data['namasekolah'] = $hasil;

        if ($hasil)
            $idinstansi = $hasil['instansi_id'];
        else {
            echo "Data tidak valid";
            die();
            redirect()->to('/');
        }
        $daftarNamaWilayah = $this->model_tppk->getDataWilayah($hasil['kode_wilayah']);
        $NamaWilayah = $daftarNamaWilayah->getResult();

        $jmlPTK = $this->model_tppk->getPTKRes($npsn);
        if (!$jmlPTK) {
            $data['jumlah_ptk'] = 0;
        } else {
            $data['jumlah_ptk'] = $jmlPTK['total'];
        }

        $data['kepalasekolah'] = '-';

        $daftarPTK = $this->model_tppk->getPTK($idinstansi);
        foreach ($daftarPTK as $row) {
            if ($row->jenis_ptk_id == 20) {
                $data['kepalasekolah'] = $row->nama;
                break;
            }
        }

        $data['provinsi'] = $NamaWilayah[0]->propinsi;
        $data['kota'] = $NamaWilayah[0]->kota;
        $data['kecamatan'] = $NamaWilayah[0]->kecamatan;

        $daftarPD = $this->model_tppk->getPDRes($npsn);
        if (!$daftarPD) {
            $data['jumlah_pd'] = 0;
        } else {
            $data['jumlah_pd'] = $daftarPD['total_pd'];
        }

        //$idinstansi = '00A490FB-30F5-E011-A488-CDC073892C5F';
        $query2 = $this->model_tppk->getDaftarAnggota($idinstansi);
        $dafanggota = $query2->getResultArray();
        $getsk = $this->model_tppk->getSKSekolah($npsn);
        $data['datask'] = $getsk;
        $data['daftaranggota'] = $dafanggota;
        $queryop2 = $this->model_tppk->getOperator($idinstansi);
        $data['operator'] = $queryop2;
        $data['instansiid'] = $idinstansi;
        $data['sk_tugas'] = "-";
        $data['tgl_sk'] = "-";

        ////////////////////cek file sk
        $linknomorsk = "-";
        if ($dafanggota) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['sk_tugas']);
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "" && session()->get('loggedIn') && $dafanggota) {
                $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $dafanggota[0]['sk_tugas'] . '</a>';
            } else {
                if ($dafanggota > 1)
                    $linknomorsk = $dafanggota[0]['sk_tugas'];
                else {
                    $linknomorsk = "-";
                }
            }
            $data['sk_tugas'] = $dafanggota[0]['sk_tugas'];
            $data['tgl_sk'] = $dafanggota[0]['tmt_sk_tugas'];
        }


        $data['linknomorsk'] = $linknomorsk;

        if ($npsn == "99999999") {
            $doperator = [
                (object) ['nama_operator' => 'Operator Sekolah', 'usia' => 30],
                (object) ['nama_operator' => 'Jane Smith', 'usia' => 25],
                (object) ['nama_operator' => 'Mike Johnson', 'usia' => 35]
            ];
            $daftaranggota = [
                ['nm_ang' => 'John Doe', 'peran_ang' => 'Ketua', 'jenis_ptk' => 'Guru Mapel', 'nama_sekolah' => 'SMP Percobaan Saja', 'tmt_sk_tugas' => '2023-07-21 10:01:34', 'tst_sk_tugas' => '2024-01-21 10:01:34'],
                ['nm_ang' => 'Jane Smith', 'peran_ang' => 'Anggota 1', 'jenis_ptk' => 'Guru Mapel', 'nama_sekolah' => 'SMP Percobaan Saja', 'tmt_sk_tugas' => '2023-07-21 10:01:34', 'tst_sk_tugas' => '2024-01-21 10:01:34'],
                ['nm_ang' => 'Mike Johnson', 'peran_ang' => 'Anggota 2', 'jenis_ptk' => 'Guru Mapel', 'nama_sekolah' => 'SMP Percobaan Saja', 'tmt_sk_tugas' => '2023-07-21 10:01:34', 'tst_sk_tugas' => '2024-01-21 10:01:34']
            ];

            $sktugas = "TPPK-2023/1";
            $data['jumlah_ptk'] = 10;
            $data['jumlah_pd'] = 50;
            $data['operator'] = $doperator;
            $data['daftaranggota'] = $daftaranggota;
            $data['sk_tugas'] = $sktugas;

            $linknomorsk = "-";

            $dafanggota = 3;
            if ($dafanggota) {

                $namafiletanpaekstensi = "sk_99999999_TPPK20231";

                $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

                if ($namafilesk != "") {
                    $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                    $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $sktugas . '</a>';
                } else {
                    if ($dafanggota > 1)
                        $linknomorsk = $sktugas;
                    else {
                        $linknomorsk = "-";
                    }
                }
            }

            $data['linknomorsk'] = $linknomorsk;
        }


        return view('tppk/periksadaftaranggota', $data);
    }

    public function lihatanggota2($kodewilayah)
    {
        $tanggalSekarang = date('Y-m-d');
        $tanggalTertentu = date('Y-m-d', strtotime('2024-04-21'));
        if ($tanggalSekarang < $tanggalTertentu) {
        } else {
            $userlogin = session()->get('loggedIn');
            if (!$userlogin) {
                return redirect()->to('/home');
            }
        }

        $namakota = "";
        $namaprovinsi = "";
        if (intval(substr($kodewilayah, 2) == 0)) {
            $getnamapropinsi = $this->model_tppk->getNamaPilihan($kodewilayah);
            $resultnamapropinsi = $getnamapropinsi->getRow();
            if ($resultnamapropinsi) {
                $namaprovinsi = $resultnamapropinsi->nama;
            }
        } else {
            $getnamapropinsi = $this->model_tppk->getNamaPilihan(substr($kodewilayah, 0, 2) . "0000");
            $resultnamapropinsi = $getnamapropinsi->getRow();
            if ($resultnamapropinsi) {
                $namaprovinsi = $resultnamapropinsi->nama;
            }
            $getnamakota = $this->model_tppk->getNamaPilihan($kodewilayah);
            $gnamakota = $getnamakota->getRow();
            if ($gnamakota)
                $namakota = $gnamakota->nama;
        }

        if ($namaprovinsi == "") {
            echo "Kode Wilayah tidak Ditemukan";
            die();
        }

        $data['namaprovinsi'] = $namaprovinsi;
        $data['namakota'] = $namakota;
        $data['jumlah_kab'] = 4;
        if (intval(substr($kodewilayah, 2) == 0))
            $level = 1;
        else
            $level = 2;

        $data['level'] = $level;

        $getsk = $this->model_tppk->getSKProv($kodewilayah);
        $data['datask'] = $getsk;

        $dafanggota = [];

        if ($getsk) {
            $dafanggota = $this->model_tppk->getAnggotaProv($getsk['sk_id']);
        }
        $data['daftaranggota'] = $dafanggota;
        $data['filepdf'] = "-";
        $data['sudah_upload'] = false;

        ////////////////////cek file sk
        $linknomorsk = "-";
        if ($dafanggota) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['nomor_sk']);
            $namafiletanpaekstensi = "sk_" . trim($kodewilayah) . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "") {
                $data['sudah_upload'] = true;
                $data['filepdf'] = $namafilesk ? $namafilesk['relativePath'] : '-';
                // $data['filepdf'] = $namafilesk;
            }

            if ($namafilesk != "" && session()->get('loggedIn') && $dafanggota) {
                $fileUrl = base_url('inputdata/download_sk/' . $namafilesk['relativePath']);

                // $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $dafanggota[0]['nomor_sk'] . '</a>';
            } else {
                if ($dafanggota > 1)
                    $linknomorsk = $dafanggota[0]['nomor_sk'];
                else {
                    $linknomorsk = "-";
                }
            }
        }

        $data['namafilesk'] = $namafilesk;
        $data['linknomorsk'] = $linknomorsk;
        $data['kodewilayah'] = $kodewilayah;
        $data['instansiid'] = session()->get('jenis_instansi_id');

        return view('tppk/periksadaftaranggota2', $data);
    }

    public function sksesuai()
    {
        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid == 1) {
            $request = \Config\Services::request();
            $kodewilayah = $request->getVar('kodewilayah');
            $opsi = $request->getVar('opsi');
            $getsk = $this->model_tppk->getSKProv($kodewilayah);
            $skid = $getsk['sk_id'];

            $status = 0;
            $catatan = "";
            if ($opsi == 2) {
                $status = 1;
            } else {
                $catatan = $request->getVar('catatan');
            }

            $this->model_tppk->setsksesuai($skid, $opsi, $catatan);

            $level_wilayah = 2;
            if (substr($kodewilayah, 2, 2) == '00') {
                $level_wilayah = 1;
            }
            // $this->model_tppk->updaterekapwilayah($level_wilayah, $kodewilayah, $status);
            $this->model_tppk->update_satgas_valid($kodewilayah);

            return true;
        }
    }

    public function sktppksesuai()
    {
        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid == 2 || $instansiid == 3) {
            $request = \Config\Services::request();
            $npsn = $request->getVar('npsn');
            $opsi = $request->getVar('opsi');
            $getsk = $this->model_tppk->getSKSekolah($npsn);
            $skid = $getsk['sk_id'];
            // $this->model_tppk->setsktppksesuai($skid, $opsi);

            return true;
        }
    }

    public function operatorsesuai()
    {
        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid == 1) {
            $request = \Config\Services::request();
            $pengguna_id = $request->getVar('pengguna_id');
            $catatan = $request->getVar('catatan');
            $opsi = $request->getVar('opsi');
            $this->model_tppk->updatestatusapproval($pengguna_id, $opsi, $catatan);

            return true;
        }
    }

    private function clear_residu_upload_sk($npsn)
    {
        $getSKSekolah = $this->model_tppk->getResiduSekolah($npsn);
        $updateupload = "";
        $updateresidu = "";
        if ($getSKSekolah['residu_upload_sk'] == 1) {
            $updateupload = "update";
        };


        if ($getSKSekolah['residu_kepsek'] == 0 && $getSKSekolah['residu_guru'] == 0 && $getSKSekolah['residu_komite'] == 0 && $getSKSekolah['residu_siswa'] == 0 && $getSKSekolah['residu_ganjil'] == 0 && $getSKSekolah['residu_upload_sk'] == 1) {
            $updateresidu = "update";
        }
        $data = [
            'residu_upload_sk' => $updateupload,
            'residu' => $updateresidu,
        ];
        $this->model_tppk->UpdateResiduSekolah($data, $npsn);
    }

    public function status_laporan()
    {
        $request = \Config\Services::request();

        $datajenjang = ['first', 'semua', 'dikmen', 'dikdas'];
        $daftaropsijenjang[1] = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'SLB', 'Kesetaraan'];
        $daftaropsijenjang[2] = ['SMA', 'SMK', 'SLB'];
        $daftaropsijenjang[3] = ['PAUD', 'SD', 'SMP', 'Kesetaraan'];

        $sebagai = session()->get('sebagai');
        $instansiid = session()->get('jenis_instansi_id');

        $wilayahakses = "";
        if (session()->get('wilayah_akses'))
            $wilayahakses = session()->get('wilayah_akses');

        $indeks = 0;

        if ($sebagai == "irjen" || $sebagai == "pusat")
            $indeks = 1;
        else if ($sebagai == "dinasprovinsi")
            $indeks = 2;
        else if ($sebagai == "dinaskota")
            $indeks = 3;
        else if ($sebagai == "operatorsatgas") {
            if (substr($wilayahakses, 2, 2) == "00")
                $indeks = 2;
            else
                $indeks = 3;
        }

        if ($request->getVar('kode_wilayah'))
            $kode_wilayah = $request->getVar('kode_wilayah');
        else
            $kode_wilayah = '000000';
        if ($request->getVar('npsn'))
            $npsn = $request->getVar('npsn');
        else
            $npsn = "";

        if ($indeks == 2) {
            if (substr($wilayahakses, 0, 2) != substr($kode_wilayah, 0, 2) && $kode_wilayah != "000000") {
                echo "ACCESS DENIED!";
                die();
            }
        } else {
            if ($indeks == 3) {
                if (substr($wilayahakses, 0, 4) != substr($kode_wilayah, 0, 4) && $kode_wilayah != "000000") {
                    echo "ACCESS DENIED!";
                    die();
                }
            }
        }

        $jenjangall = $datajenjang[$indeks];
        if ($request->getVar('jenjang'))
            $jenjang = $request->getVar('jenjang');
        else
            $jenjang = $jenjangall;

        $laporan = "";
        if ($request->getVar('laporan'))
            $laporan = $request->getVar('laporan');

        if (in_array($jenjang, $datajenjang)) {
            if ($jenjang != $jenjangall) {
                echo "Tidak Sesuai";
                die();
            }
        } else if (!in_array($jenjang, $daftaropsijenjang[$indeks])) {
            echo "Tidak Sesuai";
            die();
        }

        $data = [];

        if ($sebagai != "irjen" && $sebagai != "pusat" && $sebagai != "dinasprovinsi" && $sebagai != "dinaskota" && $sebagai != "operatorsatgas") {
            return redirect()->to('/home');
        } else {
            $level = 99;
            $namawilayah1 = "";
            $namawilayah2 = "";
            $namawilayah3 = "";
            if ($kode_wilayah == '000000' && $npsn == "") {
                if ($sebagai == "dinasprovinsi" || $sebagai == "dinaskota" || $sebagai == "operatorsatgas") {
                    $kode_wilayah = $wilayahakses;
                } else {
                    $level = 0;
                    $data['judulkolom'] = "Provinsi";
                    $data['judul'] = "DI INDONESIA";
                }
            }
        }


        if ($level == 99) {

            $kodelevel2 = substr($kode_wilayah, 2, 2);
            $kodelevel3 = substr($kode_wilayah, 4, 2);

            if ($kodelevel2 == '00') {
                if ($npsn == "") {
                    if ($kode_wilayah == "880000")
                        $namawilayah1 = "Prov. ABCD";
                    else
                        $namawilayah1 = $this->model_tppk->getJudulProp(1, $kode_wilayah)['nama'];
                    $level = 1;
                    $data['judulkolom'] = "Kota/Kabupaten";
                    $data['judul'] = strtoupper($namawilayah1);
                } else {
                    $level = 4;
                    $namasekolah = $this->model_tppk->getInfoSekolah($npsn);
                    $data['judulkolom'] = "Satuan Pendidikan";
                    $data['judul'] = strtoupper($namasekolah['nama']);
                }
            } else if ($kodelevel3 == '00') {
                if ($kode_wilayah == "880100")
                    $namawilayah2 = "Kota. BCD";
                else
                    $namawilayah1 = $this->model_tppk->getJudulProp(1, substr($kode_wilayah, 0, 2) . '0000')['nama'];
                if ($kode_wilayah == "880100")
                    $namawilayah1 = "Prov. ABCD";
                else {
                    $getjudulprop = $this->model_tppk->getJudulProp(1, $kode_wilayah);
                    if ($getjudulprop)
                        $namawilayah2 = $getjudulprop['nama'];
                    else {
                        echo "KODE TIDAK DITEMUKAN";
                        die();
                    }
                }
                $level = 2;
                $data['judulkolom'] = "Kecamatan";
                $data['judul'] = strtoupper($namawilayah2);
            } else if ($kodelevel3 != "00" && $npsn == "") {
                if ($sebagai != "irjen" && $sebagai != "pusat") {
                    return redirect()->to('/home');
                }
                $namawilayah1 = $this->model_tppk->getJudulProp(1, substr($kode_wilayah, 0, 2) . '0000')['nama'];
                $namawilayah2 = $this->model_tppk->getJudulProp(1, substr($kode_wilayah, 0, 4) . '00')['nama'];
                $namawilayah3 = $this->model_tppk->getJudulProp(1, $kode_wilayah)['nama'];
                $level = 3;
                $data['judulkolom'] = "Satuan Pendidikan";
                $data['judul'] = strtoupper($namawilayah3);
            } else if ($kode_wilayah != '000000') {
                if ($sebagai != "irjen" && $sebagai != "pusat") {
                    return redirect()->to('/home');
                }
                $namawilayah1 = $this->model_tppk->getJudulProp(1, substr($kode_wilayah, 0, 4) . '00')['nama'];
                $namawilayah2 = $this->model_tppk->getJudulProp(1, substr($kode_wilayah, 0, 4) . '00')['nama'];
                $namawilayah3 = $this->model_tppk->getJudulProp(1, $kode_wilayah)['nama'];
                $namasekolah = $this->model_tppk->getInfoSekolah($npsn);
                $data['judul'] = strtoupper($namasekolah['nama']);
                $data['judulkolom'] = "Satuan Pendidikan";
                $level = 4;
            }
        }

        $linkindonesiaoff = "Indonesia";
        $linkindonesiaon = "<a href=" . base_url('status_laporan_kekerasan') . ">Indonesia</a>";

        $linkprovinsioff = substr($namawilayah1, 5);
        $linkprovinsion = "<a href=" . base_url('status_laporan_kekerasan?kode_wilayah=' . substr($kode_wilayah, 0, 2) . '0000') . ">" . substr($namawilayah1, 5) . "</a>";

        $linkkotaoff = ">> " . substr($namawilayah2, 0);
        $linkkotaon = ">> <a href=" . base_url('status_laporan_kekerasan?kode_wilayah=' . substr($kode_wilayah, 0, 4) . '00') . ">" . substr($namawilayah2, 0) . "</a>";

        $linkkecamatanoff = ">> " . substr($namawilayah3, 0);
        $linkkecamatanon = ">> <a href=" . base_url('status_laporan_kekerasan?kode_wilayah=' . substr($kode_wilayah, 0, 6)) . ">" . $namawilayah3 . "</a>";


        $data['jenjangall'] = $jenjangall;
        $data['jenjang'] = $jenjang;

        $view = 'statuslaporan';
        if ($laporan == "dinas") {
            $view = 'daftarlaporan';
            if ($level == 1) {
                $linkprovinsion = $linkprovinsioff;
                $linkkotaoff = "";
                $linkkotaon = "";
                $linkkecamatanoff = "";
                $linkkecamatanon = "";
            } else if ($level == 2) {
                $linkkotaon = $linkkotaoff;
                $linkkecamatanoff = "";
                $linkkecamatanon = "";
            }
        } else {
            // if ($level == 1 && $sebagai == "dinasprov")
            //     $view = 'daftarlaporan';
            // else if ($level == 2 && $sebagai == "dinaskota")
            //     $view = 'daftarlaporan';
            if ($level == 4)
                $view = 'daftarlaporan';
        }

        if ($sebagai == "irjen" || $sebagai == "pusat") {
            $data['linkindonesia'] = $linkindonesiaon;
            $data['linkprovinsi'] = $linkprovinsion;
            $data['linkkota'] = $linkkotaon;
            $data['linkkecamatan'] = $linkkecamatanon;
            $data['opsijenjang'] = $daftaropsijenjang[1];
        } else if ($sebagai == "dinasprovinsi") {
            $data['linkindonesia'] = $linkindonesiaoff;
            $data['linkprovinsi'] = $linkprovinsion;
            $data['linkkota'] = $linkkotaon;
            $data['linkkecamatan'] = $linkkecamatanon;
            $data['opsijenjang'] = $daftaropsijenjang[2];
            $prefikswilayahakses = substr($wilayahakses, 0, 2);
            $prefikskodewilayah = substr($kode_wilayah, 0, 2);
            if ($prefikswilayahakses != $prefikskodewilayah) {
                echo "Tidak dapat mengakses";
                die();
            }
        } else if ($sebagai == "dinaskota") {
            $data['linkindonesia'] = $linkindonesiaoff;
            $data['linkprovinsi'] = $linkprovinsioff;
            $data['linkkota'] = $linkkotaon;
            $data['linkkecamatan'] = $linkkecamatanon;
            $data['opsijenjang'] = $daftaropsijenjang[3];
            $prefikswilayahakses = substr($wilayahakses, 0, 4);
            $prefikskodewilayah = substr($kode_wilayah, 0, 4);
            if ($prefikswilayahakses != $prefikskodewilayah) {
                echo "Tidak dapat mengakses";
                die();
            }
        } else if ($sebagai == "operatorsatgas") {
            if ($indeks == 2) {
                $data['linkindonesia'] = $linkindonesiaoff;
                $data['linkprovinsi'] = $linkprovinsion;
                $data['linkkota'] = $linkkotaon;
                $data['linkkecamatan'] = $linkkecamatanon;
                $data['opsijenjang'] = $daftaropsijenjang[2];
                $prefikswilayahakses = substr($wilayahakses, 0, 2);
                $prefikskodewilayah = substr($kode_wilayah, 0, 2);
                if ($prefikswilayahakses != $prefikskodewilayah) {
                    echo "Tidak dapat mengakses";
                    die();
                }
            } else {
                $data['linkindonesia'] = $linkindonesiaoff;
                $data['linkprovinsi'] = $linkprovinsioff;
                $data['linkkota'] = $linkkotaon;
                $data['linkkecamatan'] = $linkkecamatanon;
                $data['opsijenjang'] = $daftaropsijenjang[3];
                $prefikswilayahakses = substr($wilayahakses, 0, 4);
                $prefikskodewilayah = substr($kode_wilayah, 0, 4);
                if ($prefikswilayahakses != $prefikskodewilayah) {
                    echo "Tidak dapat mengakses";
                    die();
                }
            }
        }

        // echo $indeks;
        // die();

        if ($level == 0) {
            $get_rekap_laporan = $this->model_tppk->get_rekap_laporan($jenjang);
        } else if ($level == 1) {
            if ($laporan == "dinas" && ($sebagai == "irjen" || $sebagai == "pusat" || $sebagai == "dinasprovinsi" || $sebagai == "operatorsatgas")) {
                $get_rekap_laporan = $this->model_tppk->get_rekap_dinas_provinsi($kode_wilayah);
                $view = 'daftarlaporan';
            } else {
                if ($sebagai == "operatorsatgas") {
                    $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_kota($kode_wilayah, $jenjang);
                    $view = 'statuslaporansatgas';
                } else {
                    $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_kota($kode_wilayah, $jenjang);
                    $view = 'statuslaporan';
                }
            }
        } else if ($level == 2) {
            if ($laporan == "dinas" && ($sebagai == "irjen" || $sebagai == "pusat" || $sebagai == "dinasprovinsi" || $sebagai == "dinaskota" || $sebagai == "operatorsatgas")) {
                $level = 5;
                $get_rekap_laporan = $this->model_tppk->get_rekap_dinas_provinsi($kode_wilayah);
                $view = 'daftarlaporan';
            } else {
                if ($sebagai == "operatorsatgass") {
                    $get_rekap_laporan = $this->model_tppk->get_rekap_dinas_provinsi($kode_wilayah);
                    $view = 'daftarlaporansatgaskota';
                } else {
                    if ($npsn != "") {
                        $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_sekolah($npsn);
                        $view = 'daftarlaporan';
                        $data['linkkota'] = $linkkotaon;
                        $data['linkkecamatan'] = "";
                        $namasekolah = $this->model_tppk->getInfoSekolah($npsn);
                        $data['judulkolom'] = "Satuan Pendidikan";
                        $kodewilayahsekolah = $namasekolah['kode_wilayah'];
                        if ($indeks == 2) {
                            if (substr($kodewilayahsekolah, 0, 2) != substr($wilayahakses, 0, 2)) {
                                echo "ACCESS DENIED!";
                                die();
                            }
                        } else if ($indeks == 3) {
                            if (substr($kodewilayahsekolah, 0, 4) != substr($wilayahakses, 0, 4)) {
                                echo "ACCESS DENIED!";
                                die();
                            }
                        }
                        if ($namasekolah) {
                            $data['judul'] = strtoupper($namasekolah['nama']);
                        } else {
                            echo "KODE SEKOLAH TIDAK DITEMUKAN";
                            die();
                        }
                    } else if ($sebagai == "dinasprovinsi") {
                        $get_rekap_laporan = $this->model_tppk->get_rekap_dinas_provinsi($kode_wilayah);
                        $view = 'daftarlaporansatgaskota';
                        $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_satuan_pendidikan($kode_wilayah, $jenjang);
                        $view = 'statuslaporansatgaskota';
                    } else {
                        $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_satuan_pendidikan($kode_wilayah, $jenjang);
                        $view = 'statuslaporansatgaskota';
                    }
                }
            }
        } else if ($level == 3) {
            if ($sebagai == "irjen")
                $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_kecamatan($kode_wilayah, $jenjang);
            else {
                echo "Tidak memiliki akses";
                die();
            }
        } else if ($level == 4) {
            $get_rekap_laporan = $this->model_tppk->get_rekap_laporan_sekolah($npsn);
        }

        // echo "LEVEL:" . $level . "<br>";
        // echo var_dump($get_rekap_laporan);
        // die();

        $statustppk = session()->get('statustppk');

        $data['area'] = true;
        $data['indeks'] = $indeks;
        $data['rekap_laporan'] = $get_rekap_laporan;
        $data['laporan'] = $laporan;
        $data['wilayah1'] = $namawilayah1;
        $data['wilayah2'] = $namawilayah2;
        $data['wilayah3'] = $namawilayah3;
        $data['kode_wilayah'] = $kode_wilayah;
        $data['level'] = $level;
        $data['statustppk'] = $statustppk;
        $data['jenjang'] = $jenjang;
        $data['sebagai'] = $sebagai;
        $data['instansiid'] = $instansiid;

        // echo $view . "-" . $sebagai . "-" . $level;
        // echo $instansiid;
        // die();

        return view($view, $data);
    }

    public function daftar_laporan($opsilogin = "prod")
    {
        $request = \Config\Services::request();

        $laporan = "";
        if ($request->getVar('laporan'))
            $laporan = $request->getVar('laporan');

        if ($opsilogin == "test")
            $viewlogin = "login_eksternal_test";
        else
            $viewlogin = "login_eksternal";

        $asallogin = session()->get('asallogin');

        $sebagai = "sekolah";
        $instansiid = session()->get('jenis_instansi_id');
        if ($instansiid == 2 || $instansiid == 3) {
            session()->set('statustppk', 'anggota1');
            $sebagai = "dinas";
        }

        if ($asallogin != "eksternal" && $instansiid != 2 && $instansiid != 3) {
            session()->set('tes', true);
            session()->set('opsilogin', $opsilogin);
            return view($viewlogin);
            // return redirect()->to('https://dev-sso.datadik.kemdikbud.go.id/app/60B05B81-79A8-46D0-9458-7B10E5B7606C');
        } else {
            $valid = false;
            $statustppk = session()->get('statustppk');
            $peran = session()->get('peran');
            $data = [];
            if ($statustppk == "ketua" || $statustppk == "anggota1") {
                $valid = true;
                $npsn = session()->get('npsn_user');
                $infoSekolah = $this->model_tppk->getInfoSekolah($npsn);
                $namasekolah = "";
                if ($infoSekolah)
                    $namasekolah = $infoSekolah['nama'];
                $rekap_laporan = $this->model_tppk->get_daf_laporan($npsn);
            } else if ($peran == "ketua" || $peran == "anggota1") {
                $kode_wilayah = session()->get('wilayah_akses');
                $valid = true;
                $rekap_laporan = $this->model_tppk->get_daf_laporan($kode_wilayah);
                echo "DISI";
                die();
            }

            if ($valid) {
                session()->set('opsilogin', $opsilogin);

                $data['area'] = false;
                $data['judul'] = "";
                $data['laporan'] = $laporan;
                $data['statustppk'] = $statustppk;
                $data['instansiid'] = 5;
                $data['sebagai'] = $sebagai;
                $data['kode_wilayah'] = "";
                $data['wilayah2'] = $namasekolah;
                $data['rekap_laporan'] = $rekap_laporan;
                $data['indeks'] = 0;
                $data['level'] = 0;

                return view('daftarlaporan', $data);
            } else {
                echo "Hanya anggota TPPK yang dipilih, yang bisa mengisi Laporan";
            }
        }
    }

    public function lihatanggota_op($pengguna_id)
    {
        $getdataoperator = $this->model_tppk->getDataOperator($pengguna_id);
        $kodewilayah = $getdataoperator->kode_wilayah;
        $op_wil = "op_kota";
        if (substr($kodewilayah, 2, 2) == "00")
            $op_wil = "op_prov";
        $data['op_wil'] = $op_wil;
        $data['dataoperator'] = $getdataoperator;
        return view('tppk/lihatpetugas_op', $data);
    }

    public function pelaporan()
    {
        $username = session()->get('username');
        $instansiid = session()->get('jenis_instansi_id');
        $sebagai = session()->get('sebagai');

        // echo "<pre>";
        // echo var_dump(session()->get());
        // echo "</pre>";
        // die();

        if ($instansiid == 2 || $instansiid == 3) {
            return redirect()->to('/home');
            session()->set('statustppk', 'anggota1');
        }
        if ($username == "hardianto@kemdikbud.go.id") {
            // $request = \Config\Services::request();
            // // if (!$request->getVar('instansiid')) {
            // //     return redirect()->to(base_url() . 'inputdata/pelaporan?instansiid=5&npsn=20613768');
            // // } else {
            // session()->set('npsn_user', $request->getVar('npsn') ?? null);
            // session()->set('jenis_instansi_id', $request->getVar('instansiid') ?? null);
            // session()->set('wilayah_akses', $request->getVar('wilayah') ?? null);
            // }
        }

        // if ($instansiid != 5) {
        //     session()->set('npsn_user', '20100216');
        // }

        $userlogin = session()->get('loggedIn');
        $asallogin = session()->get('asallogin');
        if ($asallogin != "eksternal" && $username != "hardianto@kemdikbud.go.id" && $sebagai != "operatorsatgas") {
            session()->set('tes', true);
            return view('login_eksternal');
            // return redirect()->to('https://dev-sso.datadik.kemdikbud.go.id/app/60B05B81-79A8-46D0-9458-7B10E5B7606C');
        } else {
            $data = [];
            $instansiid = session()->get('jenis_instansi_id');
            $wilayah = session()->get('wilayah_akses');
            $npsn = session()->get('npsn_user');
            $nomordepan = $npsn;
            if ($sebagai == "operatorsatgas") {
                $ceknomor = $this->model_tppk->cek_nomor_kasus($wilayah);
                $npsn = '';
                $nomordepan = trim($wilayah);
                $infoSekolah = "";
                $sekolah_id = "";
            } else {
                $ceknomor = $this->model_tppk->cek_nomor_kasus($npsn);
                $infoSekolah = $this->model_tppk->getInfoSekolah($npsn);
                $sekolah_id = $infoSekolah['sekolah_id'];
            }
            $nomorbaru = "";
            if (!$ceknomor)
                $nomorbaru = $nomordepan . "-" . date("Y-m-d") . "-1";
            else {
                $nomorlama = $ceknomor['nomor_register'];
                // $nomor = "50100322-2024-01-04-1";
                $nomor_array = explode('-', $nomorlama);
                // $nomorlama = substr($nomor, 20);
                $angka_terakhir = end($nomor_array);
                $idx = intval($angka_terakhir);
                $idx++;
                $nomorbaru = $nomordepan . "-" . date("Y-m-d") . "-" . $idx;
            }
            // echo $nomorbaru;
            // die();
            $getstatuskorban = $this->model_tppk->get_status_korban();
            $getbentukkekerasan = $this->model_tppk->get_bentuk_kekerasan();
            $getkebutuhankhusus = $this->model_tppk->get_kebutuhan_khusus();
            $getprovinsi = $this->model_tppk->get_daf_provinsi();

            if ($instansiid == 2 || $instansiid == 3 || $sebagai == "operatorsatgas") {
                $sebagai = "dinas";
                $getdaftarsiswa = "";
                $getdaftarpendidik = "";
                $getdaftartenagakependidikan = "";
                $getdaftarkepsek = "";
            } else {
                $sebagai = "sekolah";
                $getsekolah = $this->model_tppk->getSekolah($npsn)->getRowArray();
                $data['sekolah_saya'] = $getsekolah;
                $getdaftarsiswa = $this->model_tppk->get_daf_siswa($sekolah_id);
                $getdaftarpendidik = $this->model_tppk->get_daf_ptk($sekolah_id, "p");
                $getdaftartenagakependidikan = $this->model_tppk->get_daf_ptk($sekolah_id, "tk");
                $getdaftarkepsek = $this->model_tppk->get_kepsek($sekolah_id);
            }
            $data['sebagai'] = $sebagai;
            $data['nomor_register'] = $nomorbaru;
            $data['daf_status_korban'] = $getstatuskorban;
            $data['daf_bentuk_kekerasan'] = $getbentukkekerasan;
            $data['daf_kebutuhan_khusus'] = $getkebutuhankhusus;
            $data['daf_provinsi'] = $getprovinsi;
            $data['daf_siswa'] = $getdaftarsiswa;
            $data['daf_pendidik'] = $getdaftarpendidik;
            $data['daf_tenagakependidikan'] = $getdaftartenagakependidikan;
            $data['daf_kepsek'] = $getdaftarkepsek;
            // $data['tgl_pelaporan'] = date("Y-m-d");
            $data['tgl_sekarang'] = date("d/m/Y");
            $data['npsn'] = $npsn;
            $data['wilayah'] = $wilayah;
            return view('tppk/input_formulir', $data);
        }
    }

    public function view($kasus_id)
    {
        // echo "on process...";
        // die();
        $instansiid = session()->get('jenis_instansi_id');
        $username = session()->get('username');
        if ($username == "hardianto@kemdikbud.go.id") {
            $request = \Config\Services::request();
            // if (!$request->getVar('instansiid')) {
            //     return redirect()->to(base_url() . 'inputdata/view/' . $kasus_id . '?instansiid=5&npsn=20613768');
            // } else {
            //     session()->set('npsn_user', $request->getVar('npsn') ?? null);
            //     session()->set('jenis_instansi_id', $request->getVar('instansiid') ?? null);
            //     session()->set('wilayah_akses', $request->getVar('wilayah') ?? null);
            // }
        }

        // if ($instansiid != 5) {
        //     session()->set('npsn_user', '20100216');
        // }

        $userlogin = session()->get('loggedIn');
        if (!$userlogin) {
            echo "HARUS LOGIN DAHULU";
            die();
        } else {
            $data = [];
            $instansiid = session()->get('jenis_instansi_id');
            $npsn = session()->get('npsn_user');
            $wilayah = session()->get('wilayah_akses');

            $getstatuskorban = $this->model_tppk->get_status_korban();
            $getbentukkekerasan = $this->model_tppk->get_bentuk_kekerasan();
            $getkebutuhankhusus = $this->model_tppk->get_kebutuhan_khusus();
            $getprovinsi = $this->model_tppk->get_daf_provinsi();
            $getdatakasus = $this->model_tppk->get_kasus($kasus_id);
            $getdatapelaporan = $this->model_tppk->get_pelaporan($kasus_id);
            $getdatakorban = $this->model_tppk->get_korban_pelaku($kasus_id, 1);
            $getdatapelaku = $this->model_tppk->get_korban_pelaku($kasus_id, 2);
            $getdataterlapor = $this->model_tppk->get_korban_pelaku($kasus_id, 3);
            if ($instansiid == 5)
                $sebagai = "sekolah";
            else
                $sebagai = "dinas";
            $data['sebagai'] = $sebagai;
            $data['daf_status_korban'] = $getstatuskorban;
            $data['daf_bentuk_kekerasan'] = $getbentukkekerasan;
            $data['daf_kebutuhan_khusus'] = $getkebutuhankhusus;
            $data['daf_provinsi'] = $getprovinsi;
            $data['data_kasus'] = $getdatakasus;
            $data['data_pelaporan'] = $getdatapelaporan;
            $data['data_korban'] = $getdatakorban;
            $data['data_pelaku'] = $getdatapelaku;
            $data['data_terlapor'] = $getdataterlapor;
            $data['npsn'] = $npsn;

            return view('tppk/edit_formulir', $data);
        }
    }

    public function get_data_p()
    {
        $request = \Config\Services::request();
        $npsn = $request->getVar('npsn'); //10901347 // 20532941 // 20350704
        $nik = $request->getVar('nik'); //1904014206060001 // 3578200606120004 //ptk 3578201701670001 // ganda : 3131742211 
        $jenis = $request->getVar('jenis'); //1904014206060001 // 3578200606120004
        $nomor = "NISN";

        if ($jenis == 1)
            $get_data_siswa = $this->model_tppk->getsiswasekolah($npsn, $nik);
        else if ($jenis == 2) {
            $nomor = "NIK";
            $get_data_siswa = $this->model_tppk->getgurunuptk($npsn, $nik);
            if (!$get_data_siswa) {
                $get_data_siswa = $this->model_tppk->getgurunik($npsn, $nik);
                $nomor = "NUPTK";
            }
        }
        // echo var_dump($get_data_siswa);
        $kebutuhan_khusus_id = 0;
        $kebutuhan_khusus = "";
        $status = "nonaktif";
        $nama_siswa = "";
        $valnama = "-";
        $valnik = "-";
        $nisn = "";
        // $nik = "";
        $tgl_lahir = "";
        $valtgl_lahir = "-";
        $sex = "";
        $valsex = "-";
        $nama_sekolah = "";
        $kodewilayah = "000000";
        $usia = 0;
        $nikayah = "";
        $namaayah = "";

        if ($get_data_siswa) {
            $status = "aktif";
            // $nik = $get_data_siswa['nik'];
            $nama_siswa = $get_data_siswa['nama_siswa'];
            $tgl_lahir = $get_data_siswa['tanggal_lahir'];
            $sex = $get_data_siswa['jenis_kelamin'];
            $nisn = $get_data_siswa['nisn'];
            $nama_sekolah = $get_data_siswa['nama_sekolah'];
            if ($jenis == 1) {
                $nikayah = $get_data_siswa['nik_ayah'];
                $namaayah = $get_data_siswa['nama_ayah'];
            }
            $jk = ($sex == "L") ? "Laki-Laki" : "Perempuan";
            $tgblthn = explode("-", $tgl_lahir);
            $tgllahir = $tgblthn[2] . "-" . $tgblthn[1] . "-" . $tgblthn[0];

            $tanggal_lahir_timestamp = strtotime($tgllahir);
            $today = time();
            if ($today < $tanggal_lahir_timestamp) {
                $tanggal_lahir_timestamp = strtotime('-1 year', $tanggal_lahir_timestamp);
            }
            $usia = date('Y', $today) - date('Y', $tanggal_lahir_timestamp);

            $hasilpadan = $this->padankandatakasus($nik, $nama_siswa, $tgllahir, $jk);
            $decodedData = json_decode($hasilpadan, true);

            $valid = strpos($hasilpadan, 'NAMA_LGKP');
            $niktaknemu = strpos($hasilpadan, 'NIK tidak terdapat di database Kependudukan');
            $niksalahformat = strpos($hasilpadan, 'NIK tidak sesuai format Dukcapil');
            $niksalahformat2 = strpos($hasilpadan, 'NIK yang dimasukan tidak sesuai format');
            if ($valid) {
                $valnik = "NIK sesuai";
                $decodedData = json_decode($hasilpadan, true);
                $valnama = $decodedData['NAMA_LGKP'];
                $valsex = $decodedData['JENIS_KLMIN'];
            } else if ($niktaknemu) {
                $valnama = "Nama tidak sesuai NIK";
                $valnik = "NIK tidak ditemukan";
                $valsex = "-";
                $valtglahir = "-";
            } else if ($niksalahformat) {
                $valnama = "Nama tidak sesuai NIK";
                $valnik = "NIK tidak sesuai format";
                $valsex = "-";
                $valtglahir = "-";
            } else if ($niksalahformat2) {
                $valnama = "Nama tidak sesuai NIK";
                $valnik = "NIK tidak sesuai format";
                $valsex = "-";
                $valtglahir = "-";
            } else {
                $valnama = "Server Dukcapil tidak aktif";
                $valnik = "Server Dukcapil tidak aktif";
                $valsex = "-";
                $valtglahir = "-";
            }

            // echo var_dump($decodedData);

            if (isset($decodedData['NAMA_LGKP'])) {
                $valnama = $decodedData['NAMA_LGKP'];
                $valtgl_lahir = $decodedData['TGL_LHR'];
                $valsex = $decodedData['JENIS_KLMIN'];
            }

            $infoSekolah = $this->model_tppk->getInfoSekolah($npsn);
            $kodewilayah = $infoSekolah['kode_wilayah'];

            $pdid = $get_data_siswa['peserta_didik_id'];
            if ($jenis == 1) {
                $get_kebutuhan_khusus = $this->model_tppk->getkebutuhankhusus($pdid);
                $kebutuhan_khusus_id = $get_kebutuhan_khusus['kebutuhan_khusus_id'];
                $kebutuhan_khusus = $get_kebutuhan_khusus['kebutuhan_khusus'];
            } else {
                $get_kebutuhan_khusus = $this->model_tppk->getkebutuhankhususptk($pdid);
            }
        }
        $response = [];
        $response['status'] = $status;
        $response['nama_siswa'] = $nama_siswa;
        $response['nisn'] = $nisn;
        // $response['nik'] = $nik;
        $response['valnama_siswa'] = $valnama;
        $response['valnik'] = $valnik;
        $response['nomor'] = $nomor;
        $response['nik_ayah'] = $nikayah;
        $response['nama_ayah'] = $namaayah;
        // $response['tgl_lahir'] = $tgl_lahir;
        // $response['valtgl_lahir'] = $valtgl_lahir;
        $response['jenis_kelamin'] = $sex;
        $response['usia'] = $usia;
        $response['kode_wilayah'] = $kodewilayah;
        $response['valjenis_kelamin'] = $valsex;
        $response['nama_sekolah'] = $nama_sekolah;
        $response['kebutuhan_khusus_id'] = $kebutuhan_khusus_id;
        $response['kebutuhan_khusus'] = $kebutuhan_khusus;
        $csrfToken = csrf_hash();
        $response['csrf'] = $csrfToken;

        return $this->response->setJSON($response);
    }

    public function nik_siswa()
    {
        $request = \Config\Services::request();
        $npsn = $request->getVar('npsn');
        $nisn = $request->getVar('nisn');
        $jenis = $request->getVar('jenis');
        if ($jenis == 1 || $jenis == 2)
            $get_nik_siswa = $this->model_tppk->getsiswanikbynisn($npsn, $nisn);
        else
            $get_nik_siswa = $this->model_tppk->getnikbynuptk($npsn, $nisn, $jenis);
        $response = [];
        $response['kodhes'] = csrf_hash();
        if ($get_nik_siswa)
            $niksiswa = $get_nik_siswa['nik'];
        else
            $niksiswa = "-";
        $response['niksiswa'] = $niksiswa;
        return $this->response->setJSON($response);
    }

    public function get_kepsek()
    {
        $request = \Config\Services::request();
        $npsn = $request->getVar('npsn');
        $get_kepsek = $this->model_tppk->getkepsekbynpsn($npsn);
        $response = [];
        $response['kodhes'] = csrf_hash();
        $nik = "";
        $nuptk = "";
        $nama = "";
        if ($get_kepsek) {
            $nik = $get_kepsek['nik'];
            $nuptk = $get_kepsek['nuptk'];
            $nama = $get_kepsek['nama'];
        }
        $response['nikkepsek'] = $nik;
        $response['nuptkkepsek'] = $nuptk;
        $response['namakepsek'] = $nama;

        return $this->response->setJSON($response);
    }

    public function get_data_m()
    {
        $request = \Config\Services::request();
        $nik = $request->getVar('nik'); //1904014206060001 // 3578200606120004 //ptk 3578201701670001 
        $nama = $request->getVar('nama');
        $tgllahir = '01-01-1900';
        // echo var_dump($get_data_siswa);
        $kebutuhan_khusus_id = 0;
        $kebutuhan_khusus = "";
        $status = "nonaktif";
        $valnama = "-";
        $nisn = "";
        $sex = "";
        $valsex = "-";
        $nama_sekolah = "";

        $status = "aktif";
        $jk = "Laki-Laki";

        $hasilpadan = $this->padankandatakasus($nik, $nama, $tgllahir, $jk);

        $valid = strpos($hasilpadan, 'NAMA_LGKP');
        $niktaknemu = strpos($hasilpadan, 'NIK tidak terdapat di database Kependudukan');
        $niksalahformat = strpos($hasilpadan, 'NIK tidak sesuai format Dukcapil');
        $niksalahformat2 = strpos($hasilpadan, 'NIK yang dimasukan tidak sesuai format');
        if ($valid) {
            $valnik = "NIK sesuai";
            $decodedData = json_decode($hasilpadan, true);
            $valnama = $decodedData['NAMA_LGKP'];
            $valsex = $decodedData['JENIS_KLMIN'];
        } else if ($niktaknemu) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak ditemukan";
            $valsex = "-";
            $valtglahir = "-";
        } else if ($niksalahformat) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak sesuai format";
            $valsex = "-";
            $valtglahir = "-";
        } else if ($niksalahformat2) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak sesuai format";
            $valsex = "-";
            $valtglahir = "-";
        } else {
            $valnama = "Server Dukcapil tidak aktif";
            $valnik = "Server Dukcapil tidak aktif";
            $valsex = "-";
            $valtglahir = "-";
        }


        $decodedData = json_decode($hasilpadan, true);
        if (isset($decodedData['NAMA_LGKP'])) {
            $valnama = $decodedData['NAMA_LGKP'];
            $valtgl_lahir = $decodedData['TGL_LHR'];
            $valsex = $decodedData['JENIS_KLMIN'];
        }
        // echo var_dump($decodedData);

        $response = [];
        $response['status'] = $status;
        $response['nisn'] = $nisn;
        $response['valnama_siswa'] = $valnama;
        $response['valnik'] = $valnik;
        $response['jenis_kelamin'] = $sex;
        $response['valjenis_kelamin'] = $valsex;
        $response['nama_sekolah'] = $nama_sekolah;
        $response['kebutuhan_khusus_id'] = $kebutuhan_khusus_id;
        $response['kebutuhan_khusus'] = $kebutuhan_khusus;
        $csrfToken = csrf_hash();
        $response['csrf'] = $csrfToken;

        return $this->response->setJSON($response);
    }

    public function ceknpsnsekolah()
    {
        $request = \Config\Services::request();
        $npsn = $request->getVar('npsn');
        // $npsn = $this->db->escapeLikeString($npsn);
        $npsn = esc($npsn, 'html');
        // $npsn = "20613768";
        $getsekolah = $this->model_tppk->getSekolah($npsn)->getRowArray();
        // $response = [];
        // $response['nama_sekolah'] = $getsekolah['nama'];
        // // echo var_dump($getsekolah);
        return $this->response->setJSON($getsekolah);
    }

    public function ceknikortu()
    {
        $request = \Config\Services::request();
        $niksiswa = $request->getVar('niksiswa');
        $nikortu = $request->getVar('nikortu');
        $statusortu = $request->getVar('statusortu');

        $ortu = "-";
        $nama = "";
        $jk = "-";
        $valnama = "-";
        $valsex = "-";
        $disabilitasid = 0;
        $disabilitas = "";

        $getnamaortu = $this->model_tppk->getnamaortunondisabilitas($niksiswa, $nikortu, $statusortu);
        // if (!$getnamaortu)
        //     $getnamaortu = $this->model_tppk->getnamaortunondisabilitas($niksiswa, $nikortu);
        if ($getnamaortu) {
            $nikayah = $getnamaortu['nik_ayah'];
            $nikibu = $getnamaortu['nik_ibu'];
            $nikwali = $getnamaortu['nik_wali'];

            if ($nikortu == $nikayah) {
                $ortu = "Ayah";
                $nama = $getnamaortu['nama_ayah'];
                $jk = "Laki-Laki";
                $disabilitasid = 0; //$getnamaortu['kebutuhan_khusus_id_ayah'];
                $disabilitas = ""; //$getnamaortu['kebutuhan_khusus_ayah'];
            } else if ($nikortu == $nikibu) {
                $ortu = "Ibu";
                $nama = $getnamaortu['nama_ibu_kandung'];
                $jk = "Perempuan";
                $disabilitasid = 0; //$getnamaortu['kebutuhan_khusus_id_ibu'];
                $disabilitas = ""; //$getnamaortu['kebutuhan_khusus_ibu'];
            } else if ($nikortu == $nikwali) {
                $ortu = "Wali";
                $nama = $getnamaortu['nama_wali'];
                $jk = "Laki-Laki";
                $disabilitasid = 0;
                $disabilitas = "";
            }

            $tgllahir = '01-01-1900';

            $hasilpadan = $this->padankandatakasus($nikortu, $nama, $tgllahir, $jk);
            $decodedData = json_decode($hasilpadan, true);
            if (isset($decodedData['NAMA_LGKP'])) {
                $valnama = $decodedData['NAMA_LGKP'];
                $valtgl_lahir = $decodedData['TGL_LHR'];
                $valsex = $decodedData['JENIS_KLMIN'];
            }
            // echo var_dump($decodedData);
        }

        // echo "Ortu: " . $ortu . ", nama: " . $nama;
        $response = [];
        $response['ortu'] = $ortu;
        $response['nama'] = $nama;
        $response['jenis_kelamin'] = $jk;
        $response['valnama'] = $valnama;
        $response['valjenis_kelamin'] = $valsex;
        $response['disabilitas_id'] = $disabilitasid;
        $response['disabilitas'] = $disabilitas;
        $csrfToken = csrf_hash();
        $response['csrf'] = $csrfToken;
        // echo var_dump($getsekolah);
        return $this->response->setJSON($response);
    }

    public function get_ortu()
    {
        $request = \Config\Services::request();
        $jenis = $request->getVar('jenis');
        $niksiswa = $request->getVar('nik');

        $nikortu = "";
        $namaortu = "";

        $getnamaortu = $this->model_tppk->getortusiswa($niksiswa, $jenis);
        if ($getnamaortu) {
            $nikortu = $getnamaortu['nikortu'];
            $namaortu = $getnamaortu['namaortu'];
        }

        $response = [];
        $response['nikortu'] = $nikortu;
        $response['namaortu'] = $namaortu;
        $response['kodhes'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    public function ceknikmasy()
    {
        $request = \Config\Services::request();
        $nik = $request->getVar('nik_masy');
        $nama = $request->getVar('nama_masy');
        $jk = $request->getVar('jk_masy');
        $tgllahir = $request->getVar('tgl_lahir_masy');

        $valnama = "";
        $valnik = "";
        $valsex = "";
        $valtglahir = "";

        $tgllahir = '01-01-1900';

        $hasilpadan = $this->padankandatakasus($nik, $nama, $tgllahir, $jk);
        // echo var_dump($hasilpadan);
        $valid = strpos($hasilpadan, 'NAMA_LGKP');
        $niktaknemu = strpos($hasilpadan, 'NIK tidak terdapat di database Kependudukan');
        $niksalahformat = strpos($hasilpadan, 'NIK tidak sesuai format Dukcapil');
        $niksalahformat2 = strpos($hasilpadan, 'NIK yang dimasukan tidak sesuai format');
        if ($valid) {
            $valnik = "NIK sesuai";
            $decodedData = json_decode($hasilpadan, true);
            $valnama = $decodedData['NAMA_LGKP'];
            $valsex = $decodedData['JENIS_KLMIN'];
        } else if ($niktaknemu) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak ditemukan";
            $valsex = "-";
            $valtglahir = "-";
        } else if ($niksalahformat) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak sesuai format";
            $valsex = "-";
            $valtglahir = "-";
        } else if ($niksalahformat2) {
            $valnama = "Nama tidak sesuai NIK";
            $valnik = "NIK tidak sesuai format";
            $valsex = "-";
            $valtglahir = "-";
        } else {
            $valnama = "Server Dukcapil tidak aktif";
            $valnik = "Server Dukcapil tidak aktif";
            $valsex = "-";
            $valtglahir = "-";
        }

        $response = [];
        $response['valnama'] = $valnama;
        $response['valnik'] = $valnik;
        $response['valjenis_kelamin'] = $valsex;
        $response['valtgl_lahir'] = $valtglahir;
        $response['valtgl_lahir'] = $valtglahir;
        $csrfToken = csrf_hash();
        $response['csrf'] = $csrfToken;

        // echo var_dump($getsekolah);
        return $this->response->setJSON($response);
    }

    public function cari_sekolah()
    {
        $request = \Config\Services::request();
        $npsn = session()->get('npsn_user');
        // $npsn = $this->db->escapeLikeString($npsn);
        $npsn = esc($npsn, 'html');
        $getsekolah = $this->model_tppk->getSekolah($npsn)->getRowArray();
        if ($getsekolah)
            $kode_wilayahsaya = $getsekolah['kode_wilayah'];
        else
            $kode_wilayahsaya = '000000';
        $nama_sekolah = $request->getVar('nama_sekolah');

        $hasil = $this->model_tppk->carinamasekolah($nama_sekolah, $kode_wilayahsaya);
        // $hasil[0]['npsn'] = '88010101';
        // $hasil[0]['nama_sekolah'] = 'Sekolah Satu';
        // $hasil[0]['kecamatan'] = "Kec. Baru";
        // $hasil[0]['kota'] = 'Kota BCD';
        // $hasil[0]['provinsi'] = "Prov. ABC";
        // $hasil[0]['status_sekolah'] = 1;
        // $hasil[1]['npsn'] = '88010102';
        // $hasil[1]['nama_sekolah'] = 'Sekolah Dua';
        // $hasil[1]['kecamatan'] = "Kec. Baru";
        // $hasil[1]['kota'] = 'Kota BCD';
        // $hasil[1]['provinsi'] = "Prov. ABC";
        // $hasil[1]['status_sekolah'] = 1;
        // $hasil[2]['npsn'] = '88020103';
        // $hasil[2]['nama_sekolah'] = 'Sekolah Tiga';
        // $hasil[2]['kota'] = 'Kota DEF';
        // $hasil[2]['kecamatan'] = "Kec. Lama";
        // $hasil[2]['provinsi'] = "Prov. ABC";
        // $hasil[2]['status_sekolah'] = 1;
        // $hasil[3]['npsn'] = '88020104';
        // $hasil[3]['nama_sekolah'] = 'Sekolah Empat';
        // $hasil[3]['kota'] = 'Kota DEF';
        // $hasil[3]['kecamatan'] = "Kec. Lama";
        // $hasil[3]['provinsi'] = "Prov. ABC";
        // $hasil[3]['status_sekolah'] = 1;
        // $hasil[4]['npsn'] = '88030101';
        // $hasil[4]['nama_sekolah'] = 'Sekolah Ahad';
        // $hasil[4]['kota'] = 'Kab. CBA';
        // $hasil[4]['kecamatan'] = "Kec. Pagi";
        // $hasil[4]['provinsi'] = "Prov. ABC";
        // $hasil[4]['status_sekolah'] = 1;
        return $this->response->setJSON($hasil);
    }

    public function simpan_kasus()
    {
        // die();
        $csrfName = csrf_token();

        // if ($this->request->getPost($csrfName)) {
        $request = \Config\Services::request();

        $posnpsn = $request->getPost('ceknpsn');
        $poskodewilayah = $request->getPost('cekkodewilayah');
        $posinstansi = $request->getPost('cekinstansi');
        if ($posinstansi == "sekolah") {
            $npsn = $posnpsn;
            $infoSekolah = $this->model_tppk->getInfoSekolah($npsn);
            $kodewilayah = $infoSekolah['kode_wilayah'];
        } else {
            $npsn = $posnpsn;
            $kodewilayah = $poskodewilayah;
        }
        $npsn = session()->get('npsn_user');
        $sebagai = session()->get('sebagai');
        if ($sebagai == "operatorsatgas")
            $npsn = trim($kodewilayah);

        $noreg = $request->getPost('xnoreg');
        $tgl_lapor = $request->getPost('xtgl_lapor');
        $tgl_kasus = $request->getPost('xtgl_kasus');
        $sts_kasus = $request->getPost('xsts_kasus');
        $alasan_dihentikan = $request->getPost('alasan_dihentikan');
        $bentuk_kekerasan = $request->getPost('bentuk_kekerasan');
        $cakupan_kekerasan = $request->getPost('cakupan_kekerasan');
        $kronologi = $request->getPost('kronologi');

        $datakorban = $request->getPost('datakorban');
        $datapelaku = $request->getPost('datapelaku');

        $tglnya2 = explode("/", $tgl_kasus);
        $tgl_kasusok = $tglnya2[2] . "-" . $tglnya2[1] . "-" . $tglnya2[0] . " 00:00:00";


        $data = [];
        $data['nomor_register'] = $noreg;
        $data['npsn'] = $npsn;
        $data['kode_wilayah'] = $kodewilayah;
        $data['tanggal_kejadian'] = $tgl_kasusok;
        $data['last_update'] = date('Y-m-d H:i:s');
        $this->model_tppk->save_kasus($data);

        $getkasus = $this->model_tppk->get_lastkasus($npsn);
        $kasus_id = $getkasus['kasus_id'];

        $tglnya = explode("/", $tgl_lapor);
        $tgl_laporok = $tglnya[2] . "-" . $tglnya[1] . "-" . $tglnya[0] . " 00:00:00";

        $data2 = [];
        $data2['kasus_id'] = $kasus_id;
        $data2['tanggal_pelaporan'] = $tgl_laporok;
        $data2['tanggal_kejadian'] = $tgl_kasusok;
        $data2['status_kasus'] = $sts_kasus;
        $data2['alasan_dihentikan'] = $alasan_dihentikan;
        $data2['bentuk_kekerasan'] = $bentuk_kekerasan;
        $data2['cakupan_kekerasan'] = $cakupan_kekerasan;
        $data2['kronologi'] = $kronologi;
        $data2['last_update'] = date('Y-m-d H:i:s');
        $this->model_tppk->save_pelaporan($data2);

        $getpelaporan = $this->model_tppk->get_lastpelaporan($kasus_id);
        $pelaporan_id = $getpelaporan['pelaporan_id'];

        $batch_datakorban = array();
        foreach ($datakorban as $korban) {

            $tglair = $korban['tgl_lahir'];
            if ($tglair) {
                $tglair2 = explode("/", $tglair);
                if (count($tglair2) == 3 && checkdate($tglair2[1], $tglair2[0], $tglair2[2])) {
                    $tgl_lairok = $tglair2[2] . "-" . $tglair2[1] . "-" . $tglair2[0] . " 00:00:00";
                } else {
                    $tgl_lairok = NULL;
                }
            } else {
                $tgl_lairok = NULL;
            }

            if ($korban['nama2'] == "")
                $korban['statusortu'] = "";
            $data = array(
                'kasus_id' => $kasus_id,
                'pelaporan_id' => $pelaporan_id,
                'sebagai' => 1,
                'urutan' => $korban['urutan'],
                'status_korban_pelaku' => $korban['status'],
                'nik' => $korban['nik'],
                'nikpdptk' => $korban['nikpdptk'],
                'npsn' => $korban['npsn'],
                'nisn' => $korban['nisn'],
                'nama' => $korban['nama'],
                'ver_nama' => $korban['ver_nama'],
                'ver_nik' => $korban['ver_nik'],
                'usia' => $korban['usia'],
                'tanggal_lahir' => $tgl_lairok,
                'alamat' => $korban['alamat'],
                'kode_wilayah' => $korban['kodewilayah'],
                'jenis_kelamin' => $korban['jenis_kelamin'],
                'nama_instansi' => $korban['nama_sekolah'],
                'disabilitas' => $korban['disabilitas'],
                'kebutuhan_khusus_id' => $korban['inputdisabilitas'],
                'last_update' => date('Y-m-d H:i:s')
            );
            if ($korban['status'] == 2) {
                $data['nama2'] = $korban['nama2'];
                $data['status_ortu'] = $korban['statusortu'];
            } else {
                $data['nama2'] = "";
                $data['status_ortu'] = "";
            }
            $batch_datakorban[] = $data;
        }
        $this->model_tppk->save_tbkorban($batch_datakorban);

        if ($datapelaku != null) {
            $batch_datapelaku = array();
            foreach ($datapelaku as $pelaku) {

                $tglair = $pelaku['tgl_lahir'];
                if ($tglair) {
                    $tglair2 = explode("/", $tglair);
                    if (count($tglair2) == 3 && checkdate($tglair2[1], $tglair2[0], $tglair2[2])) {
                        $tgl_lairok = $tglair2[2] . "-" . $tglair2[1] . "-" . $tglair2[0] . " 00:00:00";
                    } else {
                        $tgl_lairok = NULL;
                    }
                } else {
                    $tgl_lairok = NULL;
                }

                if ($pelaku['nama2'] == "")
                    $pelaku['statusortu'] = "";

                if ($sts_kasus == 1)
                    $sebagainya = 2;
                else
                    $sebagainya = 3;
                $data = array(
                    'kasus_id' => $kasus_id,
                    'pelaporan_id' => $pelaporan_id,
                    'sebagai' => $sebagainya,
                    'urutan' => $pelaku['urutan'],
                    'status_korban_pelaku' => $pelaku['status'],
                    'nik' => $pelaku['nik'],
                    'nikpdptk' => $pelaku['nikpdptk'],
                    'npsn' => $pelaku['npsn'],
                    'nisn' => $pelaku['nisn'],
                    'nama' => $pelaku['nama'],
                    'ver_nama' => $pelaku['ver_nama'],
                    'ver_nik' => $pelaku['ver_nik'],
                    'usia' => $pelaku['usia'],
                    'tanggal_lahir' => $tgl_lairok,
                    'alamat' => $pelaku['alamat'],
                    'kode_wilayah' => $pelaku['kodewilayah'],
                    'jenis_kelamin' => $pelaku['jenis_kelamin'],
                    'nama_instansi' => $pelaku['nama_sekolah'],
                    'disabilitas' => $pelaku['disabilitas'],
                    'kebutuhan_khusus_id' => $pelaku['inputdisabilitas'],
                    'last_update' => date('Y-m-d H:i:s')
                );
                if ($pelaku['status'] == 2) {
                    $data['nama2'] = $pelaku['nama2'];
                    $data['status_ortu'] = $pelaku['statusortu'];
                } else {
                    $data['nama2'] = "";
                    $data['status_ortu'] = "";
                }
                $batch_datapelaku[] = $data;
            }

            $this->model_tppk->save_tbkorban($batch_datapelaku);
        }

        return true;
    }

    public function get_daf_kota()
    {
        $request = \Config\Services::request();
        $prov = $request->getVar('kodeprov');
        $kota = $this->model_tppk->get_daf_kota($prov);

        return $this->response->setJSON($kota);
    }

    public function get_daf_kecamatan()
    {
        $request = \Config\Services::request();
        $kota = $request->getVar('kodekota');
        $kecamatan = $this->model_tppk->get_daf_kecamatan($kota);

        return $this->response->setJSON($kecamatan);
    }

    public function get_daf_desa()
    {
        $request = \Config\Services::request();
        $kecamatan = $request->getVar('kodekecamatan');
        $desa = $this->model_tppk->get_daf_desa($kecamatan);

        return $this->response->setJSON($desa);
    }

    public function daftarsekolahnontppk()
    {
        $csrfName = csrf_token();
        $userlogin = session()->get('loggedIn');
        // if (!$userlogin) {
        //     return redirect()->to('/home');
        // }

        $npsn = session()->get('npsn_user');
        $instansiid = session()->get('jenis_instansi_id');
        $instansiid = 1;

        // if ($instansiid > 3 && $instansiid != 4 && $instansiid != 18)
        //     return redirect()->to('/home');

        $request = \Config\Services::request();
        $jenjang = "PAUD";
        if ($request->getVar('jenjang'))
            $jenjang = $request->getVar('jenjang');
        $data['jenjang'] = $jenjang;

        $propinsi = "010000";
        $kodewilayah = "016400";


        if ($instansiid == 1) {
            if ($request->getVar('kode_wilayah'))
                $kodewilayah = $request->getVar('kode_wilayah');
            $propinsi = str_pad(substr($kodewilayah, 0, 2), 6, "0");
        } else {
            $kodewilayah = session()->get('wilayah_akses');
        }

        $data['kode_wilayah'] = $kodewilayah;
        $data['provinsi'] = $propinsi;

        // $username = session()->get('username');

        // if ($username == "hardianto@kemdikbud.go.id") {
        //     // $getdafsekolahnontppk = $this->model_tppk->getRekapTppkData($instansiid, $kodewilayah, $jenjang);
        //     $getdafsekolahnontppk = $this->model_tppk->daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang, 10, 10);
        //     // echo "HMM";
        //     // die();
        // } else {
        //     $getdafsekolahnontppk = $this->model_tppk->daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang);
        // }
        // $data['daf_sekolah_non_tppk'] = $getdafsekolahnontppk;
        if ($instansiid == 1) {
            $namawilayah = "INDONESIA";
            $data['daftar_provinsi'] = $this->model_tppk->get_daf_provinsi();
            $data['daftar_kota'] = $this->model_tppk->get_daf_kota($propinsi);
        } else {
            $getnamawilayah = $this->model_tppk->getJudulProp($instansiid, $kodewilayah);
            $namawilayah = $getnamawilayah['nama'];
        }
        $data['namawilayah'] = $namawilayah;
        $data['instansiid'] = $instansiid;
        if (date("n") > 6)
            $tahunajaran = date("Y") . "/" . (date("Y") + 1);
        else
            $tahunajaran = (date("Y") - 1) . "/" . (date("Y"));
        $data['tahunajaran'] = $tahunajaran;

        return view('tppk/daftarsekolah_nontppk', $data);
    }

    public function ajaxGetDaftarNonTPPK($jenjang, $kodewilayah)
    {
        $csrfName = csrf_token();

        $request = \Config\Services::request();
        $page = $request->getVar('start') / $request->getVar('length') + 1;
        // $page = 1;

        $searchValue = "";
        if ($request->getVar('search')) {
            $searchValue = $request->getVar('search')['value'];
        }

        $orderkolom = -1;
        $orderurut = -1;
        if ($request->getVar('order')) {
            $order = $request->getVar('order')[0];
            $orderkolom = $order['column'];
            $orderurut = $order['dir'];
        }
        // $instansiid = session()->get('jenis_instansi_id');
        $instansiid = 1;

        // $jenjang = "PAUD";
        $data['jenjang'] = $jenjang;

        $propinsi = "010000";
        // $kodewilayah = "016400";

        $totalSekolah = $this->model_tppk->daf_sekolah_nontppk_count($instansiid, $kodewilayah, $jenjang, $searchValue);
        $daftarSekolah = $this->model_tppk->daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang, $request->getVar('start'), $request->getVar('length'), $searchValue, $orderkolom, $orderurut);
        $totalSekolah = $totalSekolah[0]['total'];

        // echo var_dump($daftarSekolah);
        // die();

        //// AMBIL DATA DENGAN SEKOLAH TIKDA AKTIF DARI DATABASE LAIN
        $gabungSekolah = array();
        if ($totalSekolah > 0) {
            $daf_npsn = array_filter(array_column($daftarSekolah, 'sekolah_id'));
            $dafsekolahtakaktif = $this->model_tppk->getsekolahtidakaktif($daf_npsn);
            foreach ($daftarSekolah as $sekolahA) {
                $kodeSemesterTidakAktif = 0;
                foreach ($dafsekolahtakaktif as $sekolahB) {
                    if ($sekolahA['sekolah_id'] == $sekolahB['sekolah_id']) {
                        $absenupdate = $sekolahB['kode_semester_tidak_aktif'];
                        if ((date("n") <= 6 && $absenupdate >= 1) || (date("n") > 6 && $absenupdate >= 2)) {
                            $sekolahB['kode_semester_tidak_aktif'] = "<span style='color:red'>tidak update</span>";
                        } else $sekolahB['kode_semester_tidak_aktif'] = "";
                        $sekolahGabung = array_merge($sekolahA, $sekolahB);
                        $gabungSekolah[] = $sekolahGabung;
                        $kodeSemesterTidakAktif = 99;
                    }
                }
                if ($kodeSemesterTidakAktif === 0) {
                    $sekolahA['kode_semester_tidak_aktif'] = "";
                    $gabungSekolah[] = $sekolahA;
                }
            }
        } else {
            $gabungSekolah = [];
        }
        //-------------------------------------------------------------------------

        $response = [
            'draw' => $request->getVar('draw'),
            'recordsTotal' => $totalSekolah,
            'recordsFiltered' => $totalSekolah,
            'data' => $daftarSekolah,
        ];

        return $this->response->setJSON($response);
    }

    public function ekspor()
    {
        $userlogin = session()->get('loggedIn');
        // if (!$userlogin) {
        //     return redirect()->to('/home');
        // }

        $npsn = session()->get('npsn_user');
        $instansiid = session()->get('jenis_instansi_id');

        $instansiid = 1;

        $request = \Config\Services::request();
        $jenjang = "SMK";
        if ($request->getVar('jenjang'))
            $jenjang = $request->getVar('jenjang');
        $data['jenjang'] = $jenjang;

        $propinsi = "010000";
        $kodewilayah = "022100";

        if ($instansiid == 1) {
            if ($request->getVar('kode_wilayah'))
                $kodewilayah = $request->getVar('kode_wilayah');
            $propinsi = str_pad(substr($kodewilayah, 0, 2), 6, "0");
        } else {
            $kodewilayah = session()->get('wilayah_akses');
        }

        $data['kode_wilayah'] = $kodewilayah;
        $data['provinsi'] = $propinsi;

        // $totalSekolah = $this->model_tppk->total_daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang);
        $getdafsekolahnontppk = $this->model_tppk->daf_sekolah_nontppkok($instansiid, $kodewilayah, $jenjang);
        $totalSekolah = sizeof($getdafsekolahnontppk);


        // //// AMBIL DATA DENGAN SEKOLAH TIKDA AKTIF DARI DATABASE LAIN
        $gabungSekolah = array();
        if ($totalSekolah > 0) {
            $daf_npsn = array_filter(array_column($getdafsekolahnontppk, 'sekolah_id'));
            $dafsekolahtakaktif = $this->model_tppk->getsekolahtidakaktif($daf_npsn);
            $gabungSekolah = array();
            foreach ($getdafsekolahnontppk as $sekolahA) {
                $kodeSemesterTidakAktif = 0;
                foreach ($dafsekolahtakaktif as $sekolahB) {
                    if ($sekolahA['sekolah_id'] == $sekolahB['sekolah_id']) {
                        $absenupdate = $sekolahB['kode_semester_tidak_aktif'];
                        if ((date("n") <= 6 && $absenupdate >= 1) || (date("n") > 6 && $absenupdate >= 2)) {
                            $sekolahB['kode_semester_tidak_aktif'] = "tidak update";
                        } else $sekolahB['kode_semester_tidak_aktif'] = "";
                        $sekolahGabung = array_merge($sekolahA, $sekolahB);
                        $gabungSekolah[] = $sekolahGabung;
                        $kodeSemesterTidakAktif = 99;
                    }
                }
                if ($kodeSemesterTidakAktif === 0) {
                    $sekolahA['kode_semester_tidak_aktif'] = "";
                    $gabungSekolah[] = $sekolahA;
                }
            }
        }
        //-------------------------------------------------------------------------

        $data['daf_sekolah_non_tppk'] = $getdafsekolahnontppk;
        // echo var_dump($getdafsekolahnontppk);
        // die();
        if ($instansiid == 1) {
            // $namawilayah = "INDONESIA";
            $data['daftar_provinsi'] = $this->model_tppk->get_daf_provinsi();
            $data['daftar_kota'] = $this->model_tppk->get_daf_kota($propinsi);
            $getnamawilayah = $this->model_tppk->getJudulProp($instansiid, $kodewilayah);
            $namawilayah = $getnamawilayah['nama'];
        } else {
            $getnamawilayah = $this->model_tppk->getJudulProp($instansiid, $kodewilayah);
            $namawilayah = $getnamawilayah['nama'];
        }
        $data['namawilayah'] = $namawilayah;
        $data['instansiid'] = $instansiid;
        $data['jenjang'] = $jenjang;
        $data['tgldownload'] = date('d/m/Y H:i:s');
        $data['tglfile'] = date('d-m-Y');
        return view('tppk/ekspor', $data);
        exit;
    }

    public function daftar_anggota_tppk()
    {
        $asallogin = session()->get('asallogin');

        if ($asallogin != "eksternal") {
            session()->set('tes', true);
            return view('login_eksternal');
            // return redirect()->to('https://dev-sso.datadik.kemdikbud.go.id/app/60B05B81-79A8-46D0-9458-7B10E5B7606C');
        } else {
            $valid = false;

            $sekolah_id = session()->get('sekolah_id');
            $statustppk = session()->get('statustppk');

            if ($statustppk == "ketua" || $statustppk == "koordinator")
                $valid = true;
            else
                echo "Untuk memilih anggota hanya khusus Ketua saja";

            if ($valid) {
                $datasekolah = $this->model_tppk->getSekolahuId($sekolah_id);
                $daftaranggota = $this->model_tppk->getDaftarAnggota($sekolah_id);
                $getanggota = $daftaranggota->getResultArray();
                $data['daftaranggota'] = $getanggota;
                $data['namasekolah'] = $datasekolah;
                return view('tppk/daftaranggotatppk', $data);
            }
        }
    }

    public function simpan_login_anggota()
    {
        $request = \Config\Services::request();
        $ptk_id = $request->getPost('selectedValue');
        $sk_tugas = $request->getPost('sktugas');

        $sekolah_id = session()->get('sekolah_id');
        $statustppk = session()->get('statustppk');

        if ($statustppk == "ketua" || $statustppk == "koordinator") {
            $this->model_tppk->simpan_login_anggota($sekolah_id, $sk_tugas, $ptk_id);
            return "success";
        }

        return "failed";
    }

    public function unggah_sk()
    {
        $ceklogin = session()->get("loggedIn");
        if ($ceklogin) {
            return view("unggah_sk_op_satgas");
        } else {
            return redirect()->to("/");
        }
    }

    public function unggah_sk_op_satgas()
    {
        $request = \Config\Services::request();
        $filesk = $request->getFile('file');

        $tipeoke = false;
        $tipeFile = $filesk->getMimeType();
        $allowedMimeTypes = ['application/pdf'];
        if (in_array($tipeFile, $allowedMimeTypes)) {
            $tipeoke = true;
        }

        if ($filesk->isValid() && $tipeoke == true) {

            $pengguna_id = strtolower(session()->get("ptk_id"));
            $files = glob('public/sk_op_satgas/' . 'sk_' . $pengguna_id . '_*');

            foreach ($files as $file) {
                //unlink($file);
            }

            $filesk->move('public/sk_op_satgas/', 'sk' . $pengguna_id . '.pdf');

            if (file_exists('public/sk_op_satgas/sk' . $pengguna_id . '.pdf')) {

                $updatestatussk = $this->model_tppk->updatestatussk($pengguna_id);

                return redirect()->to("/status_approval");
            }
        } else {
            return redirect()->back()->with('error', 'Unggahan gagal, pastikan file sesuai dengan ketentuan.');
        }
    }

    public function phpinfo()
    {
        echo phpinfo();
    }

    public function tes()
    {
        $password = "12345";
        $hashedPassword = hash('sha256', $password);
        echo $hashedPassword;
    }
}
