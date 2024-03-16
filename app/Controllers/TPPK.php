<?php

namespace App\Controllers;

use App\Models\M_tppk;

class TPPK extends BaseController
{
    function __construct()
    {
        $this->model_tppk = new M_tppk();
    }

    public function index()
    {
        // return view('beranda');
    }

    public function cari_npsn($npsn)
    {
        $kode = '000000';
        $level = 3;

        $data['jenjang'] = "semua";
        $data['bentuk'] = "semua";
        $data['status'] = "semua";
        $data['pilihan'] = 1;
        $data['npsn'] = $npsn;

        $data['kode'] = $kode;
        $data['level'] = $level;

        $data['namapilihan2'] = "Provinsi";
        $data['namalevel1'] = "Provinsi";
        $data['namalevel2'] = "Provinsi";
        $data['namapilihan'] = "Provinsi";
        $npsn = esc($npsn, 'html');
        $query = $this->model_tppk->getTotalTPPK_npsn($npsn);
        $data['datanas'] = $query->getResultArray();
        return view('tppk/data_tppksekolah_npsn', $data);
    }

    public function cari_sekolah($nama_sekolah)
    {
        $kode = '000000';
        $level = 3;

        $data['jenjang'] = "semua";
        $data['bentuk'] = "semua";
        $data['status'] = "semua";
        $data['pilihan'] = 1;
        $data['npsn'] = "";

        $data['kode'] = $kode;
        $data['level'] = $level;

        $data['namapilihan2'] = "Provinsi";
        $data['namalevel1'] = "Provinsi";
        $data['namalevel2'] = "Provinsi";
        $data['namapilihan'] = "Provinsi";
        $nama_sekolah = esc($nama_sekolah, 'html');
        $hasil = $this->model_tppk->carinamasekolahall($nama_sekolah);
        $data['datanas'] = $hasil;
        return view('tppk/data_tppksekolah_npsn', $data);

        return $this->response->setJSON($hasil);
    }

    public function wilayah($kode = '000000', $level = 0)
    {
        if (session()->has('pilihan'))
            $pilihan = session()->get('pilihan');
        else
            $pilihan = 1;

        $jenjang = isset($_GET['jenjang']) ? $_GET['jenjang'] : "semua";
        $bentuk = isset($_GET['bentuk']) ? $_GET['bentuk'] : "semua";
        $status = isset($_GET['status']) ? $_GET['status'] : "semua";

        $data['jenjang'] = $jenjang;
        $data['bentuk'] = $bentuk;
        $data['status'] = $status;
        $data['pilihan'] = $pilihan;

        $data['kode'] = $kode;
        $data['level'] = $level;

        $kode2 = $kode;
        $data['namapilihan2'] = "Provinsi";

        if ($level == 0) {
            $data['namapilihan'] = "Provinsi";
            $data['namalevel1'] = "";
            $data['namalevel2'] = "";
            $data['namalevel3'] = "";
            $data['namalevel4'] = "";
        } else {

            $namapilihan = $this->model_tppk->getNamaPilihan($kode);
            $resultquery = $namapilihan->getResult();

            if ($level >= 1) {
                $str = substr($kode, 0, 2);
            }
            $kode2 = str_pad($str, 6, "0");
            $namapilihan2 = $this->model_tppk->getNamaPilihan($kode2);
            $resultquery2 = $namapilihan2->getResult();

            $data['namapilihan'] = strToUpper($resultquery[0]->nama);
            $data['namapilihan2'] = strToUpper($resultquery2[0]->nama);

            $namalevel1 = $this->model_tppk->getNamaPilihan(substr($kode, 0, 2) . "0000");
            $result1 = $namalevel1->getResult();
            $data['namalevel1'] = $result1[0]->nama;
            $namalevel2 = $this->model_tppk->getNamaPilihan(substr($kode, 0, 4) . "00");
            $result2 = $namalevel2->getResult();
            $data['namalevel2'] = $result2[0]->nama;
            $namalevel3 = $this->model_tppk->getNamaPilihan(substr($kode, 0, 6));
            $result3 = $namalevel3->getResult();
            $data['namalevel3'] = $result3[0]->nama;
            $namalevel4 = $this->model_tppk->getNamaPilihan(substr($kode, 0, 8));
            $result4 = $namalevel4->getResult();
            $data['namalevel4'] = $result4[0]->nama;
        }

        $data['dafbentuk'] = $this->getBentukKementerian($jenjang, 1);

        if ($level < 3) {
            $query = $this->model_tppk->getTotalTPPK($kode, $level, $jenjang, $bentuk, $status);
            $data['datanas'] = $query->getResultArray();
            $level2 = $level;
            if ($level >= 1)
                $level2 = 1;
            $query2 = $this->model_tppk->getTotalSatgas($kode2, $level2);
            $data['datanas2'] = $query2->getResultArray();
            // echo var_dump($data['datanas2']);
            // die();
            return view('tppk/data_tppk', $data);
        } else if ($level == 3) {
            $query = $this->model_tppk->getTotalTPPK($kode, $level, $jenjang, $bentuk, $status);
            $data['datanas'] = $query->getResultArray();
            // dd($data['datanas']);
            $level2 = $level;
            if ($level >= 1)
                $level2 = 1;
            $query2 = $this->model_tppk->getTotalSatgas($kode2, $level2);
            $data['datanas2'] = $query2->getResultArray();
            // echo var_dump($data['datanas2']);
            // die();
            return view('tppk/data_tppksekolah', $data);
        } else {
            $query = $this->model_tppk->getDaftarTPPK($kode, $level);
            $data['datanas'] = $query->getResultArray();
            return view('tppk/daftarsekolah_tppk', $data);
        }
    }

