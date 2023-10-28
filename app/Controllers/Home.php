<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('beranda');
    }

    public function set_pilihan($pilihan = null)
    {
        session()->set('pilihan', $pilihan);
    }

    public function tes()
    {
        return view('tes');
    }

    //     INSERT INTO TPPK.dbo.sekolahdummy (instansi_id,jenis_instansi_id,kode_instansi,nama,alamat,kode_wilayah,soft_delete,create_date,last_update)
    //   VALUES (NEWID(),5,'99999999','SMP Percobaan Saja','Jl. Utama Satu 01','016001',0,getdate(),getdate())
    //     INSERT INTO [TPPK].[rpt].[rekap_tppk] (kode_wilayah,wilayah,id_level_wilayah,mst_kode_wilayah,bentuk_pendidikan,status_sekolah,jenjang_sekolah,jml_satuan_pendidikan,jml_tppk)
    //   VALUES ('99999999', 'SMP Percobaan Saja','016001','SMP','swasta','dikdas',1,4)
}
