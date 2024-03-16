<?php

namespace App\Controllers;

use App\Models\M_tppk;

class Dashboard extends BaseController
{


    function __construct()
    {
        $this->model_tppk = new M_tppk();
    }

    public function index()
    {
        $jenjang = isset($_GET['jenjang']) ? $_GET['jenjang'] : "semua";
        $bentuk = isset($_GET['bentuk']) ? $_GET['bentuk'] : "semua";
        $status = isset($_GET['status']) ? $_GET['status'] : "semua";

        $data['jenjang'] = $jenjang;
        $data['bentuk'] = $bentuk;
        $data['status'] = $status;

        $data['dafbentuk'] = $this->getBentukKementerian($jenjang, 1);

        $persentase = $this->model_tppk->getTotalJendralPPTK();
        $persentasesatgasprovinsi = $this->model_tppk->getTotalJendralSatgasProvinsi();
        $persentasesatgaskota = $this->model_tppk->getTotalJendralSatgasKota();

        if (!$persentase)
            $persen_tppk = 0;
        else
            $persen_tppk = intval($persentase->total_jml_tppk / $persentase->total_jml_sp * 10000) / 100;

        $persen_sp = 100 - $persen_tppk;

        $persen_satgasprovinsi = intval($persentasesatgasprovinsi->total_jml_satgas_provinsi / $persentasesatgasprovinsi->jml_provinsi * 10000) / 100;
        $persen_provinsi = 100 - $persen_satgasprovinsi;

        $persen_satgaskota = intval($persentasesatgaskota->total_jml_satgas_kota / $persentasesatgaskota->jml_kota * 10000) / 100;
        $persen_kota = 100 - $persen_satgaskota;

        $query = $this->model_tppk->getTotalTPPK('000000', 0, $jenjang, $bentuk, $status);
        $datatppk = $query->getResultArray();
        // var_dump($datatppk);
        $total_sp = 0;
        $total_tppk = 0;
        $total_sync = 0;
        foreach ($datatppk as $row) {
            $total_sp = $total_sp + $row['tot_jml_satuan_pendidikan'];
            $total_sync = $total_sync + $row['tot_sekolah_sudah_sync'];
            $total_tppk = $total_tppk + $row['tot_jml_tppk'];
        }

        $updateterakhir = $this->model_tppk->getlastupdate();

        $tglakhir = $updateterakhir['last_update'];

        $now = date("Y-m-d");
        $data['tglsekarang'] = namabulan_panjang($now);
        $data['last_update'] = tgl_jam($tglakhir);
        $data['persen_sp'] = $persen_sp;
        $data['persen_tppk'] = $persen_tppk;
        $data['totalsp'] = $total_sp;
        $data['totalsync'] = $total_sync;
        $data['totaltppk'] = $total_tppk;

        $data['persen_provinsi'] = $persen_provinsi;
        $data['persen_satgasprovinsi'] = $persen_satgasprovinsi;
        $data['totalprovinsi'] = $persentasesatgasprovinsi->jml_provinsi;
        $data['totalsatgasprovinsi'] = $persentasesatgasprovinsi->total_jml_satgas_provinsi;

        $data['persen_kota'] = $persen_kota;
        $data['persen_satgaskota'] = $persen_satgaskota;
        $data['totalkota'] = $persentasesatgaskota->jml_kota;
        $data['totalsatgaskota'] = $persentasesatgaskota->total_jml_satgas_kota;

        $query1 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekappaud', 'semua', 'semua');
        $data['rekappaud'] = $query1->getRowArray();
        $query2 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapsd', $bentuk, $status);
        $data['rekapsd'] = $query2->getRowArray();
        $query3 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapsmp', $bentuk, $status);
        $data['rekapsmp'] = $query3->getRowArray();
        $query4 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapsma', $bentuk, $status);
        $data['rekapsma'] = $query4->getRowArray();
        $query5 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapsmk', $bentuk, $status);
        $data['rekapsmk'] = $query5->getRowArray();
        $query6 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapslb', $bentuk, $status);
        $data['rekapslb'] = $query6->getRowArray();
        $query7 = $this->model_tppk->getTotalTPPKDasbor('000000', 0, 'rekapkesetaraan', $bentuk, $status);
        $data['rekapkesetaraan'] = $query7->getRowArray();

        // echo var_dump($data['rekappaud']); //['tot_jml_satuan_pendidikan'] . ", " . $data['rekappaud']['tot_jml_tppk'];

        return view('stat_linechart', $data);
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

    public function tesdb()
    {

        $datan =  array(
            'satgas_id' => '112233', 'jenis_instansi_id' => '20'
        );
        $this->model_tppk->insert_satgas_baru($datan);
    }
}