    public function anggota($npsn, $opsi = null)
    {
        $query1 = $this->model_tppk->getSekolah($npsn);
        $hasil = $query1->getRowArray();

        $tombolback = isset($_GET['k']) ? $_GET['k'] : "1";

        $data['npsn'] = $npsn;
        $data['tombolback'] = $tombolback;
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
        // echo var_dump($dafanggota);

        $data['daftaranggota'] = $dafanggota;
        $queryop2 = $this->model_tppk->getOperator($idinstansi);
        $data['operator'] = $queryop2;
        $getsk = $this->model_tppk->getSKSekolah($npsn);
        $skada = true;
        if (!$getsk) {
            $getsk = ['status_sk' => 0];
            $skada = false;
        }
        $data['datask'] = $getsk;
        $data['instansiid'] = $idinstansi;
        $data['sk_tugas'] = "-";
        $data['tgl_sk'] = "-";
        $data['filepdf'] = "-";
        $data['tanggalberakhir'] = "-";
        $data['sudah_upload'] = false;
        $data['kadaluwarsa'] = true;
        $data['lebih2tahun'] = false;

        ////////////////////cek file sk
        $linknomorsk = "-";
        if ($dafanggota) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['nomor_sk']);
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "") {
                $data['sudah_upload'] = true;
                $data['filepdf'] = $namafilesk;
            }

            if ($namafilesk != "" && session()->get('loggedIn') && $dafanggota) {
                $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $dafanggota[0]['nomor_sk'] . ' <span style="font-weight:bold; font-style:italic">[unduh]</span></a>';
            } else {
                if ($dafanggota > 1)
                    $linknomorsk = $dafanggota[0]['nomor_sk'];
                else {
                    $linknomorsk = "-";
                }
            }
            $data['sk_tugas'] = $dafanggota[0]['nomor_sk'];
            $data['tgl_sk'] = $dafanggota[0]['tmt_sk_tugas'];
            $tgl_skakhir = $dafanggota[0]['tst_sk_tugas'];

            $batassk2tahun = date('Y-m-d', strtotime($data['tgl_sk'] . ' +2 years'));

            if ($dafanggota[0]['tst_sk_tugas'] == null)
                $data['tanggalberakhir'] = date('Y-m-d', strtotime($data['tgl_sk'] . ' +2 years'));
            else {
                $data['tanggalberakhir'] = $tgl_skakhir;
                if ($tgl_skakhir > $batassk2tahun) {
                    $data['lebih2tahun'] = true;
                }
            }

            if ($data['tanggalberakhir'] > date('Y-m-d')) {
                $data['kadaluwarsa'] = false;
            }

            ////////////////////////// CEK SK DI TABEL ADA ATAU TIDAK //////////////////
            if ($data['sudah_upload'] && $skada == false) {

                $tanggalsk = $dafanggota[0]['tmt_sk_tugas'];
                $sktugas = $dafanggota[0]['sk_tugas'];
                $tanggalsknya = substr($tanggalsk, 8, 2) . "-" . substr($tanggalsk, 5, 2) . "-" . substr($tanggalsk, 0, 4);
                $datatabel = array();
                $datatabel['sekolah_id'] = $idinstansi;
                $datatabel['npsn'] = $npsn;
                $nomorsk = str_replace("'", "`", $sktugas);
                $nomorsk = str_replace('"', '`', $nomorsk);
                $datatabel['nomor_sk'] = $nomorsk;
                $datatabel['status_sk'] = 1;
                $datatabel['tanggal_sk'] = $tanggalsk;
                $hasil = $this->model_tppk->input_data_sk($datatabel);
                if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                    // echo $hasil . "-<br>";
                    // echo var_dump($datatabel);
                }
            }
        }

        $approver = false;
        $jenisinstansiid = session()->get('jenis_instansi_id');
        if ($opsi == "validasi" && ($jenisinstansiid == 2 || $jenisinstansiid == 3) && $data['sudah_upload']) {
            $approver = true;
        }
        $data['approver'] = $approver;

        $data['linknomorsk'] = $linknomorsk;
        $data['daftar_residu'] = $this->model_tppk->getResiduSekolah($npsn);

        $username = session()->get('username');
        if ($data['sudah_upload'] == true && $data['daftar_residu']['residu_upload_sk'] == 1) {
            $this->clear_residu_upload_sk($npsn);
            $data['daftar_residu'] = $this->model_tppk->getResiduSekolah($npsn);
        }



        // dd($data['daftar_residu']);

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


        return view('tppk/daftaranggota', $data);
    }

    public function cekresidu($npsn)
    {
        $query1 = $this->model_tppk->getSekolah($npsn);
        $hasil = $query1->getRowArray();

        $data['npsn'] = $npsn;
        $data['namasekolah'] = $hasil;

        $idinstansi = $hasil['instansi_id'];
        $query2 = $this->model_tppk->getDaftarAnggota($idinstansi);
        $dafanggota = $query2->getResultArray();

        echo sizeof($dafanggota) . " anggota<br>";

        if ($dafanggota) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['sk_tugas']);
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);
        }

        echo "Nama file SK:";
        if ($namafilesk != "")
            echo $namafilesk;
        echo " : ....";

        $daftar_residu = $this->model_tppk->getResiduSekolah($npsn);
        echo "<br><pre>";
        echo var_dump($daftar_residu);
        echo "</pre>";
    }

    private function clear_residu_upload_sk($npsn)
    {
        $getSKSekolah = $this->model_tppk->getResiduSekolah($npsn);

        if ($getSKSekolah['residu_kepsek'] == 0 && $getSKSekolah['residu_guru'] == 0 && $getSKSekolah['residu_komite'] == 0 && $getSKSekolah['residu_siswa'] == 0 && $getSKSekolah['residu_ganjil'] == 0 && $getSKSekolah['residu_upload_sk'] == 1) {
            $data = [
                'residu_upload_sk' => 0,
                'residu' => 0,
            ];
        } else {
            $data = [
                'residu_upload_sk' => 0,
                'residu' => 9,
            ];
        }

        $this->model_tppk->updateResiduSekolah($data, $npsn);
    }

    public function anggota2($kodewilayah)
    {
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

        // echo var_dump($getsk);
        $tgl_sekarang = date("Y-m-d");
        $tmt_sk = $tgl_sekarang;
        $batassk2tahun = $tgl_sekarang;
        if ($getsk) {
            $tmt_sk = $getsk['tanggal_sk'];
            $batassk2tahun = date('Y-m-d', strtotime($tmt_sk . ' +4 years'));
        }

        $kadaluwarsa = false;
        if ($tgl_sekarang > $batassk2tahun) {
            $kadaluwarsa = true;
        }
        $data['kadaluwarsa'] = $kadaluwarsa;

        $dafanggota = [];

        if ($getsk) {
            $dafanggota = $this->model_tppk->getAnggotaProv($getsk['sk_id']);
        }
        $data['daftaranggota'] = $dafanggota;
        // echo $getsk['sk_id'];
        // echo var_dump($dafanggota);

        ////////////////////cek file sk
        $linknomorsk = "-";
        if ($dafanggota) {
            $adasatgas = 1;
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $dafanggota[0]['nomor_sk']);
            $namafiletanpaekstensi = "sk_" . trim($kodewilayah) . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "" && session()->get('loggedIn') && $dafanggota) {
                $fileUrl = base_url('inputdata/download_sk/' . $namafilesk);
                $linknomorsk = '<a href="' . $fileUrl . '" target="_blank">' . $dafanggota[0]['nomor_sk'] . '</a>';
            } else {
                if ($dafanggota > 1)
                    $linknomorsk = $dafanggota[0]['nomor_sk'];
                else {
                    $linknomorsk = "-";
                }
            }
        } else {
            $adasatgas = 0;
        }

        $data['linknomorsk'] = $linknomorsk;
        $data['kodewilayah'] = $kodewilayah;
        $data['adasatgas'] = $adasatgas;

        return view('tppk/daftaranggota2', $data);
    }

    public function getBentukKementerian($jenjang = null, $opsi = null)
    {
        $jenjang = strtolower($jenjang);
        $daftarbentukkementerian = array();

        if ($jenjang == "paud")
            $daftarbentukkementerian = array('TK', 'KB', 'TPA', 'SPS', 'SPK KB', 'SPK PG', 'SPK TK');
        else if ($jenjang == "dikdas")
            $daftarbentukkementerian = array('SD', 'SMP', 'SPK SD', 'SPK SMP');
        else if ($jenjang == "dikmen")
            $daftarbentukkementerian = array('SMA', 'SMK', 'SLB', 'SPK SMA');
        else if ($jenjang == "dikmas")
            $daftarbentukkementerian = array('PKBM', 'SKB');

        if ($opsi == null)
            echo json_encode($daftarbentukkementerian);
        return $daftarbentukkementerian;
    }

    public function cekfilesk($namafiletanpaekstensi)
    {
        // $folderPath = WRITEPATH . 'uploads/';
        $folderPath = './public/uploads/';
        $fileName = $namafiletanpaekstensi;

        $extensions = ['jpg', 'jpeg', 'png', 'pdf'];

        $found = false;
        $ekstensi = "";
        foreach ($extensions as $extension) {
            $filePath = $folderPath . $fileName . '.' . $extension;
            if (file_exists($filePath)) {
                $found = true;
                $ekstensi = $extension;
                break;
            } else {
                $sourcePath = WRITEPATH . 'uploads/' . $fileName . '.' . $extension;
                $destinationPath = 'public/uploads/' . $fileName . '.' . $extension;

                if (file_exists($sourcePath)) {
                    if (rename($sourcePath, $destinationPath)) {
                        $found = true;
                        $ekstensi = $extension;
                        break;
                    }
                }
            }
        }

        if ($found) {
            $namafile = $fileName . "." . $ekstensi;
        } else {
            $namafile = "";
        }

        return $namafile;
    }

    public function download_sk_old($namafile)
    {
        $folderPath = WRITEPATH . 'uploads/';
        $filePath = $folderPath . $namafile;
        return $this->response->download($filePath, null);
    }

    public function download_sk($nama_file)
    {
        echo "wait ...";
        die();
        $file_path = WRITEPATH . 'uploads/' . $nama_file;

        // Periksa apakah file ada
        if (file_exists($file_path) && is_readable($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) == 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $nama_file . '"');
            readfile($file_path);
        } else {
            // Jika file tidak ditemukan atau bukan PDF, tampilkan pesan atau lakukan tindakan lain
            echo "File tidak ditemukan atau bukan file PDF.";
        }
    }

    public function cek_sk_npsn($hal)
    {
        $jml_sudahupload = 0;
        $data_sk_npsn = $this->model_tppk->cek_sk_npsn($hal);
        echo exec('cls');
        echo "Mulai: " . date('d-m-Y H:i:s') . '<br>';
        // die();
        foreach ($data_sk_npsn as $row) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $row['sk_tugas']);
            $npsn = $row['npsn'];
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;
            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);
            // echo "NPSN:" . $npsn . ":" . $namafiletanpaekstensi . "<br>";
            if ($namafilesk) {
                $jml_sudahupload++;
                $data = array();
                $data['sekolah_id'] = $row['sekolah_id'];
                $data['npsn'] = $row['npsn'];
                $nomorsk = str_replace("'", "`", $row['sk_tugas']);
                $nomorsk = str_replace('"', '`', $nomorsk);
                $data['nomor_sk'] = $nomorsk;
                $data['status_sk'] = 1;
                $data['tanggal_sk'] = $row['tmt_sk_tugas'];
                // $data['nama_operator'] = "";session()->get('nama');
                $this->model_tppk->input_data_sk($data);
                $this->clear_residu_upload_sk($npsn);
            }
        }
        echo "Total upload SK:$jml_sudahupload";
        echo "<br>Selesai: " . date('d-m-Y H:i:s') . '<br>';
    }

    public function cek_sk_npsn_satuan($npsn)
    {
        $jml_sudahupload = 0;
        $data_sk_npsn = $this->model_tppk->cek_sk_npsn_satuan($npsn);
        // echo var_dump($data_sk_npsn);
        foreach ($data_sk_npsn as $row) {
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $row['sk_tugas']);
            $npsn = $row['npsn'];
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;
            echo $namafiletanpaekstensi;
            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);
            if ($namafilesk) {
                $jml_sudahupload++;
                $data = array();
                $data['sekolah_id'] = $row['sekolah_id'];
                $data['npsn'] = $row['npsn'];
                $nomorsk = str_replace("'", "`", $row['sk_tugas']);
                $nomorsk = str_replace('"', '`', $nomorsk);
                $data['nomor_sk'] = $nomorsk;
                $data['status_sk'] = 1;
                $data['tanggal_sk'] = $row['tmt_sk_tugas'];
                // $data['nama_operator'] = "";session()->get('nama');
                $this->model_tppk->input_data_sk($data);
                $this->clear_residu_upload_sk($npsn);
                echo "<br>NPSN: " . $npsn . ", sudah input SK<br>";
                // echo "NEMU";
            } else {
                echo " >>>> GAK NEMU";
            }
        }
        echo "Total upload SK:$jml_sudahupload";
    }

    public function cek_sk_belum_di_tabel()
    {
        $jml_sudahupload = 0;
        $data_sk_npsn = $this->model_tppk->cek_sk_belum_ditabel();
        // echo var_dump($data_sk_npsn);
        $nomor = 0;
        foreach ($data_sk_npsn as $row) {
            $nomor++;
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $row['sk_tugas']);
            $npsn = $row['npsn'];
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;
            // echo "[" . $nomor . "]" . $namafiletanpaekstensi . ">>" . $row['sk_tugas'];
            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);
            $tanggalsk = $row['tmt_sk_tugas'];
            if ($namafilesk) {
                $jml_sudahupload++;
                $data = array();
                $data['sekolah_id'] = $row['sekolah_id'];
                $data['npsn'] = $row['npsn'];
                $nomorsk = str_replace("'", "`", $row['sk_tugas']);
                $nomorsk = str_replace('"', '`', $nomorsk);
                $data['nomor_sk'] = $nomorsk;
                $data['status_sk'] = 1;
                $tanggalsknya = substr($tanggalsk, 8, 2) . "-" . substr($tanggalsk, 5, 2) . "-" . substr($tanggalsk, 0, 4);
                $data['tanggal_sk'] = $tanggalsknya;
                // $data['nama_operator'] = "";session()->get('nama');
                // $this->model_tppk->input_data_sk($data);
                // $this->clear_residu_upload_sk($npsn);
                echo "<br>NPSN: " . $npsn . ", sudah input SK<br>";
                // echo "NEMU";
            } else {
                // echo "<br>NPSN: " . $npsn . ", GAK NEMU<br>";
            }
        }
        echo "Total daftar belum di tabel:" . $nomor . "<br>Total upload SK:$jml_sudahupload";
    }

    private function detail_tppk()
    {
        /****** QUERY TPPK  ******/
        $sql = "SELECT TOP (1000) r1.nama as propinsi,r2.nama as kota_kab,r3.nama as kecamatan, t.kode_wilayah as NPSN
            ,[wilayah] as satuan_pendidikan
            ,[bentuk_pendidikan]
            ,[status_sekolah]
            ,[jenjang_sekolah]
            ,[jml_tppk]
        FROM [TPPK].[rpt].[rekap_tppk] t
        LEFT JOIN Referensi.ref.mst_wilayah r1 ON LEFT(r1.kode_wilayah,2) = LEFT(t.mst_kode_wilayah,2) AND r1.id_level_wilayah=1
        LEFT JOIN Referensi.ref.mst_wilayah r2 ON LEFT(r2.kode_wilayah,4) = LEFT(t.mst_kode_wilayah,4) AND r2.id_level_wilayah=2
        LEFT JOIN Referensi.ref.mst_wilayah r3 ON LEFT(r3.kode_wilayah,6) = LEFT(t.mst_kode_wilayah,6) AND r3.id_level_wilayah=3
        where t.id_level_wilayah = 4 AND 
        (bentuk_pendidikan IN ('PKBM','SKB') OR bentuk_pendidikan='SLB')
        AND jml_tppk>0
        order by r1.kode_wilayah, r2.kode_wilayah, r3.kode_wilayah, satuan_pendidikan";
    }

    public function moveFile()
    {
        $sourcePath = WRITEPATH . 'uploads/sk_tes_p.pdf'; // Path to the source file in writable folder
        $destinationPath = 'public/uploads/sk_tes_p2.pdf'; // Path to the destination file in public folder

        // Check if the source file exists
        if (file_exists($sourcePath)) {
            // Attempt to move the file
            if (rename($sourcePath, $destinationPath)) {
                echo "File moved successfully.";
            } else {
                echo "Failed to move file.";
            }
        } else {
            echo "Source file does not exist.";
        }
    }

    public function clear_residu_all($hal, $opsi = null)
    {
        if ($opsi == "npsn") {
            $npsn_tppk = $this->model_tppk->getnpsntppk($hal);
        } else {
            $npsn_tppk = $this->model_tppk->getallnpsn($hal);
        }

        $jumlah = 0;
        foreach ($npsn_tppk as $rowdata) {
            $npsn = $rowdata['npsn'];
            $fileabjad = preg_replace("/[^a-zA-Z0-9]/", "", $rowdata['sk_tugas']);
            $namafiletanpaekstensi = "sk_" . $npsn . "_" . $fileabjad;

            $namafilesk = $this->cekfilesk($namafiletanpaekstensi);

            if ($namafilesk != "") {
                $jumlah++;
                $this->clear_residu_upload_sk($npsn);
                $datask = array('sekolah_id' => $rowdata['sekolah_id'], 'npsn' => $npsn, 'nomor_sk' => $rowdata['sk_tugas'], 'tanggal_sk' => $rowdata['tmt_sk_tugas'], 'nama_operator' => 'TPPK');
                // if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                //     echo $tanggalsk . "<br>";
                //     echo $sekolah_id . "<br>";
                //     echo var_dump($datask);
                //     die();
                // }
                $ceksk = $this->model_tppk->cek_sk_tppk($npsn, $rowdata['sk_tugas']);
                if (!$ceksk)
                    $this->model_tppk->insert_sk_tppk_baru($datask);
            }
        }

        echo $jumlah;
    }
}
