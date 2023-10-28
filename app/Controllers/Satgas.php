<?php

namespace App\Controllers;

use App\Models\M_tppk;

class Satgas extends BaseController
{
    function __construct()
    {
        $this->model_tppk = new M_tppk();
    }

    public function index()
    {
        // return view('beranda');
    }

    public function wilayah($kode = '000000', $level = 0)
    {
        $jenjang = isset($_GET['jenjang']) ? $_GET['jenjang'] : "";
        $bentuk = isset($_GET['bentuk']) ? $_GET['bentuk'] : "";
        $status = isset($_GET['status']) ? $_GET['status'] : "";

        $data['jenjang'] = $jenjang;
        $data['bentuk'] = $bentuk;
        $data['status'] = $status;

        $data['kode'] = $kode;
        $data['level'] = $level;

        if ($level == 0) {
            $data['namapilihan'] = "Provinsi";
            $data['namalevel1'] = "";
            $data['namalevel2'] = "";
            $data['namalevel3'] = "";
            $data['namalevel4'] = "";
        } else {

            $namapilihan = $this->model_tppk->getNamaPilihan($kode);
            $resultquery = $namapilihan->getResult();
            $data['namapilihan'] = strToUpper($resultquery[0]->nama);

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

        if ($level < 1) {
            $query = $this->model_tppk->getTotalTPPK($kode, $level);
            $data['datanas'] = $query->getResultArray();
            echo var_dump($data['datanas']);
            die();
            return view('satgas/data_satgas', $data);
        }
        if ($level == 1) {
            $query = $this->model_tppk->getTotalTPPK($kode, $level);
            $data['datanas'] = $query->getResultArray();
            return view('satgas/data_satgas_kota', $data);
        } else {
            $query = $this->model_tppk->getDaftarTPPK($kode, $level);
            $data['datanas'] = $query->getResultArray();
            return view('satgas/daftaranggota_satgas', $data);
        }
    }

    public function anggota($idsekolah)
    {
        $query1 = $this->model_tppk->getSekolah($idsekolah);
        $data['namasekolah'] = $query1->getRowArray();

        $query2 = $this->model_tppk->getDaftarAnggota($idsekolah);
        $data['daftaranggota'] = $query2->getResultArray();
        return view('satgas/daftaranggota_satgas', $data);
    }

    public function getBentukKementerian($jenjang = null, $opsi = null)
    {
        $jenjang = strtolower($jenjang);
        $daftarbentukkementerian = array('-Semua Bentuk-');

        if ($jenjang == "paud")
            $daftarbentukkementerian = array('TK', 'KB', 'TPA', 'SPS', 'SPK KB', 'SPK PG', 'SPK TK');
        else if ($jenjang == "dikdas")
            $daftarbentukkementerian = array('SD', 'SMP', 'SPK SD', 'SPK SMP', 'PDF Ula', 'PDF Wustha', 'SPM Ula', 'SPM Ulya', 'SPM Wustha');
        else if ($jenjang == "dikmen")
            $daftarbentukkementerian = array('SMA', 'SMK', 'SLB', 'SPK SMA');
        else if ($jenjang == "dikmas")
            $daftarbentukkementerian = array('Kursus', 'TBM', 'PKBM', 'SKB');

        if ($opsi == null)
            echo json_encode($daftarbentukkementerian);
        return $daftarbentukkementerian;
    }
}
