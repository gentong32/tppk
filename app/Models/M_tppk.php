<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tppk extends Model
{
    function __construct(Type $var = null)
    {
        parent::__construct();
    }

    public function getNamaPilihan($kode)
    {
        // $this->db = \Config\Database::connect();
        // $this->db->table('Referensi.ref.mst_wilayah');

        $sql = 'SELECT nama FROM Referensi.ref.mst_wilayah w  
                WHERE kode_wilayah=:kodewilayah:';
        $query = $this->db->query($sql, [
            'kodewilayah'  => $kode
        ]);

        return $query;
    }

    public function getNamaWilayah($kode, $level)
    {
        $digit = ($level - 1) * 2;
        if ($level == 1)
            $digit = 2;
        $sql = "SELECT * FROM Referensi.ref.mst_wilayah 
                WHERE LEFT(mst_kode_wilayah, :digit:)=LEFT(:kode:, :digit:) AND id_level_wilayah=:level: ORDER BY kode_wilayah";

        $query = $this->db->query($sql, [
            'digit'  => $digit,
            'kode'  => $kode,
            'level'  => $level
        ]);

        return $query->getResult();
    }

    public function getDataWilayah($kodwil)
    {
        $sql = "select w1.nama as kelurahan,w2.nama as kecamatan, w3.nama as kota, w4.nama as propinsi, w1.id_level_wilayah, w1.mst_kode_wilayah, w1.kode_wilayah 
		from Referensi.ref.mst_wilayah w1, Referensi.ref.mst_wilayah w2, Referensi.ref.mst_wilayah w3, Referensi.ref.mst_wilayah w4 
		where w1.kode_wilayah = :kodwil: and (w1.mst_kode_wilayah = w2.kode_wilayah) and 
		(w2.mst_kode_wilayah = w3.kode_wilayah) and (w3.mst_kode_wilayah = w4.kode_wilayah)
		order by w1.id_level_wilayah, w2.nama, w1.nama";

        $query = $this->db->query($sql, [
            'kodwil'  => substr($kodwil, 0, 8)
        ]);

        return $query;
    }

    public function getNamaInstansi($kodeinstansi, $jenisinstansi)
    {
        $sql = "SELECT i.instansi_id, i.nama, i.kode_instansi FROM TPPK.dbo.instansi i
                LEFT JOIN TPPK.dbo.instansi_pengguna p on i.instansi_id = p.instansi_id
                WHERE LEFT(kode_wilayah, 6)=LEFT(:kode:, 6) AND i.soft_delete=0 
                AND jenis_instansi_id=:jenis: AND instansi_pengguna_id IS NULL ORDER BY i.nama";

        $query = $this->db->query($sql, [
            'kode'  => $kodeinstansi,
            'jenis'  => $jenisinstansi
        ]);

        return $query->getResult();
    }

    public function getNamaSekolah($kodewilayah)
    {
        $sql = "SELECT sekolah_id as instansi_id, nama, npsn as kode_instansi FROM Arsip.dbo.sekolah
                WHERE LEFT(kode_wilayah, 6)=LEFT(:kode:, 6) AND bentuk_pendidikan_id IN (1,2,3,4,43,51,52,5, 6, 53, 54, 13, 15, 29, 55,24, 26, 27, 40) AND soft_delete=0 
                ORDER BY bentuk_pendidikan_id,nama";

        $query = $this->db->query($sql, [
            'kode'  => $kodewilayah,
        ]);

        return $query->getResult();
    }

    public function getNPSN($kodeinstansi)
    {
        $sql = "SELECT * FROM TPPK.dbo.instansi WHERE instansi_id=:kode:";

        $query = $this->db->query($sql, [
            'kode'  => $kodeinstansi
        ]);

        return $query->getRow();
    }

    public function getPTK($kodeinstansi)
    {
        $sql = "SELECT ptk_id,nama,jenis_ptk,a.jenis_ptk_id 
                FROM Arsip.dbo.ptk a
                JOIN [Referensi].[ref].[jenis_ptk] r ON a.jenis_ptk_id=r.jenis_ptk_id
                WHERE sekolah_id = :sekolahid: AND aktif=1 AND soft_delete = 0";

        $query = $this->db->query($sql, [
            'sekolahid'  => $kodeinstansi
        ]);

        return $query->getResult();
    }

    public function getPTKRes($npsn)
    {
        $sql = "SELECT * FROM [arsip].[ptk].[rekap_ptk] where kode_wilayah = :npsn:";

        $query = $this->db->query($sql, [
            'npsn'  => $npsn
        ]);

        return $query->getRowArray();
    }

    public function getPD($kodeinstansi)
    {
        $sql = "SELECT * 
                FROM Arsip.dbo.peserta_didik 
                WHERE sekolah_id = :sekolahid: AND aktif=1 AND soft_delete=0";

        $query = $this->db->query($sql, [
            'sekolahid'  => $kodeinstansi
        ]);

        return $query->getResult();
    }

    public function getPDRes($npsn)
    {
        $sql = "SELECT * FROM [arsip].[pd].[rekap_residu] where kode_wilayah = :npsn:";

        $query = $this->db->query($sql, [
            'npsn'  => $npsn
        ]);

        return $query->getRowArray();
    }

    public function getOperator($idinstansi)
    {

        $this->db = \Config\Database::connect("sdm");

        $sql = "SELECT p.nama as nama_operator, * 
                FROM sdm.dbo.pengguna p
                LEFT JOIN sdm.dbo.instansi_pengguna i ON p.pengguna_id = i.pengguna_id 
                WHERE i.instansi_id = :instansiid: AND jabatan_id='106' AND p.soft_delete = 0 AND i.soft_delete = 0";

        $query = $this->db->query($sql, [
            'instansiid'  => $idinstansi
        ]);

        $this->db = \Config\Database::connect("default");
        return $query->getResult();
    }

    public function search_sekolah($search, $kodepropinsi, $kodekota, $kodekecamatan)
    {
        $anddata = "";
        if ($kodepropinsi != "00") {
            $anddata = "AND LEFT(kode_wilayah,2) = " . substr($kodepropinsi, 0, 2);
        }
        if ($kodekota != "00") {
            $anddata = "AND LEFT(kode_wilayah,4) = " . substr($kodekota, 0, 4);
        }
        if ($kodekecamatan != "00") {
            $anddata = "AND LEFT(kode_wilayah,6) = " . substr($kodekecamatan, 0, 6);
        }

        $sql = "SELECT TOP (20) * FROM TPPK.dbo.instansi 
                WHERE jenis_instansi_id = 5 AND nama LIKE :namasekolah: " . $anddata;

        $query = $this->db->query($sql, [
            'namasekolah'  => "%" . $search . "%"
        ]);

        return $query->getResult();
    }

    public function search_ptk($search, $sekolah_id)
    {
        $sql = "SELECT TOP (20) * FROM Arsip.dbo.ptk 
                WHERE sekolah_id = :sekolahid: AND soft_delete = 0 AND nama LIKE :namaptk: ";

        $query = $this->db->query($sql, [
            'sekolahid'  => $sekolah_id,
            'namaptk'  => "%" . $search . "%"
        ]);

        return $query->getResult();
    }

    public function insert_batch($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('instansi_pengguna');
        $builder->insertBatch($data);
    }

    public function insert_pengguna($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pengguna');

        $pengguna_id = "";
        foreach ($data as $row) {
            $pengguna_id = $pengguna_id . "ptk_id = '" . $row . "' OR ";
        }

        $panjang = strlen($pengguna_id);
        $penggunaid = substr($pengguna_id, 0, $panjang - 3);

        $sql = "INSERT INTO TPPK.dbo.pengguna (pengguna_id, nik, nama, tempat_lahir, tanggal_lahir
            ,jenis_kelamin,kode_wilayah,email,password,status_approval)
            SELECT ptk_id, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, 
            kode_wilayah,'','',0
            FROM [arsip].[dbo].[ptk] pt 
            WHERE (" . $penggunaid . ") AND
            NOT EXISTS (
                SELECT 1
                FROM TPPK.dbo.pengguna pgn
                WHERE pgn.pengguna_id = pt.ptk_id
            )";

        $query = $this->db->query($sql);

        return $query;
    }

    public function insert_sk_baru($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.sk_satgas_provinsi');

        $sql = "INSERT INTO TPPK.dbo.sk_satgas_provinsi (sk_id, kode_wilayah, id_level_wilayah, nomor_sk, tanggal_sk, modified_date, nama_operator, catatan_sk) values ('" . $data['sk_id'] . "','" . $data['kode_wilayah'] . "'," . $data['id_level_wilayah'] . ",'" . $data['nomor_sk'] . "','" . $data['tanggal_sk'] . "',GETDATE(),'" . $data['nama_operator'] . "','')";

        $query = $this->db->query($sql);

        return $query;
    }

    public function insert_satgas_baru($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.satgas_wilayah');

        $sql = "INSERT INTO TPPK.dbo.satgas_wilayah (satgas_id, sk_id, jenis_instansi_id, nama, nik, sex, telepon, email, anggotake, tanggal_lahir, status_dukcapil) values ('" . $data['satgas_id'] . "','" . $data['sk_id'] . "','" . $data['jenis_instansi_id'] . "','" . $data['nama'] . "','" . $data['nik'] . "'," . $data['sex'] . ",'" . $data['telepon'] . "','" . $data['email'] . "'," . $data['anggotake'] . ",'" . $data['tanggal_lahir'] . "','" . $data['status_dukcapil'] . "')";

        $query = $this->db->query($sql);

        return $query;
    }

    public function hapus_satgas_lama($skid)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.satgas_wilayah');
        if (strlen($skid) > 16) {
            $sql = "DELETE FROM TPPK.dbo.satgas_wilayah WHERE sk_id='" . $skid . "'";
            $query = $this->db->query($sql);

            return $query;
        }
    }

    public function insert_sk_tppk_baru($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.sk_tppk');

        $sql = "INSERT INTO TPPK.dbo.sk_tppk (sekolah_id, npsn, nomor_sk, tanggal_sk, nama_operator) values ('" . $data['sekolah_id'] . "','" . $data['npsn'] . "','" . $data['nomor_sk'] . "','" . $data['tanggal_sk'] . "','" . $data['nama_operator'] . "')";

        $query = $this->db->query($sql);

        return $query;
    }

    public function getTotalTPPK_old($kode, $level)
    {
        if ($level == 0) {
            $lef1 = 2;
            $lef2 = 1;
        } else if ($level == 1) {
            $lef1 = 4;
            $lef2 = 2;
        } else if ($level == 2) {
            $lef1 = 6;
            $lef2 = 4;
        } else if ($level == 3) {
            $lef1 = 8;
            $lef2 = 6;
        }

        $level++;

        $kodebaru = substr($kode, 0, $lef2);

        $sql = "SELECT total_anggota, wilayah, kode_wilayah 
        FROM (SELECT count(rf.[kode_wilayah]) as total_anggota,rf.nama as wilayah,rf.[kode_wilayah]
        FROM [TPPK].[dbo].[instansi_pengguna] ipg 
        JOIN TPPK.dbo.instansi ins ON ins.instansi_id = ipg.instansi_id 
        JOIN Referensi.ref.mst_wilayah rf ON left(rf.kode_wilayah,:lef1:) = left(ins.kode_wilayah,:lef1:) 
        JOIN TPPK.dbo.sk_tppk st ON 
        WHERE ipg.[soft_delete] = 0 AND LEFT(rf.kode_wilayah,:lef2:) = :kodebaru: AND id_level_wilayah=:levelnya:
        GROUP BY rf.kode_wilayah, rf.nama
        UNION
        SELECT count(rf.[kode_wilayah]) as total_anggota,rf.nama as wilayah,rf.[kode_wilayah]
        FROM [TPPK].[dbo].[sekolahdummy] ipg 
        JOIN TPPK.dbo.instansi ins ON ins.instansi_id = ipg.instansi_id 
        JOIN Referensi.ref.mst_wilayah rf ON left(rf.kode_wilayah,:lef1:) = left(ins.kode_wilayah,:lef1:) 
        WHERE ipg.[soft_delete] = 0 AND LEFT(rf.kode_wilayah,:lef2:) = :kodebaru: AND id_level_wilayah=:levelnya:
        GROUP BY rf.kode_wilayah, rf.nama) AS combined_result";

        $query = $this->db->query($sql, [
            'lef1'  => $lef1,
            'lef2'  => $lef2,
            'levelnya' => $level,
            'kodebaru' => $kodebaru
        ]);

        // echo $sql;
        return $query;
    }

    public function getDaftarTPPK($kode, $level, $kementerian = null)
    {

        $sql = "SELECT count(ipg.[instansi_id]) as total_anggota,[sk],[tanggal_sk],[flag],ipg.[create_date],ipg.[last_update],ins.nama as namasekolah, kode_instansi, ipg.[instansi_id]
        FROM [TPPK].[dbo].[instansi_pengguna] ipg 
        JOIN TPPK.dbo.instansi ins ON ins.instansi_id = ipg.instansi_id 
        WHERE ipg.[soft_delete] = 0 AND LEFT(ins.kode_wilayah,6) = :kodebaru: 
        GROUP BY ipg.[instansi_id], sk ,[tanggal_sk],[flag],ipg.[create_date],ins.nama,
        ipg.[last_update], kode_instansi";

        $query = $this->db->query($sql, [
            'kodebaru' => $kode
        ]);

        return $query;
    }

    public function getSekolah($npsn)
    {

        if ($npsn == "99999999") {
            $sql = "SELECT instansi_id,kode_instansi,nama,kode_instansi as npsn,kode_wilayah
                FROM [TPPK].[dbo].[sekolahdummy] i
                -- LEFT JOIN [arsip].[dbo].[sekolah] s ON s.sekolah_id = i.instansi_id 
                WHERE kode_instansi = :npsn:";
        } else {
            // $sql = "SELECT instansi_id,kode_instansi,i.nama,s.npsn,i.kode_wilayah
            //     FROM [TPPK].[dbo].[instansi] i
            //     LEFT JOIN [arsip].[dbo].[sekolah] s ON s.sekolah_id = i.instansi_id 
            //     WHERE npsn = :npsn:";

            $sql = "SELECT sekolah_id as instansi_id,'' as kode_instansi,nama,npsn,kode_wilayah
                FROM [arsip].[dbo].[sekolah]
                WHERE npsn = :npsn:";
        }


        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query;
    }

    public function getTokenSSO($tokenKey)
    {
        $this->db = \Config\Database::connect("dbsso");
        $sql = "EXEC sdm.dbo.sp_sso_checkToken :token:";
        $query = $this->db->query($sql, ['token' => $tokenKey]);
        $result =  $query->getRow();
        return $result;
    }

    public function getAkunSSO($tokenKey)
    {
        $this->db = \Config\Database::connect("dbsso");
        $sql = "EXEC sdm.dbo.sp_sso_getUsername :token:";
        $query = $this->db->query($sql, ['token' => $tokenKey]);
        $result =  $query->getRow();
        return $result;
    }

    public function getDinas($kodewilayah)
    {

        $sql = "SELECT instansi_id,kode_instansi,i.nama 
                FROM [TPPK].[dbo].[instansi] i
                WHERE kode_wilayah = :kodewilayah:";

        $query = $this->db->query($sql, [
            'kodewilayah' => $kodewilayah
        ]);

        return $query;
    }

    public function getDaftarAnggota_old($idinstansi)
    {

        $sql = "SELECT * FROM [TPPK].[dbo].[instansi_pengguna] ipg
        LEFT JOIN Arsip.dbo.ptk ptk ON ipg.pengguna_id = ptk.ptk_id 
		LEFT JOIN Referensi.ref.jenis_ptk rj ON rj.jenis_ptk_id = ptk.jenis_ptk_id  
        WHERE ipg.soft_delete = 0 
		AND instansi_id = :instansi:";

        $query = $this->db->query($sql, [
            'instansi' => $idinstansi
        ]);

        return $query;
    }

    public function getSKProv($kodewilayah)
    {

        $sql = "SELECT TOP 1 * 
        FROM [TPPK].[dbo].[sk_satgas_provinsi]
        WHERE kode_wilayah = :kodewilayah:
        ORDER BY create_date DESC";

        $query = $this->db->query($sql, [
            'kodewilayah' => $kodewilayah
        ]);

        return $query->getRowArray();
    }

    public function getSKSekolah($npsn)
    {

        $sql = "SELECT TOP 1 * 
        FROM [TPPK].[dbo].[sk_tppk]
        WHERE npsn = :npsn:
        ORDER BY create_date DESC";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getRowArray();
    }

    public function getAnggotaProv($skid)
    {

        $sql = "SELECT s.nama as namaanggota,j.nama as instansi,*
        FROM [TPPK].[dbo].[satgas_wilayah] s
        LEFT JOIN [TPPK].[dbo].[jenis_instansi] j ON s.jenis_instansi_id = j.jenis_instansi_id 
        LEFT JOIN [TPPK].[dbo].[sk_satgas_provinsi] sk ON sk.sk_id = s.sk_id 
        WHERE s.sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid
        ]);

        return $query->getResultArray();
    }

    public function getDaftarAnggota($idinstansi)
    {
        $sql = "SELECT ROW_NUMBER() OVER (ORDER BY 
        CASE WHEN UPPER(peran_ang) LIKE 'PELINDUNG%' THEN 1
             WHEN UPPER(peran_ang) LIKE 'PEMBINA%' THEN 2
             WHEN UPPER(peran_ang) LIKE 'PENGARAH%' THEN 3
             WHEN UPPER(peran_ang) LIKE 'PENANGGUNG%' THEN 4
             WHEN UPPER(peran_ang) LIKE 'KETUA%' THEN 5
             WHEN UPPER(peran_ang) LIKE 'WAKIL%' THEN 6
             WHEN UPPER(peran_ang) LIKE 'SEKRETARIS%' THEN 7
             WHEN UPPER(peran_ang) LIKE 'BENDAHARA%' THEN 8
             WHEN UPPER(peran_ang) LIKE 'HUMAS%' THEN 9
             WHEN UPPER(peran_ang) LIKE 'KOORDINATOR%' THEN 10
             WHEN UPPER(peran_ang) LIKE 'SEKSI%' THEN 11
             ELSE 12 END
    ) AS urutan, ua.nama as nama_unsur2,s.nama as nama_sekolah,* 
        FROM [TPPK].[dbo].[kepanitiaan] k
        LEFT JOIN TPPK.dbo.ref_unsur_anggota ua ON ua.id_unsur_anggota = k.unsur_ang 
        LEFT JOIN Arsip.dbo.ptk p ON p.ptk_id = k.ptk_id
        LEFT JOIN Arsip.dbo.sekolah s ON s.sekolah_id = p.sekolah_id
        LEFT JOIN [Referensi].[ref].[jenis_ptk] r ON r.jenis_ptk_id = p.jenis_ptk_id 
        WHERE k.sekolah_id = :instansi: AND soft_delete_kepanitiaan=0 AND soft_delete_anggota_panitia=0
        AND tmt_sk_tugas = (SELECT MAX(tmt_sk_tugas) 
                      FROM [TPPK].[dbo].[kepanitiaan] 
                      WHERE sekolah_id = :instansi:)
        ORDER BY urutan, peran_ang ASC";

        $query = $this->db->query($sql, [
            'instansi' => $idinstansi
        ]);

        return $query;
    }

    public function getResiduSekolah($npsn)
    {
        $sql = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,[bentuk_pendidikan]
                ,[status_sekolah]
                ,[jenjang_sekolah]
                ,[residu]
                ,[residu_kepsek]
                ,[residu_guru]
                ,[residu_komite]
                ,[residu_upload_sk]
                ,[residu_siswa]
                ,[residu_ganjil]
                ,[jml_satuan_pendidikan] as tot_jml_satuan_pendidikan
                ,[jml_tppk] as tot_jml_tppk
                FROM [TPPK].[rpt].[rekap_tppk]
                where kode_wilayah=:npsn:";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getRowArray();
    }

    public function updateResiduSekolah($data, $npsn)
    {
        $setres_upload = "";
        $setres_residu = "";

        if ($data['residu_upload_sk'] == "update")
            $setres_upload = "residu_upload_sk = '0'";
        if ($data['residu'] == "update")
            $setres_residu = ", residu = '0'";
        $sql = "UPDATE [TPPK].[rpt].[rekap_tppk] SET " . $setres_upload . $setres_residu . " WHERE id_level_wilayah = 4 AND kode_wilayah = :npsn:";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return true;
    }

    public function getTotalTPPK($kode, $level, $jenjang = 'semua', $bentuk = 'semua', $status = 'semua')
    {

        // echo $jenjang . ">";
        // echo $bentuk . ">";
        // echo $status;
        $level++;

        if ($jenjang == "Paud") {
            $daftarbentuk = "'TK','KB','TPA','SPS','RA','Taman Seminari','SPK KB','PAUDQ','SPK PG','SPK TK','Pratama W P','Nava Dhammasekha'"; // 1,2,3,4,43,51,52
        } else if ($jenjang == "Dikdas") {
            $daftarbentuk = "'SD','SMP','MI','MTs','SMPTK','SDTK','SPK SD','SPK SMP','Adi W P','Madyama W P','Mula Dhammasekha','Muda Dhammasekha'"; //5, 6, 53, 54
        } else if ($jenjang == "Dikmen") {
            $daftarbentuk = "'SMA','SMK','MA','MAK','SLB','SMTK','SMAg.K','SMAK','SPK SMA','Utama W P','Uttama Dhammasheka','Uttama Dhammasheka Kejuruan'"; // 13, 15, 29, 55
        } else if ($jenjang == "Dikti") {
            $daftarbentuk = "'Akademi','Akademik','Politeknik','Sekolah Tinggi','Institut','Universitas'"; // 19, 20, 21, 22, 23
        } else if ($jenjang == "Dikmas") {
            $daftarbentuk = "'PKBM','SKB','Pondok Pesantren'"; //24, 26, 27, 40
        } else {
            $daftarbentuk = "";
        }



        $sql1 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,[bentuk_pendidikan]
                ,[status_sekolah]
                ,[jenjang_sekolah]
                ,[residu] as tot_residu
                ,[residu_kepsek] as tot_residu_kepsek
                ,[residu_guru] as tot_residu_guru
                ,[residu_komite] as tot_residu_komite
                ,[residu_upload_sk] as tot_residu_upload_sk
                ,[residu_siswa] as tot_siswa
                ,[residu_ganjil] as tot_ganjil
                ,[jml_satuan_pendidikan] as tot_jml_satuan_pendidikan
                ,[jml_tppk] as tot_jml_tppk
                ,status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah=:kodebaru: 
                and jenjang_sekolah='semua' and id_level_wilayah=:levelnya:
                ORDER BY kode_wilayah";

        $sql1b = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,[bentuk_pendidikan]
                ,[status_sekolah]
                ,[jenjang_sekolah]
                ,[residu] as tot_residu
                ,[residu_kepsek] as tot_residu_kepsek
                ,[residu_guru] as tot_residu_guru
                ,[residu_komite] as tot_residu_komite
                ,[residu_upload_sk] as tot_residu_upload_sk
                ,[residu_siswa] as tot_siswa
                ,[residu_ganjil] as tot_ganjil
                ,[jml_satuan_pendidikan] as tot_jml_satuan_pendidikan
                ,[jml_tppk] as tot_jml_tppk
                ,status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah=:kodebaru: 
                and id_level_wilayah=:levelnya:
                ORDER BY kode_wilayah";

        $sql2 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([jml_tppk]) as tot_jml_tppk
                ,sum ([residu]) as tot_residu
                ,sum ([residu_kepsek]) as tot_residu_kepsek
                ,sum ([residu_guru]) as tot_residu_guru
                ,sum ([residu_komite]) as tot_residu_komite
                ,sum ([residu_upload_sk]) as tot_residu_upload_sk
                ,sum ([residu_siswa]) as tot_residu_siswa
                ,sum ([residu_ganjil]) as tot_residu_ganjil
                ,sum (status_sk) as status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah=:kodebaru: 
                and id_level_wilayah=:levelnya:
                and status_sekolah=:statusnya:
                group by [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ORDER BY kode_wilayah";

        $sql3 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([jml_tppk]) as tot_jml_tppk
                ,sum ([residu]) as tot_residu
                ,sum ([residu_kepsek]) as tot_residu_kepsek
                ,sum ([residu_guru]) as tot_residu_guru
                ,sum ([residu_komite]) as tot_residu_komite
                ,sum ([residu_upload_sk]) as tot_residu_upload_sk
                ,sum ([residu_siswa]) as tot_residu_siswa
                ,sum ([residu_ganjil]) as tot_residu_ganjil                
                ,sum (status_sk) as status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah = :kodebaru: 
                and id_level_wilayah = :levelnya: 
				and jenjang_sekolah = :jenjang: 
                group by [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ORDER BY kode_wilayah";

        $sql4 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([jml_tppk]) as tot_jml_tppk
                ,sum ([residu]) as tot_residu
                ,sum ([residu_kepsek]) as tot_residu_kepsek
                ,sum ([residu_guru]) as tot_residu_guru
                ,sum ([residu_komite]) as tot_residu_komite
                ,sum ([residu_upload_sk]) as tot_residu_upload_sk
                ,sum ([residu_siswa]) as tot_residu_siswa
                ,sum ([residu_ganjil]) as tot_residu_ganjil
                ,sum (status_sk) as status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah = :kodebaru: 
                and id_level_wilayah = :levelnya: 
				and jenjang_sekolah = :jenjang:
                and status_sekolah = :statusnya:
                group by [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ORDER BY kode_wilayah";

        $sql5 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([jml_tppk]) as tot_jml_tppk
                ,sum ([residu]) as tot_residu
                ,sum ([residu_kepsek]) as tot_residu_kepsek
                ,sum ([residu_guru]) as tot_residu_guru
                ,sum ([residu_komite]) as tot_residu_komite
                ,sum ([residu_upload_sk]) as tot_residu_upload_sk
                ,sum ([residu_siswa]) as tot_residu_siswa
                ,sum ([residu_ganjil]) as tot_residu_ganjil
                ,sum (status_sk) as status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah = :kodebaru: 
                and id_level_wilayah = :levelnya: 
                and bentuk_pendidikan = :bentuk:
                group by [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ORDER BY kode_wilayah";

        $sql6 = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([jml_tppk]) as tot_jml_tppk
                ,sum ([residu]) as tot_residu
                ,sum ([residu_kepsek]) as tot_residu_kepsek
                ,sum ([residu_guru]) as tot_residu_guru
                ,sum ([residu_komite]) as tot_residu_komite
                ,sum ([residu_upload_sk]) as tot_residu_upload_sk
                ,sum ([residu_siswa]) as tot_residu_siswa
                ,sum ([residu_ganjil]) as tot_residu_ganjil
                ,sum (status_sk) as status_sk
                FROM [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                where mst_kode_wilayah = :kodebaru: 
                and id_level_wilayah = :levelnya: 
                and bentuk_pendidikan = :bentuk:
                and status_sekolah = :statusnya:
                group by [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ORDER BY kode_wilayah";

        if ($jenjang == 'semua' && $bentuk == 'semua' && $status == 'semua') {
            if ($level < 4) {
                $sql = $sql1;
            } else {
                $sql = $sql1b;
            }
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
            ]);
        } else if ($jenjang == 'semua' && $bentuk == 'semua' && $status != 'semua') {
            // echo "<br><br><br><br><br><br>1";
            // die();
            $sql = $sql2;
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
                'statusnya'  => $status,
            ]);
        } else if ($jenjang != 'semua' && $bentuk == 'semua' && $status == 'semua') {
            // echo "<br><br><br><br><br><br>2";
            // die();
            $sql = $sql3;
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
                'jenjang'  => $jenjang,
            ]);
        } else if ($jenjang != 'semua' && $bentuk == 'semua' && $status != 'semua') {
            // echo "<br><br><br><br><br><br>editing..";
            // die();
            $sql = $sql4;
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
                'jenjang'  => $jenjang,
                'statusnya'  => $status,
            ]);
        } else if ($jenjang != 'semua' && $bentuk != 'semua' && $status == 'semua') {
            // echo "<br><br><br><br><br><br>editing..";
            // die();
            $sql = $sql5;
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
                'bentuk'  => $bentuk,
            ]);
        } else if ($bentuk != 'semua' && $status != 'semua') {
            // echo "<br><br><br><br><br><br>3";
            // die();
            $sql = $sql6;
            $query = $this->db->query($sql, [
                'levelnya'  => $level,
                'kodebaru'  => $kode,
                'bentuk'  => $bentuk,
                'statusnya'  => $status,
            ]);
        }

        // echo $sql;
        // die();

        return $query;
    }

    public function getTotalSatgas($kode, $level)
    {

        $level++;

        $sql = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,[jml_satgas_provinsi]
                ,[jml_kab_kota]
                ,[jml_kab_kota_valid]
                ,[jml_satgas_kab_kota]
                ,[jml_anggota_satgas]
                FROM [TPPK].[dbo].[rekap_satgas]
                where mst_kode_wilayah=:kodebaru: 
                and id_level_wilayah=:levelnya:
                ORDER BY kode_wilayah";

        $query = $this->db->query($sql, [
            'levelnya'  => $level,
            'kodebaru'  => $kode,
        ]);

        // echo $sql;
        // die();

        return $query;
    }

    public function cekSatgasWilayah($kode, $level)
    {

        if ($level == 1)
            $kode = substr($kode, 0, 2) . '0000';
        if ($level == 2)
            $kode = substr($kode, 0, 4) . '00';

        $sql = "SELECT [kode_wilayah]
                ,[wilayah]
                ,[id_level_wilayah]
                ,[mst_kode_wilayah]
                ,[jml_satgas_provinsi]
                ,[jml_kab_kota]
                ,[jml_satgas_kab_kota]
                FROM [TPPK].[dbo].[rekap_satgas]
                where kode_wilayah=:kodebaru: 
                and id_level_wilayah=:levelnya:
                ORDER BY kode_wilayah";

        $query = $this->db->query($sql, [
            'levelnya'  => $level,
            'kodebaru'  => $kode,
        ]);

        $result = $query->getRow();

        return $result;
    }

    public function getTotalJendralPPTK()
    {

        $sql = "SELECT SUM (jml_satuan_pendidikan) as total_jml_sp, 
                SUM (jml_tppk) as total_jml_tppk
                FROM [TPPK].[rpt].[rekap_tppk]
                where id_level_wilayah = 1 AND bentuk_pendidikan='semua'
                group by id_level_wilayah";

        $query = $this->db->query($sql)->getRow();
        return $query;
    }

    public function getTotalJendralSatgasProvinsi()
    {

        $sql = "SELECT COUNT(kode_wilayah) as jml_provinsi, SUM (jml_satgas_provinsi) as total_jml_satgas_provinsi
                FROM [TPPK].[dbo].[rekap_satgas]
                where id_level_wilayah = 1
                group by id_level_wilayah";

        $query = $this->db->query($sql)->getRow();
        return $query;
    }

    public function getTotalJendralSatgasKota()
    {

        $sql = "SELECT COUNT(kode_wilayah) as jml_kota, SUM (jml_satgas_kab_kota) as total_jml_satgas_kota
                FROM [TPPK].[dbo].[rekap_satgas]
                where id_level_wilayah = 2
                group by id_level_wilayah";

        $query = $this->db->query($sql)->getRow();
        return $query;
    }

    public function getPTKProvinsi()
    {
        $sql = "SELECT mst.[kode_wilayah]
        ,mst.[nama]
        ,MAX(CASE WHEN sk.[sk_id] IS NOT NULL THEN 1 ELSE 0 END) as keterangan
        FROM Referensi.[ref].[mst_wilayah] AS mst
        LEFT JOIN [TPPK].[dbo].[sk_satgas_provinsi] AS sk
        ON mst.[kode_wilayah] = sk.[kode_wilayah]
        where id_level_wilayah = 1
        GROUP BY mst.[kode_wilayah], mst.[nama]
        order by mst.kode_wilayah";

        $query = $this->db->query($sql)->getRow();
        return $query;
    }

    public function updaterekapwilayah($level_wilayah, $kode_wilayah, $status)
    {

        $sql1 = "UPDATE [TPPK].[dbo].[rekap_satgas]
                SET jml_satgas_provinsi = :statusnya:, jml_satgas_kab_kota = (
                    SELECT SUM(jml_satgas_kab_kota) as jumlah
                    FROM [TPPK].[dbo].[rekap_satgas]
                    WHERE id_level_wilayah = 2 AND LEFT(kode_wilayah, 2) = :kode2:
                    GROUP BY mst_kode_wilayah
                )
                WHERE id_level_wilayah = 1 AND kode_wilayah = :kode:";
        // $sql1 = "UPDATE [TPPK].[dbo].[rekap_satgas] SET jml_satgas_provinsi=1
        //         where id_level_wilayah = 1 AND kode_wilayah=:kode:";
        $sql2 = "UPDATE [TPPK].[dbo].[rekap_satgas] SET jml_satgas_kab_kota= :statusnya:
                where id_level_wilayah = 2 AND kode_wilayah=:kode:";

        $sql3 = "UPDATE [TPPK].[dbo].[rekap_satgas]
                SET jml_satgas_kab_kota = (
                    SELECT SUM(jml_satgas_kab_kota) as jumlah
                    FROM [TPPK].[dbo].[rekap_satgas]
                    WHERE id_level_wilayah = 2 AND LEFT(kode_wilayah, 2) = :kode2:
                    GROUP BY mst_kode_wilayah
                )
                WHERE id_level_wilayah = 1 AND kode_wilayah = :kode:";

        if ($level_wilayah == 1) {
            $sql = $sql1;
            $query = $this->db->query($sql, [
                'kode' => $kode_wilayah,
                'kode2' => substr($kode_wilayah, 0, 2),
                'statusnya' => $status
            ]);
        } else {
            $sql = $sql2;
            $query = $this->db->query($sql, [
                'kode' => $kode_wilayah,
                'statusnya' => $status
            ]);

            $sql = $sql3;
            $query = $this->db->query($sql, [
                'kode' => substr($kode_wilayah, 0, 2) . '0000',
                'kode2' => substr($kode_wilayah, 0, 2),
            ]);
        }

        return $query;
    }

    public function update_sk($datask, $skid)
    {
        $sql = "UPDATE [TPPK].[dbo].[sk_satgas_provinsi] SET nomor_sk='" . $datask['nomor_sk'] . "', tanggal_sk='" . $datask['tanggal_sk'] . "' where sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid
        ]);

        return $query;
    }

    public function update_sk_tppk($datask, $skid)
    {
        $sql = "UPDATE [TPPK].[dbo].[sk_satgas_provinsi] SET modified_date=GETDATE(), nama_operator='" . $datask['nama_operator'] . "' where sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid
        ]);

        return $query;
    }

    public function update_jumlah_satgas($kode_wilayah, $jumlah_satgas)
    {
        $sql = "UPDATE [TPPK].[dbo].[rekap_satgas] 
                SET jml_anggota_satgas=:jumlah_satgas: where kode_wilayah = :kode_wilayah:";

        $query = $this->db->query($sql, [
            'jumlah_satgas' => $jumlah_satgas,
            'kode_wilayah' => $kode_wilayah,
        ]);

        return $query;
    }

    public function update_satgas_valid($kode_wilayah)
    {
        $sql = "UPDATE [TPPK].[dbo].[rekap_satgas] 
                SET jml_kab_kota_valid= (SELECT count(sk_id) as jml_sk_valid
                FROM [TPPK].[dbo].[sk_satgas_provinsi] 
                where left(kode_wilayah,2)=:kode_wilayah2: and id_level_wilayah=2 and status_sk=2) where kode_wilayah = :kode_wilayah: and id_level_wilayah=2";

        // echo $sql;
        // die();

        $query = $this->db->query($sql, [
            'kode_wilayah2' => substr($kode_wilayah, 0, 2),
            'kode_wilayah' => $kode_wilayah,
        ]);

        return $query;
    }


    public function getDaftarSKSatgasBaru($kodeprov)
    {
        $sql1 = "SELECT t1.*, rf.nama, t3.* 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
				JOIN (SELECT LEFT(t1.kode_wilayah, 2) AS induk_kode_wilayah, 
				   COUNT(t1.kode_wilayah) AS jumlah_sk_kabupaten_kota,
				   COUNT(CASE WHEN (t1.status_sk = 2) THEN 1 ELSE NULL END) AS jumlah_status_ok
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                                                AND t1.create_date = t2.max_create_date 
                WHERE t1.id_level_wilayah = 2
                GROUP BY LEFT(t1.kode_wilayah, 2)) t3 ON LEFT(t1.kode_wilayah,2) = t3.induk_kode_wilayah
                    WHERE t1.id_level_wilayah = 1
                    ORDER BY create_date;";

        $sql1 = "SELECT t1.*, rf.nama 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
                    WHERE t1.id_level_wilayah = 2 
                    ORDER BY create_date;";

        $sql2 = "SELECT t1.*, rf.nama 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
                    WHERE t1.id_level_wilayah = 2 AND LEFT(t1.kode_wilayah,2) = LEFT(:kode:,2)
                    ORDER BY create_date;";


        if ($kodeprov != null) {
            $sql = $sql2;
            $query = $this->db->query($sql, [
                'kode' => $kodeprov
            ])->getResultArray();
        } else {
            $sql = $sql1;
            $query = $this->db->query($sql)->getResultArray();
        }

        return $query;
    }

    public function setsksesuai($skid, $opsi)
    {
        $sql = "UPDATE [TPPK].[dbo].[sk_satgas_provinsi] SET status_sk=:opsi: where sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid,
            'opsi' => $opsi
        ]);

        return $query;
    }

    public function setsktppksesuai($skid, $opsi)
    {
        $tanggal_sekarang = date("Y-m-d H:i:s");
        $sql = "UPDATE [TPPK].[dbo].[sk_tppk] SET status_sk=:opsi: AND modified_date=" . $tanggal_sekarang . " where sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid,
            'opsi' => $opsi
        ]);

        return $query;
    }

    public function getDaftarSKKab($kodekkota)
    {

        $sql = "SELECT * 
                FROM [TPPK].[dbo].[sk_tppk] sk 
                JOIN [TPPK].[rpt].[rekap_tppk] sp ON sp.kode_wilayah=sk.npsn
                where id_level_wilayah = 4 AND 
                bentuk_pendidikan NOT IN ('SLB', 'SMA', 'SMK') AND LEFT(mst_kode_wilayah,4) = :kodekota4: ORDER BY status_sk";

        $query = $this->db->query($sql, [
            'kodekota4' => substr($kodekkota, 0, 4)
        ])->getResultArray();

        return $query;
    }

    public function getDaftarSKProv($kodekprov)
    {
        $sql = "SELECT * 
                FROM [TPPK].[dbo].[sk_tppk] sk 
                JOIN [TPPK].[rpt].[rekap_tppk] sp ON sp.kode_wilayah=sk.npsn
                where id_level_wilayah = 4 AND 
                bentuk_pendidikan IN ('SLB', 'SMA', 'SMK') AND 
                LEFT(mst_kode_wilayah,2) = :kodekprov: ";

        $query = $this->db->query($sql, [
            'kodekprov' => substr($kodekprov, 0, 2)
        ])->getResultArray();

        return $query;
    }

    public function simpan_log_userlogin()
    {

        $this->db = \Config\Database::connect();

        $sql = "INSERT INTO [TPPK].[dbo].[statuserlogin] (username, login_time, nama, jenis_instansi_id, wilayah_akses) values ('" . session()->get('username') . "',GETDATE(),'" . session()->get('nama') . "','" . session()->get('jenis_instansi_id') . "','" . session()->get('wilayah_akses') . "')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function tesdb()
    {
        $sql = "SELECT *
                FROM TPPK.dbo.sk_satgas_provinsi
                ORDER BY create_date";

        $query = $this->db->query($sql)->getResult();
        return $query;
    }

    public function cek_sk_npsn($hal)
    {
        $sql = "DECLARE @Halaman INT = " . $hal . "
                DECLARE @JumlahPerHalaman INT = 1000

                SELECT 
                    q1.[kode_wilayah],
                    q1.[wilayah],
                    q1.[jml_tppk],
                    q2.[sekolah_id],
                    q2.[npsn],
                    q2.sekolah_id,
                    q2.[sk_tugas],
                    q2.[tmt_sk_tugas],
                    q2.[tst_sk_tugas]
                FROM 
                    (
                        SELECT [kode_wilayah], [wilayah], [jml_tppk],
                            ROW_NUMBER() OVER (ORDER BY [kode_wilayah]) AS RowNum
                        FROM [TPPK].[rpt].[rekap_tppk] 
                        WHERE jml_tppk > 0 AND id_level_wilayah = 4
                    ) q1
                JOIN 
                    (
                        SELECT [npsn], MAX([sk_tugas]) as [sk_tugas], 
                        MAX([tmt_sk_tugas]) as [tmt_sk_tugas],
                        MAX([tst_sk_tugas]) as [tst_sk_tugas],k.sekolah_id
                        FROM [TPPK].[dbo].[kepanitiaan] k
                        LEFT JOIN Arsip.dbo.sekolah s ON s.sekolah_id = k.sekolah_id
                        where soft_delete_kepanitiaan = 0 AND soft_delete_anggota_panitia = 0
                        GROUP BY [npsn], k.sekolah_id
                    ) q2
                ON 
                    q1.[kode_wilayah] = q2.[npsn]
                WHERE
                    RowNum > (@Halaman - 1) * @JumlahPerHalaman AND RowNum <= @Halaman * @JumlahPerHalaman;
";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function insert_rekap_sk($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.sk_satgas_provinsi');

        $sql = "INSERT INTO TPPK.dbo.sk_tppk (sk_id, kode_wilayah, id_level_wilayah, nomor_sk, tanggal_sk, modified_date, nama_operator, catatan_sk) values ('" . $data['sk_id'] . "','" . $data['kode_wilayah'] . "'," . $data['id_level_wilayah'] . ",'" . $data['nomor_sk'] . "','" . $data['tanggal_sk'] . "',GETDATE(),'" . $data['nama_operator'] . "','')";

        $query = $this->db->query($sql);

        return $query;
    }

    public function input_data_sk($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('TPPK.dbo.sk_tppk');

        $sql = "SELECT * FROM TPPK.dbo.sk_tppk  WHERE sekolah_id='" . $data['sekolah_id'] . "'";
        $query = $this->db->query($sql)->getResult();

        if (!$query) {
            // echo "TIDAK ADA";
            // die();
            $sql2 = "INSERT INTO TPPK.dbo.sk_tppk (sekolah_id, npsn, nomor_sk, tanggal_sk, status_sk) values ('" . $data['sekolah_id'] . "','" . $data['npsn'] . "','" . $data['nomor_sk'] . "','" . $data['tanggal_sk'] . "',0)";

            $query2 = $this->db->query($sql2);
        } else {
            echo "NEMU";
            die();
        }
    }
}
