<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tools extends Model
{
    public function get_rekap_tppk($kode)
    {
        $sql = 'SELECT TOP (1000) * FROM [TPPK].[rpt].[rekap_tppk]
                where kode_wilayah =:kodewilayah:';
        $query = $this->db->query($sql, [
            'kodewilayah'  => $kode
        ]);

        return $query->getResultArray();
    }

    public function get_sk_tppk($kode)
    {
        $sql = 'SELECT TOP (1000) * FROM [TPPK].[dbo].[sk_tppk]
                where npsn =:kodewilayah:';
        $query = $this->db->query($sql, [
            'kodewilayah'  => $kode
        ]);

        return $query->getResultArray();
    }

    public function get_anggota_tppk($kode)
    {
        $sql = 'SELECT *
                FROM [TPPK].[dbo].[kepanitiaan] k
                left join arsip.dbo.sekolah s on s.sekolah_id = k.sekolah_id
                where npsn=:npsn:';
        $query = $this->db->query($sql, [
            'npsn'  => $kode
        ]);

        return $query->getResultArray();
    }

    public function get_tppk_wilayah($hal)
    {
        $ofset = ($hal - 1) * 10000;
        $sql = "SELECT r1.nama as propinsi, r2.nama as kota_kab
                    ,[wilayah] as kecamatan
                    ,[bentuk_pendidikan]
                    ,[status_sekolah]
                    ,[jenjang_sekolah]
                    ,[jml_satuan_pendidikan]
                    ,[jml_tppk]
                FROM [TPPK].[rpt].[rekap_tppk] rt 
                LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (rt.mst_kode_wilayah, 2) 
                AND r1.id_level_wilayah=1 
                LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (rt.mst_kode_wilayah, 4) 
                AND r2.id_level_wilayah=2 
                WHERE rt.id_level_wilayah=3
                ORDER BY r1.kode_wilayah, r2.kode_wilayah
                OFFSET " . $ofset . " ROWS
                FETCH NEXT 10000 ROWS ONLY";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }
}
