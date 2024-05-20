<?php

namespace App\Models;

use CodeIgniter\Model;
use PDOException;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

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

    public function getJudulProp($instansiid, $kode_wilayah)
    {
        if ($instansiid == 1) {
            $cekdigit34 = substr($kode_wilayah, 2, 2);
            $cekdigit56 = substr($kode_wilayah, 4, 2);
            if ($cekdigit34 == "00") {
                $jmlkode = 2;
                $levelwil = 1;
            } else if ($cekdigit56 == "00") {
                $jmlkode = 4;
                $levelwil = 2;
            } else {
                $jmlkode = 6;
                $levelwil = 3;
            }
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $jmlkode = 2;
            $levelwil = 1;
        } else if ($instansiid == 3) {
            $jmlkode = 4;
            $levelwil = 2;
        }

        // echo $instansiid;
        // die();

        $padded_string = str_pad(substr($kode_wilayah, 0, $jmlkode), 6, "0");

        $sql = 'SELECT nama FROM Referensi.ref.mst_wilayah  
                WHERE kode_wilayah=:kodewilayah: AND id_level_wilayah = :levelwil:';
        $query = $this->db->query($sql, [
            'kodewilayah'  => $padded_string,
            'levelwil'  => $levelwil
        ]);

        return $query->getRowArray();
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

    public function getInfoSekolah($npsn)
    {
        $sql = "SELECT nama, kode_wilayah, sekolah_id FROM Arsip.dbo.sekolah
                WHERE npsn=:npsn:";

        $query = $this->db->query($sql, [
            'npsn'  => $npsn,
        ]);

        return $query->getRowArray();
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

    public function getNPSNSekolah($sekolah_id)
    {
        $sql = "SELECT * FROM Arsip.dbo.sekolah WHERE sekolah_id=:kode:";

        $query = $this->db->query($sql, [
            'kode'  => $sekolah_id
        ]);

        return $query->getRow();
    }

    public function getPTK($kodeinstansi)
    {
        $sql = "SELECT ptk_id,nama,jenis_ptk,a.jenis_ptk_id 
                FROM Arsip.dbo.ptk a
                JOIN [Referensi].[ref].[jenis_ptk] r ON a.jenis_ptk_id=r.jenis_ptk_id
                WHERE sekolah_id = :sekolahid: AND aktif=1 AND soft_delete = 0";

        $sql = "SELECT * 
                FROM [arsip].[dbo].[ptk_terdaftar] ptk1
                LEFT JOIN arsip.dbo.ptk ptk ON ptk.ptk_id=ptk1.ptk_id 
                where ptk.aktif=1 AND ptk1.jenis_ptk_id=20 AND ptk1.sekolah_id=:sekolahid: 
                AND tahun_ajaran_id = (SELECT MAX(tahun_ajaran_id) FROM Referensi.ref.tahun_ajaran WHERE expired_date IS NULL) AND ptk1.Soft_delete=0 AND ptk1.jenis_keluar_id IS NULL
                ORDER BY 
                ptk1.ptk_induk DESC, 
                CASE WHEN ptk1.ptk_induk = 1 THEN 0 ELSE 1 END,
                tanggal_surat_tugas DESC";

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

    public function getSekolahuId($sekolah_id)
    {
        $sql = "SELECT nama, npsn FROM [arsip].[dbo].[sekolah] where sekolah_id=:sekolah_id:";
        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id,
        ]);

        return $query->getRowArray();
    }

    public function getSekolah($npsn)
    {

        if ($npsn == "99999999") {
            $sql = "SELECT instansi_id,kode_instansi,nama,kode_instansi as npsn,kode_wilayah
                FROM [TPPK].[dbo].[sekolahdummy] i
                -- LEFT JOIN [arsip].[dbo].[sekolah] s ON s.sekolah_id = i.instansi_id 
                WHERE kode_instansi = :npsn:";
        } else {
            $sql = "SELECT sekolah_id as instansi_id,'' as kode_instansi, s.nama as nama_sekolah, s.nama as nama, npsn, s.kode_wilayah as kode_wilayah, status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
            FROM [arsip].[dbo].[sekolah] s
            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
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

        $sql = "SELECT * FROM Arsip.[dbo].[instansi_pengguna] ipg
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
        AND (soft_delete is null OR soft_delete=0)
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
        WHERE s.sk_id = :skid: ORDER BY anggotake";

        $query = $this->db->query($sql, [
            'skid' => $skid
        ]);

        return $query->getResultArray();
    }

    public function getDaftarAnggota($idinstansi)
    {
        $sql = "SELECT (CASE WHEN UPPER(peran_ang) LIKE 'PELINDUNG%' THEN 1
             WHEN UPPER(peran_ang) LIKE 'PEMBINA%' THEN 2
             WHEN UPPER(peran_ang) LIKE 'PENGARAH%' THEN 3
             WHEN UPPER(peran_ang) LIKE 'PENANGGUNG%' THEN 4
             WHEN UPPER(peran_ang) LIKE 'KETUA%' THEN 5
             WHEN UPPER(peran_ang) LIKE 'WAKIL%' THEN 6
             WHEN UPPER(peran_ang) LIKE 'SEKRETARIS%' THEN 7
             WHEN UPPER(peran_ang) LIKE 'BENDAHARA%' THEN 8
             WHEN UPPER(peran_ang) LIKE 'HUMAS%' THEN 9
             WHEN UPPER(peran_ang) LIKE 'KOOR%' THEN 10
             WHEN UPPER(peran_ang) LIKE 'KORD%' THEN 11
             WHEN UPPER(peran_ang) LIKE 'SEKSI%' THEN 12
             ELSE 13 END
    ) AS urutan, (CASE WHEN k.ptk_id is NULL THEN 0 ELSE 1 END) AS urutan2, ua.nama as nama_unsur2,s.nama as nama_sekolah,l.ptk_id_anggota_1,l.ptk_id_anggota_2,l.ptk_id_anggota_3,k.sk_tugas as nomor_sk,* 
        FROM [TPPK].[dbo].[kepanitiaan] k
        LEFT JOIN TPPK.dbo.ref_unsur_anggota ua ON ua.id_unsur_anggota = k.unsur_ang 
        LEFT JOIN Arsip.dbo.ptk p ON p.ptk_id = k.ptk_id
        LEFT JOIN Arsip.dbo.sekolah s ON s.sekolah_id = p.sekolah_id
        LEFT JOIN [Referensi].[ref].[jenis_ptk] r ON r.jenis_ptk_id = p.jenis_ptk_id 
        LEFT JOIN [TPPK].[dbo].[login_tppk] l ON l.sk_tugas = k.sk_tugas 
        WHERE k.sekolah_id = :instansi: AND soft_delete_kepanitiaan=0 AND soft_delete_anggota_panitia=0
        AND tmt_sk_tugas = (SELECT MAX(tmt_sk_tugas) 
                      FROM [TPPK].[dbo].[kepanitiaan] 
                      WHERE sekolah_id = :instansi: AND soft_delete_kepanitiaan=0 AND soft_delete_anggota_panitia=0) AND (tst_sk_tugas IS NULL 
         OR tst_sk_tugas = (SELECT MAX(tst_sk_tugas) 
                            FROM [TPPK].[dbo].[kepanitiaan] 
                            WHERE sekolah_id = :instansi: 
                            AND soft_delete_kepanitiaan = 0 
                            AND soft_delete_anggota_panitia = 0))
        ORDER BY urutan, urutan2 DESC, k.nm_ang ASC ";

        $query = $this->db->query($sql, [
            'instansi' => $idinstansi
        ]);

        return $query;
    }

    public function getDaftarAnggotaAktif($sekolah_id)
    {
        $sql = "SELECT [nm_ang]
                ,[no_kontak]
                ,[unsur_ang]
                ,[peran_ang]
                ,[ptk_id]
                FROM [TPPK].[dbo].[kepanitiaan]
                where tmt_sk_tugas = (SELECT 
                        MAX(tmt_sk_tugas) AS max_tmt_sk_tugas 
                    FROM 
                        [TPPK].[dbo].[kepanitiaan] 
                    WHERE 
                        sekolah_id = :sekolah_id:
                    GROUP BY 
                        sekolah_id) AND soft_delete_kepanitiaan=0 AND soft_delete_anggota_panitia=0 AND sekolah_id = :sekolah_id:";

        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id
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
                ,[sekolah_belum_sync]
                ,[sekolah_sudah_sync]
                ,[residu_sk_lebih_dari_2_tahun]
                ,[residu_sk_kadaluarsa]
                ,[residu_ketua_non_ptk]
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

        if ($data['residu'] == "9") {
            $sql = "UPDATE [TPPK].[rpt].[rekap_tppk] SET residu_upload_sk=0 WHERE id_level_wilayah = 4 AND kode_wilayah = :npsn:";
        } else {
            $sql = "UPDATE [TPPK].[rpt].[rekap_tppk] SET residu_upload_sk=0, residu=0 WHERE id_level_wilayah = 4 AND kode_wilayah = :npsn:";
        }

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return true;
    }

    public function getTotalTPPK($kode, $level, $jenjang = 'semua', $bentuk = 'semua', $status = 'semua')
    {
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
                ,[sekolah_sudah_sync] as tot_sekolah_sudah_sync
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
                ,[sekolah_sudah_sync] as tot_sekolah_sudah_sync
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
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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

    public function getTotalTPPK_npsn($npsn)
    {

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
                where kode_wilayah=:npsn: 
                ORDER BY kode_wilayah";

        $query = $this->db->query($sql1, [
            'npsn'  => $npsn,
        ]);

        return $query;
    }

    public function getTotalTPPKDasbor($kode, $level, $jenjang = 'semua', $bentuk = 'semua', $status = 'semua')
    {
        $level++;
        if ($jenjang == "rekappaud") {
            $andbentuk = "(bentuk_pendidikan = 'TK' or bentuk_pendidikan = 'TPA' or bentuk_pendidikan = 'SPS' or bentuk_pendidikan = 'KB' or bentuk_pendidikan = 'SPK TK' or bentuk_pendidikan = 'SPK KB')";
        } else if ($jenjang == "rekapsd") {
            $andbentuk = "(bentuk_pendidikan = 'SD' or bentuk_pendidikan = 'SPK SD')";
        } else if ($jenjang == "rekapsmp") {
            $andbentuk = "(bentuk_pendidikan = 'SMP' or bentuk_pendidikan = 'SPK SMP')";
        } else if ($jenjang == "rekapsma") {
            $andbentuk = "(bentuk_pendidikan = 'SMA' or bentuk_pendidikan = 'SPK SMA')";
        } else if ($jenjang == "rekapsmk") {
            $andbentuk = "(bentuk_pendidikan = 'SMK')";
        } else if ($jenjang == "rekapslb") {
            $andbentuk = "(bentuk_pendidikan = 'SLB')";
        } else if ($jenjang == "rekapkesetaraan") {
            $andbentuk = "(bentuk_pendidikan = 'PKBM' or bentuk_pendidikan = 'SKB')";
        }

        $sql = "SELECT [mst_kode_wilayah]
                ,sum ([jml_satuan_pendidikan]) as tot_jml_satuan_pendidikan
                ,sum ([sekolah_sudah_sync]) as tot_sekolah_sudah_sync
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
                and id_level_wilayah = :levelnya: and 
				" . $andbentuk . " 
                group by [mst_kode_wilayah]";

        $query = $this->db->query($sql, [
            'levelnya'  => $level,
            'kodebaru'  => $kode,
        ]);


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

    public function getlastupdate()
    {
        $sql = "SELECT TOP (1) [last_update]
                FROM [TPPK].[dbo].[kepanitiaan]
                order by last_update DESC";

        $query = $this->db->query($sql)->getRowArray();
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
                    ORDER BY status_sk, create_date;";

        $sql1 = "SELECT t1.*, rf.nama 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
                    WHERE t1.id_level_wilayah = 1 
                    ORDER BY status_sk DESC, create_date;";

        $sql2 = "SELECT t1.*, rf.nama 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
                    WHERE t1.id_level_wilayah = 2 
                    ORDER BY status_sk DESC, create_date;";

        $sql3 = "SELECT t1.*, rf.nama 
                FROM TPPK.dbo.sk_satgas_provinsi t1
                JOIN Referensi.ref.mst_wilayah rf ON rf.kode_wilayah = t1.kode_wilayah 
                JOIN (SELECT kode_wilayah, MAX(create_date) AS max_create_date
                    FROM [TPPK].[dbo].[sk_satgas_provinsi]
                    GROUP BY kode_wilayah) t2 ON t1.kode_wilayah = t2.kode_wilayah 
                    AND t1.create_date = t2.max_create_date
                    WHERE t1.id_level_wilayah = 2 AND LEFT(t1.kode_wilayah,2) = LEFT(:kode:,2)
                    ORDER BY status_sk DESC, create_date;";


        if ($kodeprov == null) {
            $sql = $sql1;
            $query = $this->db->query($sql)->getResultArray();
        } else if ($kodeprov == "kota") {
            $sql = $sql2;
            $query = $this->db->query($sql)->getResultArray();
        } else {
            $sql = $sql3;
            $query = $this->db->query($sql, [
                'kode' => $kodeprov
            ])->getResultArray();
        }

        return $query;
    }

    public function setsksesuai($skid, $opsi, $catatan)
    {
        $sql = "UPDATE [TPPK].[dbo].[sk_satgas_provinsi] SET status_sk=:opsi:, catatan_sk=:catatan: where sk_id = :skid:";

        $query = $this->db->query($sql, [
            'skid' => $skid,
            'opsi' => $opsi,
            'catatan' => $catatan,
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

    public function simpan_log_userlogin_tes()
    {

        $this->db = \Config\Database::connect();

        $sql = "INSERT INTO [TPPK].[dbo].[statuserlogin] (username, login_time, nama, jenis_instansi_id, wilayah_akses) values ('" . session()->get('username') . "',GETDATE(),'" . session()->get('nama') . "','" . session()->get('jenis_instansi_id') . "','" . session()->get('wilayah_akses') . "')";

        echo $sql;

        // $query = $this->db->query($sql);
        // return $query;
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
                DECLARE @JumlahPerHalaman INT = 25000

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

        $sql = "DECLARE @Halaman INT = " . $hal . "
               DECLARE @JumlahPerHalaman INT = 25000

                SELECT 
                    q1.[kode_wilayah],
                    q1.[wilayah],
                    q1.[jml_tppk],
                    q2.[sekolah_id],
                    q2.[npsn],
                    q2.[sk_tugas],
                    q2.[tmt_sk_tugas],
                    q2.[tst_sk_tugas]
                FROM 
                    (
                        SELECT 
                            [kode_wilayah], 
                            [wilayah], 
                            [jml_tppk],
                            ROW_NUMBER() OVER (ORDER BY [kode_wilayah]) AS RowNum
                        FROM 
                            [TPPK].[rpt].[rekap_tppk] 
                        WHERE 
                            jml_tppk > 0 AND id_level_wilayah = 4
                    ) q1
                JOIN 
                    (
                        SELECT 
                            [npsn], 
                            [sk_tugas],
                            [tmt_sk_tugas],
                            [tst_sk_tugas],
                            [sekolah_id]
                        FROM 
                            (
                                SELECT 
                                    [npsn], 
                                    [sk_tugas],
                                    [tmt_sk_tugas],
                                    [tst_sk_tugas],
                                    k.sekolah_id,
                                    ROW_NUMBER() OVER (PARTITION BY [npsn] ORDER BY [tmt_sk_tugas] DESC) AS RowNum
                                FROM 
                                    [TPPK].[dbo].[kepanitiaan] k
                                LEFT JOIN 
                                    Arsip.dbo.sekolah s ON s.sekolah_id = k.sekolah_id
                                WHERE 
                                    soft_delete_kepanitiaan = 0 AND soft_delete_anggota_panitia = 0
                            ) kWithRowNum
                        WHERE 
                            kWithRowNum.RowNum = 1
                    ) q2
                ON 
                    q1.[kode_wilayah] = q2.[npsn]
                WHERE
                    RowNum > (@Halaman - 1) * @JumlahPerHalaman AND RowNum <= @Halaman * @JumlahPerHalaman 
                ORDER BY
                    q2.[tmt_sk_tugas] DESC";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function cek_sk_npsn_satuan($npsn)
    {
        $sql = "SELECT 
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
                    q2.npsn = :npsn:";

        $sql = "SELECT 
                    q1.[kode_wilayah],
                    q1.[wilayah],
                    q1.[jml_tppk],
                    q2.[sekolah_id],
                    q2.[npsn],
                    q2.[sk_tugas],
                    q2.[tmt_sk_tugas],
                    q2.[tst_sk_tugas]
                FROM 
                    (
                        SELECT 
                            [kode_wilayah], 
                            [wilayah], 
                            [jml_tppk],
                            ROW_NUMBER() OVER (ORDER BY [kode_wilayah]) AS RowNum
                        FROM 
                            [TPPK].[rpt].[rekap_tppk] 
                        WHERE 
                            jml_tppk > 0 AND id_level_wilayah = 4
                    ) q1
                JOIN 
                    (
                        SELECT 
                            [npsn], 
                            [sk_tugas],
                            [tmt_sk_tugas],
                            [tst_sk_tugas],
                            [sekolah_id]
                        FROM 
                            (
                                SELECT 
                                    [npsn], 
                                    [sk_tugas],
                                    [tmt_sk_tugas],
                                    [tst_sk_tugas],
                                    k.sekolah_id,
                                    ROW_NUMBER() OVER (PARTITION BY [npsn] ORDER BY [tmt_sk_tugas] DESC) AS RowNum
                                FROM 
                                    [TPPK].[dbo].[kepanitiaan] k
                                LEFT JOIN 
                                    Arsip.dbo.sekolah s ON s.sekolah_id = k.sekolah_id
                                WHERE 
                                    soft_delete_kepanitiaan = 0 AND soft_delete_anggota_panitia = 0
                            ) kWithRowNum
                        WHERE 
                            kWithRowNum.RowNum = 1
                    ) q2
                ON 
                    q1.[kode_wilayah] = q2.[npsn]
                WHERE
                    q2.npsn = :npsn:
                ORDER BY
                    q2.[tmt_sk_tugas] DESC";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
        ]);
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

        $sql = "SELECT * FROM TPPK.dbo.sk_tppk WHERE sekolah_id='" . $data['sekolah_id'] . "'";
        $query = $this->db->query($sql)->getResult();

        if (!$query) {
            // echo "SK NPSN " . $data['npsn'] . " BELUM MASUK TABEL <br>";
            // die();
            $sql2 = "INSERT INTO TPPK.dbo.sk_tppk (sekolah_id, npsn, nomor_sk, tanggal_sk, status_sk) values ('" . $data['sekolah_id'] . "','" . $data['npsn'] . "','" . $data['nomor_sk'] . "','" . $data['tanggal_sk'] . "',0)";

            $query2 = $this->db->query($sql2);
        } else {
            // echo "SK NPSN " . $data['npsn'] . " AMAN <br>";
            // die();
        }
    }

    public function cek_sk_tppk($npsn, $nomor_sk)
    {
        $sql = "SELECT * FROM TPPK.dbo.sk_tppk WHERE npsn=:npsn: 
        AND nomor_sk =:nomor_sk:";
        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nomor_sk' => $nomor_sk,
        ]);

        return $query->getResult();
    }

    public function cek_sk_belum_ditabel()
    {
        $sql = "WITH SK_Pengajuan AS (
                    SELECT 
                    r2.sekolah_id,tmt_sk_tugas,
                    s2.npsn,
                    [sk_tugas]
                FROM 
                (
                    SELECT 
                        sekolah_id,tmt_sk_tugas,
                        [sk_tugas],
                        ROW_NUMBER() OVER (PARTITION BY sekolah_id ORDER BY tmt_sk_tugas DESC) AS row_num
                    FROM 
                        kepanitiaan
                    WHERE soft_delete_kepanitiaan = 0
                ) AS r2
                LEFT JOIN 
                    Arsip.dbo.sekolah s2 ON r2.sekolah_id = s2.sekolah_id
                WHERE 
                    r2.row_num = 1
                )

                SELECT 
                        subquery.npsn,sekolah_id,sk_tugas,tmt_sk_tugas,
                        nomor_sk_terbaru
                    FROM
                    (
                        SELECT 
                            r.kode_wilayah AS npsn,
                            COUNT(s.npsn) AS jumlah_sk,
                            MAX(s.tanggal_sk) AS tanggal_sk_terbaru,
                            nomor_sk AS nomor_sk_terbaru
                        FROM 
                            [TPPK].[rpt].[rekap_tppk] r
                        LEFT JOIN 
                            (
                                SELECT 
                                    *,
                                    ROW_NUMBER() OVER (PARTITION BY npsn ORDER BY tanggal_sk DESC) AS row_num
                                FROM 
                                    [TPPK].[dbo].[sk_tppk]
                            ) s ON r.kode_wilayah = s.npsn
                        WHERE 
                            id_level_wilayah = 4 AND jml_tppk > 0
                        GROUP BY 
                            r.kode_wilayah, nomor_sk
                    ) subquery 
                    LEFT JOIN 
                    SK_Pengajuan sk ON subquery.npsn = sk.npsn
                    WHERE 
                        jumlah_sk = 0";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getallnpsn($hal)
    {
        $sql = "
        DECLARE @baris_per_halaman INT = 10000;
        DECLARE @offset INT = (" . $hal . " - 1) * @baris_per_halaman;

        SELECT tp.kode_wilayah AS npsn, s.sekolah_id, sk_tugas, tmt_sk_tugas 
        FROM TPPK.rpt.rekap_tppk tp 
        LEFT JOIN arsip.dbo.sekolah s ON tp.kode_wilayah = s.npsn
        LEFT JOIN TPPK.dbo.kepanitiaan k ON k.sekolah_id = s.sekolah_id
        WHERE id_level_wilayah = '4' 
            AND sk_tugas IS NOT NULL 
        GROUP BY tp.kode_wilayah, s.sekolah_id, sk_tugas, tmt_sk_tugas
        ORDER BY npsn
        OFFSET @offset ROWS 
        FETCH NEXT @baris_per_halaman ROWS ONLY";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getnpsntppk($npsn)
    {
        $sql = "SELECT tp.kode_wilayah AS npsn, s.sekolah_id, sk_tugas, tmt_sk_tugas 
        FROM TPPK.rpt.rekap_tppk tp 
        LEFT JOIN arsip.dbo.sekolah s ON tp.kode_wilayah = s.npsn
        LEFT JOIN TPPK.dbo.kepanitiaan k ON k.sekolah_id = s.sekolah_id
        WHERE id_level_wilayah = '4' AND npsn = :npsn: 
            AND sk_tugas IS NOT NULL 
        GROUP BY tp.kode_wilayah, s.sekolah_id, sk_tugas, tmt_sk_tugas
        ORDER BY npsn";
        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getResultArray();
    }

    public function getsiswanikbynisn($npsn, $nisn)
    {
        $sql = "SELECT nik 
        FROM arsip.dbo.peserta_didik pd 
        LEFT JOIN arsip.dbo.sekolah s ON pd.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND nisn = :nisn: and pd.aktif=1";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nisn' => $nisn,
        ]);

        return $query->getRowArray();
    }

    public function getnikbynuptk($npsn, $nuptk, $jenis)
    {
        if ($jenis == 3) {
            $jenisptk = "jenis_ptk_id IN (1,3,4,5,6,12,13,14,15,16,17,60,63)";
        } else if ($jenis == 4) {
            $jenisptk = "jenis_ptk_id NOT IN (1,3,4,5,6,12,13,14,15,16,17,20,60,63)";
        } else if ($jenis == 5) {
            $jenisptk = "jenis_ptk_id IN (20)";
        }

        $sql = "SELECT nik 
        FROM arsip.dbo.ptk ptk 
        LEFT JOIN arsip.dbo.sekolah s ON ptk.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND nuptk = :nuptk: and ptk.aktif=1 and " . $jenisptk;

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nuptk' => $nuptk,
        ]);

        return $query->getRowArray();
    }

    public function getkepsekbynpsn($npsn)
    {
        $sql = "SELECT nik, nuptk, ptk.nama 
        FROM arsip.dbo.ptk ptk 
        LEFT JOIN arsip.dbo.sekolah s ON ptk.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND ptk.aktif=1 AND jenis_ptk_id=20";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
        ]);

        return $query->getRowArray();
    }

    public function getsiswasekolah($npsn, $nik)
    {
        $sql = "SELECT peserta_didik_id, nisn, nik, pd.nama as nama_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, validDukcapil, s.nama as nama_sekolah, nik_ayah, nama_ayah 
        FROM arsip.dbo.peserta_didik pd 
        LEFT JOIN arsip.dbo.sekolah s ON pd.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND nik = :nik: and pd.aktif=1";

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nik' => $nik,
        ]);

        return $query->getRowArray();
    }

    public function getgurunuptk($npsn, $nik)
    {
        $sql = "SELECT ptk_id as peserta_didik_id, nuptk as nisn, nik, pd.nama as nama_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, validDukcapil, s.nama as nama_sekolah
        FROM arsip.dbo.ptk pd 
        LEFT JOIN arsip.dbo.sekolah s ON pd.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND nik = :nik: and pd.aktif=1";

        // echo $sql;

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nik' => $nik,
        ]);

        return $query->getRowArray();
    }

    public function getgurunik($npsn, $nuptk)
    {
        $sql = "SELECT ptk_id as peserta_didik_id, nuptk as nisn, nik, pd.nama as nama_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, validDukcapil, s.nama as nama_sekolah
        FROM arsip.dbo.ptk pd 
        LEFT JOIN arsip.dbo.sekolah s ON pd.sekolah_id = s.sekolah_id
        WHERE npsn = :npsn: AND nik = :nuptk: and pd.master=1 and pd.aktif=1";

        // echo $sql;

        $query = $this->db->query($sql, [
            'npsn' => $npsn,
            'nuptk' => $nuptk,
        ]);

        return $query->getRowArray();
    }

    public function getkebutuhankhusus($peserta_didik_id)
    {
        $sql = "SELECT kebutuhan_khusus, kebutuhan_khusus_id 
                FROM [Datamart].[datamart].[peserta_didik] 
                WHERE peserta_didik_id=:peserta_didik_id:
                ORDER BY semester_id DESC";

        try {
            $query = $this->db->query($sql, [
                'peserta_didik_id' => $peserta_didik_id,
            ]);
            return $query->getRowArray();
        } catch (PDOException $e) {
            // return $query->getRowArray();
        }
    }

    public function getkebutuhankhususptk($ptk_id)
    {
        $sql = "SELECT keahlian_braille, keahlian_bhs_isyarat 
                FROM [Datamart].[datamart].[ptk] 
                WHERE ptk_id=:ptk_id:";

        $query = $this->db->query($sql, [
            'ptk_id' => $ptk_id,
        ]);

        return $query->getRowArray();
    }

    public function get_status_korban()
    {
        $sql = "SELECT status_korban_pelaku_id, nama 
                FROM [TPPK].[ref].[status_korban_pelaku]";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_bentuk_kekerasan()
    {
        $sql = "SELECT bentuk_kekerasan_id, nama 
                FROM [TPPK].[ref].[bentuk_kekerasan]";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function cek_nomor_kasus($npsn)
    {
        $sql = "SELECT * FROM TPPK.dbo.kasus 
                WHERE npsn = :npsn:
                ORDER BY create_date DESC";
        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getRowArray();
    }

    public function carinamasekolah($nama_sekolah, $kode_wilayah)
    {
        $and = "";
        $andkota = "";
        $andkotafull = "";
        $sqlkota = "";
        $jmlkata = 0;
        if ($nama_sekolah == strval(intval($nama_sekolah))) {
            $and = "AND npsn = :npsn: ";
        } else {
            $kata_kunci = explode(' ', $nama_sekolah);

            foreach ($kata_kunci as $kata) {
                $jmlkata++;
                $and .= "AND LOWER(s.nama) LIKE '%" . strtolower($kata) . "%' ";
            }

            $terakhir = end($kata_kunci);
            array_pop($kata_kunci);
            foreach ($kata_kunci as $kata) {
                $andkota .= "AND LOWER(s.nama) LIKE '%" . strtolower($kata) . "%' ";
            }
            $andkotafull = $andkota . "AND LOWER(r2.nama) LIKE '%" . strtolower($terakhir) . "%' ";

            if ($jmlkata > 1)
                $sqlkota = "SELECT top 5 1 as oder, npsn, s.nama as nama_sekolah, s.kode_wilayah,status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
                            FROM [Arsip].[dbo].[sekolah] s
                            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
                            WHERE soft_delete = 0 " . $andkotafull . "

                    UNION ALL ";
        }


        $kode_wilayah4 = substr($kode_wilayah, 0, 4);

        $sql = "SELECT TOP 5 npsn, MAX(nama_sekolah) AS nama_sekolah,
                MAX(kode_wilayah) AS kode_wilayah,
                MAX(status_sekolah) AS status_sekolah,
                MAX(provinsi) AS provinsi,
                MAX(kota) AS kota,
                MAX(kecamatan) AS kecamatan
                FROM (
                    " . $sqlkota . "

                    SELECT top 5 2 as oder, npsn, s.nama as nama_sekolah, s.kode_wilayah, status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
                            FROM [Arsip].[dbo].[sekolah] s
                            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
                            WHERE soft_delete = 0 " . $and . " AND left(s.kode_wilayah,4) = :kodewil:

                    UNION ALL 

                    SELECT top 5 3 as oder, npsn, s.nama as nama_sekolah, s.kode_wilayah, status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
                            FROM [Arsip].[dbo].[sekolah] s
                            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
                            WHERE soft_delete = 0 " . $and . " AND left(s.kode_wilayah,4) <> :kodewil:

                    -- UNION 

                    -- SELECT top 5 2 as oder, npsn, s.nama as nama_sekolah, s.kode_wilayah, w.nama as kota
                    --         FROM [Arsip].[dbo].[sekolah] s
                    --         LEFT JOIN Referensi.ref.mst_wilayah w on s.kode_wilayah = w.kode_wilayah
                    --         WHERE soft_delete = 0 " . $andkota . " AND left(s.kode_wilayah,4) = :kodewil:

                    -- UNION

                    -- SELECT top 5 3 as oder, npsn, s.nama as nama_sekolah, s.kode_wilayah, w.nama as kota
                    --         FROM [Arsip].[dbo].[sekolah] s
                    --         LEFT JOIN Referensi.ref.mst_wilayah w on s.kode_wilayah = w.kode_wilayah
                    --         WHERE soft_delete = 0 " . $andkota . " AND left(s.kode_wilayah,4) <> :kodewil:
                ) AS CombinedData
                GROUP BY npsn
                ORDER BY MAX(oder)";

        // echo $sql;

        $query = $this->db->query($sql, [
            'npsn' => $nama_sekolah,
            'kodewil' => $kode_wilayah4,
        ]);

        return $query->getResultArray();
    }

    public function carinamasekolahall($nama_sekolah)
    {
        $and = "";
        $andkota = "";
        $andkotafull = "";
        $sqlkota = "";
        $jmlkata = 0;
        if ($nama_sekolah == strval(intval($nama_sekolah)) || (substr($nama_sekolah, 1) == strval(intval(substr($nama_sekolah, 1))))) {
            $and = "AND npsn = :npsn: ";
        } else {
            $kata_kunci = explode(' ', $nama_sekolah);

            foreach ($kata_kunci as $kata) {
                $jmlkata++;
                $and .= "AND LOWER(s.nama) LIKE '%" . strtolower($kata) . "%' ";
            }

            $terakhir = end($kata_kunci);
            array_pop($kata_kunci);
            foreach ($kata_kunci as $kata) {
                $andkota .= "AND LOWER(s.nama) LIKE '%" . strtolower($kata) . "%' ";
            }
            $andkotafull = $andkota . "AND LOWER(r2.nama) LIKE '%" . strtolower($terakhir) . "%' ";

            if ($jmlkata > 1)
                $sqlkota = "SELECT TOP 100 npsn, s.nama as nama_sekolah, s.kode_wilayah,status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
                            FROM [Arsip].[dbo].[sekolah] s
                            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
                            WHERE soft_delete = 0 " . $andkotafull . "

                    UNION ALL ";
        }


        $sql = "WITH TopSekolah AS (SELECT TOP 100 npsn, MAX(nama_sekolah) AS nama_sekolah,
                MAX(kode_wilayah) AS kode_wilayah,
                MAX(status_sekolah) AS status_sekolah,
                MAX(provinsi) AS provinsi,
                MAX(kota) AS kota,
                MAX(kecamatan) AS kecamatan
                FROM (
                    " . $sqlkota . "

                    SELECT npsn, s.nama as nama_sekolah, s.kode_wilayah, status_sekolah, r1.nama as provinsi, r2.nama as kota, r3.nama as kecamatan
                            FROM [Arsip].[dbo].[sekolah] s
                            LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (s.kode_wilayah, 2) AND r1.id_level_wilayah=1 
            LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (s.kode_wilayah, 4) AND r2.id_level_wilayah=2 
            LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (s.kode_wilayah, 6) AND r3.id_level_wilayah=3 
                            WHERE soft_delete = 0 " . $and . ") as g 
                GROUP BY npsn)
                
                SELECT 
                    rt.[kode_wilayah],
                    [wilayah],
                    [id_level_wilayah],
                    [mst_kode_wilayah],
                    [bentuk_pendidikan],
                    ts.[status_sekolah],
                    sk.status_sk,
                    [jenjang_sekolah],
                    [residu] as tot_residu,
                    [residu_kepsek] as tot_residu_kepsek,
                    [residu_guru] as tot_residu_guru,
                    [residu_komite] as tot_residu_komite,
                    [residu_upload_sk] as tot_residu_upload_sk,
                    [residu_siswa] as tot_siswa,
                    [residu_ganjil] as tot_ganjil,
                    [jml_satuan_pendidikan] as tot_jml_satuan_pendidikan,
                    [jml_tppk] as tot_jml_tppk
                FROM 
                    [TPPK].[rpt].[rekap_tppk] rt
                LEFT JOIN 
                    TPPK.dbo.sk_tppk sk ON rt.kode_wilayah = sk.npsn
                INNER JOIN 
                    TopSekolah ts ON rt.kode_wilayah = ts.npsn
                GROUP BY rt.kode_wilayah,[wilayah],
                    [id_level_wilayah],
                    [mst_kode_wilayah],
                    [bentuk_pendidikan],
                    ts.[status_sekolah],
                    sk.status_sk,
                    [jenjang_sekolah],
                    [residu],
                    [residu_kepsek],
                    [residu_guru],
                    [residu_komite],
                    [residu_upload_sk],
                    [residu_siswa],
                    [residu_ganjil],
                    [jml_satuan_pendidikan],
                    [jml_tppk]";

        $query = $this->db->query($sql, [
            'npsn' => $nama_sekolah,
        ]);

        return $query->getResultArray();
    }

    public function get_daf_laporan($npsn)
    {
        $sql = "SELECT k.[kasus_id], [nomor_register], k.tanggal_kejadian, 
                COUNT(CASE WHEN ko.sebagai = 1 THEN 1 END) AS jumlah_korban,
                COUNT(CASE WHEN ko.sebagai IN (2, 3) THEN 1 END) AS jumlah_pelaku,tanggal_pelaporan,k.create_date 
                FROM [TPPK].[dbo].[kasus] k
                LEFT JOIN [TPPK].[dbo].[korban_pelaku] ko ON k.kasus_id = ko.kasus_id 
                LEFT JOIN (
                    SELECT kasus_id, 
                        MAX(tanggal_pelaporan) as tanggal_pelaporan 
                    FROM pelaporan 
                    GROUP BY kasus_id
                ) p_max ON k.kasus_id = p_max.kasus_id
                WHERE k.npsn = :npsn: AND k.soft_delete=0
                GROUP BY k.[kasus_id], k.nomor_register, k.tanggal_kejadian, k.create_date, tanggal_pelaporan
                ORDER BY k.create_date DESC, nomor_register";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getResultArray();
    }

    public function get_daf_provinsi()
    {
        $sql = "SELECT kode_wilayah, nama 
                FROM Referensi.ref.mst_wilayah
                WHERE id_level_wilayah=1 
                ORDER BY nama";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_daf_kota($kode_provinsi)
    {
        $sql = "SELECT kode_wilayah, nama 
                FROM Referensi.ref.mst_wilayah
                WHERE mst_kode_wilayah = :kode_provinsi: AND id_level_wilayah=2 
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'kode_provinsi' => $kode_provinsi
        ]);

        return $query->getResultArray();
    }

    public function get_daf_kecamatan($kode_kota)
    {
        $sql = "SELECT kode_wilayah, nama 
                FROM Referensi.ref.mst_wilayah
                WHERE mst_kode_wilayah = :kode_kota: AND id_level_wilayah=3 
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'kode_kota' => $kode_kota
        ]);

        return $query->getResultArray();
    }

    public function get_daf_desa($kode_kecamatan)
    {
        $sql = "SELECT kode_wilayah, nama 
                FROM Referensi.ref.mst_wilayah
                WHERE mst_kode_wilayah = :kode_kecamatan: AND id_level_wilayah=4 
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'kode_kecamatan' => $kode_kecamatan
        ]);

        return $query->getResultArray();
    }

    private function rekap_tppk_untuk_excel()
    {
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
                ORDER BY r1.kode_wilayah, r2.kode_wilayah";
    }

    private function rekap_jumlah_anggota_tppk_untuk_excel()
    {
        $sql = "SELECT LEFT(s.kode_wilayah,4), w1.nama as Propinsi, w2.nama as Kabkot,
                COUNT(id_ang_panitia) AS jml_anggota
                    ,rp.nama as bentuk_pendidikan
                    ,(CASE WHEN s.status_sekolah=1 THEN 'negeri' ELSE 'swasta' END) as status_sekolah
                FROM [TPPK].[dbo].[kepanitiaan] k
                LEFT JOIN arsip.dbo.sekolah s ON k.sekolah_id = s.sekolah_id
                LEFT JOIN Referensi.ref.bentuk_pendidikan rp ON rp.bentuk_pendidikan_id = s.bentuk_pendidikan_id
                LEFT JOIN Referensi.ref.mst_wilayah w1 ON left(w1.kode_wilayah,2) = left(s.kode_wilayah,2) AND w1.id_level_wilayah=1
                LEFT JOIN Referensi.ref.mst_wilayah w2 ON left(w2.kode_wilayah,4) = left(s.kode_wilayah,4) AND w2.id_level_wilayah=2
                WHERE soft_delete_anggota_panitia = 0 AND soft_delete_kepanitiaan = 0
                GROUP BY LEFT(s.kode_wilayah,4)
                    ,w1.nama
                    ,w2.nama
                    ,rp.nama
                    ,s.status_sekolah
                order by left(s.kode_wilayah,4)";
    }

    public function daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang, $offset = null, $limit = null, $searchValue = null, $orderkolom = null, $orderurut = null)
    {
        $andcari = "";
        $pakailimit = "";
        if ($offset >= 0) {
            $pakailimit = "OFFSET " . $offset . " ROWS
                FETCH NEXT " . $limit . " ROWS ONLY";
        }
        if ($searchValue != null) {
            $andcari = "AND (r2.nama LIKE '%$searchValue%' OR r3.nama LIKE '%$searchValue%' OR wilayah LIKE '%$searchValue%' OR rt.kode_wilayah LIKE '%$searchValue%') ";
        }
        if ($instansiid == 1) {
            $cekdigit34 = substr($kodewilayah, 2, 2);
            if ($cekdigit34 == "00")
                $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
            else
                $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
        } else if ($instansiid == 3) {
            $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        }

        $grupjenjang['PAUD'] = array("TK", "TPA", "SPS", "KB", "SPK TK", "SPK KB");
        $grupjenjang['SD'] = array("SD", "SPK SD");
        $grupjenjang['SMP'] = array("SMP", "SPK SMP");
        $grupjenjang['SMA'] = array("SMA", "SPK SMA");
        $grupjenjang['SMK'] = array("SMK");
        $grupjenjang['SLB'] = array("SLB");
        $grupjenjang['KESETARAAN'] = array("PKBM", "SKB");

        $bentuk = $grupjenjang[$jenjang];

        $bentukbentuk = "";
        foreach ($bentuk as $index => $row) {
            $bentukbentuk .= "bentuk_pendidikan='" . $row . "'";

            // Tambahkan "OR" jika bukan elemen terakhir
            if ($index < count($bentuk) - 1) {
                $bentukbentuk .= " OR ";
            }
        }

        $orderan = " ORDER BY r1.kode_wilayah, r2.kode_wilayah, r3.kode_wilayah, sekolah ";

        if ($orderkolom != -1) {
            if ($orderkolom == 1) {
                $orderan = " ORDER BY r2.kode_wilayah " . $orderurut . " ";
            } else if ($orderkolom == 2) {
                $orderan = " ORDER BY r3.kode_wilayah " . $orderurut . " ";
            } else if ($orderkolom == 3) {
                $orderan = " ORDER BY Sekolah " . $orderurut . " ";
            } else if ($orderkolom == 4) {
                $orderan = " ORDER BY rt.kode_wilayah " . $orderurut . " ";
            } else if ($orderkolom == 5) {
                $orderan = " ORDER BY bentuk_pendidikan " . $orderurut . " ";
            } else if ($orderkolom == 6) {
                $orderan = " ORDER BY rt.status_sekolah " . $orderurut . " ";
            } else if ($orderkolom == 7) {
                $orderan = " ORDER BY sekolah_belum_sync " . $orderurut . " ";
            }
        }

        $sql = "SELECT r1.nama as propinsi, r2.nama as kota_kab, r3.nama as kecamatan
                    ,[wilayah] as Sekolah
                    ,rt.kode_wilayah AS NPSN, s.sekolah_id
                    ,[bentuk_pendidikan]
                    ,rt.[status_sekolah]
                    ,[jml_tppk],sekolah_belum_sync
                    ,residu_jumlah_siswa
                FROM [TPPK].[rpt].[rekap_tppk] rt 
                LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (rt.mst_kode_wilayah, 2) 
                AND r1.id_level_wilayah=1 
                LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (rt.mst_kode_wilayah, 4) 
                AND r2.id_level_wilayah=2 
                LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (rt.mst_kode_wilayah, 6) 
                AND r3.id_level_wilayah=3
                LEFT JOIN Arsip.dbo.sekolah s on rt.kode_wilayah = s.npsn 
                WHERE rt.id_level_wilayah=4 AND (" . $bentukbentuk . ") AND " . $kodwil . " AND jml_tppk=0 
                " . $andcari . $orderan . $pakailimit . ";";

        // echo $sql;

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function daf_sekolah_nontppk_count($instansiid, $kodewilayah, $jenjang, $searchValue = null)
    {
        $andcari = "";
        $pakailimit = "";
        if ($searchValue != null) {
            $andcari = "AND (r2.nama LIKE '%$searchValue%' OR r3.nama LIKE '%$searchValue%' OR wilayah LIKE '%$searchValue%' OR rt.kode_wilayah LIKE '%$searchValue%') ";
        }
        if ($instansiid == 1) {
            $cekdigit34 = substr($kodewilayah, 2, 2);
            if ($cekdigit34 == "00")
                $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
            else
                $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
        } else if ($instansiid == 3) {
            $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        }

        $grupjenjang['PAUD'] = array("TK", "TPA", "SPS", "KB", "SPK TK", "SPK KB");
        $grupjenjang['SD'] = array("SD", "SPK SD");
        $grupjenjang['SMP'] = array("SMP", "SPK SMP");
        $grupjenjang['SMA'] = array("SMA", "SPK SMA");
        $grupjenjang['SMK'] = array("SMK");
        $grupjenjang['SLB'] = array("SLB");
        $grupjenjang['KESETARAAN'] = array("PKBM", "SKB");

        $bentuk = $grupjenjang[$jenjang];

        $bentukbentuk = "";
        foreach ($bentuk as $index => $row) {
            $bentukbentuk .= "bentuk_pendidikan='" . $row . "'";

            // Tambahkan "OR" jika bukan elemen terakhir
            if ($index < count($bentuk) - 1) {
                $bentukbentuk .= " OR ";
            }
        }

        $orderan = "";

        $sql = "SELECT COUNT (rt.kode_wilayah) AS total 
                FROM [TPPK].[rpt].[rekap_tppk] rt 
                LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (rt.mst_kode_wilayah, 2) 
                AND r1.id_level_wilayah=1 
                LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (rt.mst_kode_wilayah, 4) 
                AND r2.id_level_wilayah=2 
                LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (rt.mst_kode_wilayah, 6) 
                AND r3.id_level_wilayah=3
                LEFT JOIN Arsip.dbo.sekolah s on rt.kode_wilayah = s.npsn 
                WHERE rt.id_level_wilayah=4 AND (" . $bentukbentuk . ") AND " . $kodwil . " AND jml_tppk=0 
                " . $andcari . $orderan . $pakailimit . ";";

        // echo $sql;

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function daf_sekolah_nontppkok($instansiid, $kodewilayah, $jenjang)
    {

        if ($instansiid == 1) {
            $cekdigit34 = substr($kodewilayah, 2, 2);
            if ($cekdigit34 == "00")
                $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
            else
                $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
        } else if ($instansiid == 3) {
            $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        }

        $grupjenjang['PAUD'] = array("TK", "TPA", "SPS", "KB", "SPK TK", "SPK KB");
        $grupjenjang['SD'] = array("SD", "SPK SD");
        $grupjenjang['SMP'] = array("SMP", "SPK SMP");
        $grupjenjang['SMA'] = array("SMA", "SPK SMA");
        $grupjenjang['SMK'] = array("SMK");
        $grupjenjang['SLB'] = array("SLB");
        $grupjenjang['KESETARAAN'] = array("PKBM", "SKB");

        $bentuk = $grupjenjang[$jenjang];

        $bentukbentuk = "";
        foreach ($bentuk as $index => $row) {
            $bentukbentuk .= "bentuk_pendidikan='" . $row . "'";

            // Tambahkan "OR" jika bukan elemen terakhir
            if ($index < count($bentuk) - 1) {
                $bentukbentuk .= " OR ";
            }
        }

        $sql = "SELECT r1.nama as propinsi, r2.nama as kota_kab, r3.nama as kecamatan
                    ,[wilayah] as Sekolah
                    ,rt.kode_wilayah AS NPSN, s.sekolah_id
                    ,[bentuk_pendidikan]
                    ,rt.[status_sekolah]
                    ,[jml_tppk],sekolah_belum_sync
                    ,residu_jumlah_siswa
                FROM [TPPK].[rpt].[rekap_tppk] rt 
                LEFT JOIN Referensi.ref.mst_wilayah r1 on LEFT(r1.kode_wilayah, 2) = LEFT (rt.mst_kode_wilayah, 2) 
                AND r1.id_level_wilayah=1 
                LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (rt.mst_kode_wilayah, 4) 
                AND r2.id_level_wilayah=2 
                LEFT JOIN Referensi.ref.mst_wilayah r3 on LEFT(r3.kode_wilayah, 6) = LEFT (rt.mst_kode_wilayah, 6) 
                AND r3.id_level_wilayah=3
                LEFT JOIN Arsip.dbo.sekolah s on rt.kode_wilayah = s.npsn 
                WHERE rt.id_level_wilayah=4 AND (" . $bentukbentuk . ") AND " . $kodwil . " AND jml_tppk=0 
                ORDER BY r1.kode_wilayah, r2.kode_wilayah, r3.kode_wilayah, sekolah;";

        // echo $sql;

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function total_daf_sekolah_nontppk($instansiid, $kodewilayah, $jenjang, $searchValue)
    {
        if ($instansiid == 1) {
            $cekdigit34 = substr($kodewilayah, 2, 2);
            if ($cekdigit34 == "00")
                $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
            else
                $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        } else if ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $kodwil = "LEFT(r2.kode_wilayah, 2) = '" . substr($kodewilayah, 0, 2) . "'";
        } else if ($instansiid == 3) {
            $kodwil = "LEFT(r2.kode_wilayah, 4) = '" . substr($kodewilayah, 0, 4) . "'";
        }

        $andcari = "";

        if ($searchValue != "") {
            $searchValue = str_replace('"', "", $searchValue);
            $searchValue = str_replace("'", "", $searchValue);
            $andcari = " AND (r2.nama LIKE '%$searchValue%' OR r3.nama LIKE '%$searchValue%' OR wilayah LIKE '%$searchValue%' OR rt.kode_wilayah LIKE '%$searchValue%');";
        }

        $grupjenjang['PAUD'] = array("TK", "TPA", "SPS", "KB", "SPK TK", "SPK KB");
        $grupjenjang['SD'] = array("SD", "SPK", "SD");
        $grupjenjang['SMP'] = array("SMP", "SPK SMP");
        $grupjenjang['SMA'] = array("SMA", "SPK SMA");
        $grupjenjang['SMK'] = array("SMK");
        $grupjenjang['SLB'] = array("SLB");
        $grupjenjang['KESETARAAN'] = array("PKBM", "SKB");

        $bentuk = $grupjenjang[$jenjang];

        $bentukbentuk = "";
        foreach ($bentuk as $index => $row) {
            $bentukbentuk .= "bentuk_pendidikan='" . $row . "'";

            // Tambahkan "OR" jika bukan elemen terakhir
            if ($index < count($bentuk) - 1) {
                $bentukbentuk .= " OR ";
            }
        }

        $sql = "SELECT count (*) as total
                FROM [TPPK].[rpt].[rekap_tppk] rt 
                LEFT JOIN Referensi.ref.mst_wilayah r2 on LEFT(r2.kode_wilayah, 4) = LEFT (rt.mst_kode_wilayah, 4) 
                AND r2.id_level_wilayah=2 
                WHERE rt.id_level_wilayah=4 AND (" . $bentukbentuk . ") AND " . $kodwil . " AND jml_tppk=0";

        // echo $sql;

        $query = $this->db->query($sql);

        return $query->getRowArray();
    }

    public function getRekapTppkData($instansiid, $kodewilayah, $jenjang)
    {

        $this->db = \Config\Database::connect('default');
        $this->dbrpt = \Config\Database::connect('rpt');
        $dbref = \Config\Database::connect('ref');

        $builder = $this->dbrpt->table('rekap_tppk rt');
        $modelB = new \App\Models\M_ref($dbref);

        $builder->select('r1.nama as propinsi, r2.nama as kota_kab, r3.nama as kecamatan, wilayah as Sekolah, rt.kode_wilayah AS NPSN, bentuk_pendidikan, status_sekolah, jml_tppk');
        $builder->join('dbRef.mst_wilayah1 r1', 'LEFT(r1.kode_wilayah, 2) = LEFT(rt.mst_kode_wilayah, 2) AND r1.id_level_wilayah=1', 'left');
        $builder->join('dbRef.mst_wilayah2 r2', 'LEFT(r2.kode_wilayah, 4) = LEFT(rt.mst_kode_wilayah, 4) AND r2.id_level_wilayah=2', 'left');
        $builder->join('dbRef.mst_wilayah3 r3', 'LEFT(r3.kode_wilayah, 6) = LEFT(rt.mst_kode_wilayah, 6) AND r3.id_level_wilayah=3', 'left');

        if ($instansiid == 1) {
            $cekdigit34 = substr($kodewilayah, 2, 2);
            if ($cekdigit34 == "00") {
                $builder->where("LEFT(r2.kode_wilayah, 2)", substr($kodewilayah, 0, 2));
            } else {
                $builder->where("LEFT(r2.kode_wilayah, 4)", substr($kodewilayah, 0, 4));
            }
        } elseif ($instansiid == 2 || $instansiid == 4 || $instansiid == 18) {
            $builder->where("LEFT(r2.kode_wilayah, 2)", substr($kodewilayah, 0, 2));
        } elseif ($instansiid == 3) {
            $builder->where("LEFT(r2.kode_wilayah, 4)", substr($kodewilayah, 0, 4));
        }

        $grupjenjang['PAUD'] = array("TK", "TPA", "SPS", "KB", "SPK TK", "SPK KB");
        $grupjenjang['SD'] = array("SD", "SPK", "SD");
        $grupjenjang['SMP'] = array("SMP", "SPK SMP");
        $grupjenjang['SMA'] = array("SMA", "SPK SMA");
        $grupjenjang['SMK'] = array("SMK");
        $grupjenjang['SLB'] = array("SLB");
        $grupjenjang['KESETARAAN'] = array("PKBM", "SKB");

        $bentuk = $grupjenjang[$jenjang];

        $builder->groupStart();
        foreach ($bentuk as $index => $row) {
            $builder->orGroupStart();
            $builder->where("bentuk_pendidikan", $row);
            $builder->groupEnd();
        }
        $builder->groupEnd();

        $builder->where('rt.id_level_wilayah', 4);
        $builder->where('jml_tppk', 100);
        $builder->orderBy('r1.kode_wilayah, r2.kode_wilayah, r3.kode_wilayah, Sekolah');

        // $this->db = \Config\Database::connect("default");

        return $builder->get()->getResultArray();
    }

    public function save_kasus($data)
    {
        $noreg = $data['nomor_register'];
        $npsn = $data['npsn'];
        $kejadian = $data['tanggal_kejadian'];
        $kode_wilayah = $data['kode_wilayah'];
        $sql = "INSERT INTO [TPPK].[dbo].[kasus] (nomor_register, npsn, kode_wilayah, tanggal_kejadian) 
        VALUES (:noreg:,:npsn:,:kode_wilayah:,:kejadian:)";

        $query = $this->db->query($sql, [
            'noreg' => $noreg,
            'npsn' => $npsn,
            'kejadian' => $kejadian,
            'kode_wilayah' => $kode_wilayah,
        ]);

        return $query;
    }

    public function get_lastkasus($npsn)
    {
        $sql = "SELECT * FROM [TPPK].[dbo].[kasus]  
        WHERE npsn = :npsn: 
        ORDER BY create_date DESC";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getRowArray();
    }

    public function save_pelaporan($data)
    {
        $kasus_id = $data['kasus_id'];
        $tgl_lapor = $data['tanggal_pelaporan'];
        $tgl_kasus = $data['tanggal_kejadian'];
        $sts_kasus = $data['status_kasus'];
        $alasan_dihentikan = $data['alasan_dihentikan'];
        $bentuk_kekerasan = $data['bentuk_kekerasan'];
        $cakupan_kekerasan = $data['cakupan_kekerasan'];
        $kronologi = $data['kronologi'];
        $tanggalsekarang = date("Y-m-d H:i:s");
        $pencatat = session()->get('username');

        $sql = "INSERT INTO [TPPK].[dbo].[pelaporan] (kasus_id, tanggal_pelaporan, tanggal_kejadian, status_kasus, alasan_dihentikan, bentuk_kekerasan, cakupan_kekerasan, kronologi, create_date, pencatat)
        VALUES (:kasus_id:,:tanggal_pelaporan:, :tanggal_kejadian:, :status_kasus:,:alasan_dihentikan:,:bentuk_kekerasan:,:cakupan_kekerasan:,:kronologi:,:create_date:,:pencatat:)";

        $query = $this->db->query($sql, [
            'kasus_id' => $kasus_id,
            'tanggal_pelaporan' => $tgl_lapor,
            'tanggal_kejadian' => $tgl_kasus,
            'status_kasus' => $sts_kasus,
            'alasan_dihentikan' => $alasan_dihentikan,
            'bentuk_kekerasan' => $bentuk_kekerasan,
            'cakupan_kekerasan' => $cakupan_kekerasan,
            'kronologi' => $kronologi,
            'create_date' => $tanggalsekarang,
            'pencatat' => $pencatat,
        ]);


        return $query;
    }

    public function save_tbkorban($data)
    {
        $this->db->table('korban_pelaku')->insertBatch($data);
    }

    public function get_lastpelaporan($kasus_id)
    {
        $sql = "SELECT * FROM [TPPK].[dbo].[pelaporan]  
        WHERE kasus_id = :kasus_id: 
        ORDER BY create_date DESC";

        $query = $this->db->query($sql, [
            'kasus_id' => $kasus_id
        ]);

        return $query->getRowArray();
    }

    public function get_filter_kekerasan($filter)
    {
        $sql = "SELECT * FROM TPPK.dbo.pelaporan
                WHERE CHARINDEX($filter, bentuk_kekerasan) > 0";
    }

    public function get_rekap_laporan($jenjang)
    {
        $injenjang = "";
        if ($jenjang == "semua") {
            $injenjang = ""; // "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,13,15,27,29,40,43,52,53,54,55)";
        } else if ($jenjang == "dikmen") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,15,29,55)";
        } else if ($jenjang == "dikdas") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,27,40,43,52,53,54)";
        } else if ($jenjang == "PAUD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4)";
        } else if ($jenjang == "SD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (5,53)";
        } else if ($jenjang == "SMP") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (6,54)";
        } else if ($jenjang == "SMA") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,55)";
        } else if ($jenjang == "SMK") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (15)";
        } else if ($jenjang == "SLB") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (29)";
        } else if ($jenjang == "Kesetaraan") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (27,40)";
        }
        $sql = "SELECT r.[kode_wilayah]
                    ,r.nama
                    ,COUNT(CASE WHEN substring(k.kode_wilayah, 3,4) = '0000' THEN 1 END) AS prov
                    ,COUNT(CASE WHEN (substring(k.kode_wilayah, 3,2) != '00' AND substring(k.kode_wilayah, 5,2) = '00') THEN 1 END) AS kota
                    ,COUNT(CASE WHEN substring(k.kode_wilayah, 5,2) != '00' THEN 1 END) AS tppk
                    ,COUNT(CASE WHEN p.status_kasus = 1 THEN 1 END) AS Terbukti
                    ,COUNT(CASE WHEN p.status_kasus = 2 THEN 1 END) AS TidakTerbukti
                    ,COUNT(CASE WHEN p.status_kasus = 3 THEN 1 END) AS Dihentikan
                FROM [TPPK].[dbo].[kasus] k
                left join TPPK.dbo.pelaporan p ON k.kasus_id=p.kasus_id
                left join Referensi.ref.mst_wilayah r ON left(k.kode_wilayah, 2) = left(r.kode_wilayah, 2) AND r.id_level_wilayah=1
                left join Arsip.dbo.sekolah s ON s.npsn=k.npsn AND s.soft_delete=0 AND s.aktif=1
                where k.soft_delete=0 AND k.npsn!='0' " . $injenjang . " 
                group by r.kode_wilayah, r.nama
                ORDER BY r.kode_wilayah";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function get_rekap_laporan_provinsi($kode_provinsi, $jenjang)
    {
        $injenjang = "";
        if ($jenjang == "semua") {
            $injenjang = ""; // "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,13,15,27,29,40,43,52,53,54,55)";
        } else if ($jenjang == "dikmen") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,15,29,55)";
        } else if ($jenjang == "dikdas") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,27,40,43,52,53,54)";
        } else if ($jenjang == "PAUD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4)";
        } else if ($jenjang == "SD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (5,53)";
        } else if ($jenjang == "SMP") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (6,54)";
        } else if ($jenjang == "SMA") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,55)";
        } else if ($jenjang == "SMK") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (15)";
        } else if ($jenjang == "SLB") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (29)";
        } else if ($jenjang == "Kesetaraan") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (27,40)";
        }
        $sql = "SELECT r.[kode_wilayah]
                    ,r.nama
                    ,COUNT(CASE WHEN (substring(k.kode_wilayah, 3,2) != '00' AND substring(k.kode_wilayah, 5,2) = '00') THEN 1 END) AS kota
                    ,COUNT(CASE WHEN substring(k.kode_wilayah, 5,2) != '00' THEN 1 END) AS tppk
                    ,COUNT(CASE WHEN p.status_kasus = 1 THEN 1 END) AS Terbukti
                    ,COUNT(CASE WHEN p.status_kasus = 2 THEN 1 END) AS TidakTerbukti
                    ,COUNT(CASE WHEN p.status_kasus = 3 THEN 1 END) AS Dihentikan
                FROM [TPPK].[dbo].[kasus] k
                left join TPPK.dbo.pelaporan p ON k.kasus_id=p.kasus_id
                left join Referensi.ref.mst_wilayah r ON left(k.kode_wilayah, 4) = left(r.kode_wilayah, 4) AND r.id_level_wilayah=2
                left join Arsip.dbo.sekolah s ON s.npsn=k.npsn AND s.soft_delete=0 AND s.aktif=1
                where k.soft_delete=0 and r.mst_kode_wilayah=:kode_provinsi: " . $injenjang . "
                group by r.kode_wilayah, r.nama
                ORDER BY r.kode_wilayah";

        $query = $this->db->query($sql, [
            'kode_provinsi' => $kode_provinsi
        ]);

        return $query->getResultArray();
    }

    public function get_rekap_laporan_kota($kode_kota, $jenjang)
    {
        $injenjang = "";
        if ($jenjang == "semua") {
            $injenjang = ""; // "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,13,15,27,29,40,43,52,53,54,55)";
        } else if ($jenjang == "dikmen") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,15,29,55)";
        } else if ($jenjang == "dikdas") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,27,40,43,52,53,54)";
        } else if ($jenjang == "PAUD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4)";
        } else if ($jenjang == "SD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (5,53)";
        } else if ($jenjang == "SMP") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (6,54)";
        } else if ($jenjang == "SMA") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,55)";
        } else if ($jenjang == "SMK") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (15)";
        } else if ($jenjang == "SLB") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (29)";
        } else if ($jenjang == "Kesetaraan") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (27,40)";
        }
        $sql = "SELECT r.[kode_wilayah]
                    ,r.nama
                    ,COUNT(CASE WHEN substring(k.kode_wilayah, 5,2) != '00' THEN 1 END) AS tppk
                    ,COUNT(CASE WHEN p.status_kasus = 1 THEN 1 END) AS Terbukti
                    ,COUNT(CASE WHEN p.status_kasus = 2 THEN 1 END) AS TidakTerbukti
                    ,COUNT(CASE WHEN p.status_kasus = 3 THEN 1 END) AS Dihentikan
                FROM [TPPK].[dbo].[kasus] k
                left join TPPK.dbo.pelaporan p ON k.kasus_id=p.kasus_id
                left join Referensi.ref.mst_wilayah r ON left(k.kode_wilayah, 6) = left(r.kode_wilayah, 6) AND r.id_level_wilayah=3
                left join Arsip.dbo.sekolah s ON s.npsn=k.npsn AND s.soft_delete=0 AND s.aktif=1
                where k.soft_delete=0 and r.mst_kode_wilayah=:kode_kota: " . $injenjang . "
                group by r.kode_wilayah, r.nama
                ORDER BY r.kode_wilayah";

        $query = $this->db->query($sql, [
            'kode_kota' => $kode_kota
        ]);

        return $query->getResultArray();
    }

    public function get_rekap_laporan_kecamatan($kode_kecamatan, $jenjang)
    {
        $injenjang = "";
        if ($jenjang == "semua") {
            $injenjang = ""; // "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,13,15,27,29,40,43,52,53,54,55)";
        } else if ($jenjang == "dikmen") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,15,29,55)";
        } else if ($jenjang == "dikdas") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4,5,6,27,40,43,52,53,54)";
        } else if ($jenjang == "PAUD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (1,2,3,4)";
        } else if ($jenjang == "SD") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (5,53)";
        } else if ($jenjang == "SMP") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (6,54)";
        } else if ($jenjang == "SMA") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (13,55)";
        } else if ($jenjang == "SMK") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (15)";
        } else if ($jenjang == "SLB") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (29)";
        } else if ($jenjang == "Kesetaraan") {
            $injenjang = "AND s.bentuk_pendidikan_id iN (27,40)";
        }
        $sql = "SELECT s.nama as nama, s.npsn, s.kode_wilayah
                    ,COUNT(CASE WHEN substring(k.kode_wilayah, 5,2) != '00' THEN 1 END) AS tppk
                    ,COUNT(CASE WHEN p.status_kasus = 1 THEN 1 END) AS Terbukti
                    ,COUNT(CASE WHEN p.status_kasus = 2 THEN 1 END) AS TidakTerbukti
                    ,COUNT(CASE WHEN p.status_kasus = 3 THEN 1 END) AS Dihentikan
                FROM [TPPK].[dbo].[kasus] k
                LEFT JOIN [TPPK].[dbo].[pelaporan] p ON k.kasus_id = p.kasus_id 
                left join Arsip.dbo.sekolah s ON s.npsn=k.npsn AND s.soft_delete=0 AND s.aktif=1
                WHERE LEFT(k.kode_wilayah,6) = :kode_kecamatan: AND k.soft_delete=0 " . $injenjang . "
                GROUP BY s.nama, s.npsn, s.kode_wilayah
                ORDER BY s.nama ASC";

        $query = $this->db->query($sql, [
            'kode_kecamatan' => substr($kode_kecamatan, 0, 6)
        ]);

        return $query->getResultArray();
    }

    public function get_rekap_laporan_sekolah($npsn)
    {
        $sql = "SELECT k.[kasus_id], [nomor_register], k.tanggal_kejadian, MAX(p.tanggal_pelaporan) as tanggal_pelaporan, k.create_date,
                COUNT(CASE WHEN ko.sebagai = 1 THEN 1 END) AS jumlah_korban,
                COUNT(CASE WHEN ko.sebagai IN (2, 3) THEN 1 END) AS jumlah_pelaku 
                FROM [TPPK].[dbo].[kasus] k
                LEFT JOIN [TPPK].[dbo].[pelaporan] p ON k.kasus_id = p.kasus_id 
                LEFT JOIN [TPPK].[dbo].[korban_pelaku] ko ON k.kasus_id = ko.kasus_id
                WHERE k.npsn = :npsn: AND k.soft_delete=0
                GROUP BY k.[kasus_id], k.nomor_register, k.tanggal_kejadian, p.tanggal_pelaporan, k.create_date
                ORDER BY k.create_date DESC";

        $query = $this->db->query($sql, [
            'npsn' => $npsn
        ]);

        return $query->getResultArray();
    }

    public function get_rekap_dinas_provinsi($kode_wilayah)
    {
        $sql = "SELECT k.[kasus_id], [nomor_register], k.tanggal_kejadian, MAX(p.tanggal_pelaporan) as tanggal_pelaporan, k.create_date,
                COUNT(CASE WHEN ko.sebagai = 1 THEN 1 END) AS jumlah_korban,
                COUNT(CASE WHEN ko.sebagai IN (2, 3) THEN 1 END) AS jumlah_pelaku 
                FROM [TPPK].[dbo].[kasus] k
                LEFT JOIN [TPPK].[dbo].[pelaporan] p ON k.kasus_id = p.kasus_id 
                LEFT JOIN [TPPK].[dbo].[korban_pelaku] ko ON k.kasus_id = ko.kasus_id
                WHERE k.kode_wilayah = :kode_wilayah: AND (k.npsn = '' OR k.npsn = k.kode_wilayah) AND k.soft_delete=0
                GROUP BY k.[kasus_id], k.nomor_register, k.tanggal_kejadian, p.tanggal_pelaporan, k.create_date
                ORDER BY k.create_date DESC";

        $query = $this->db->query($sql, [
            'kode_wilayah' => $kode_wilayah
        ]);

        return $query->getResultArray();
    }

    public function get_kebutuhan_khusus()
    {
        $sql = "SELECT [kebutuhan_khusus_id]
                    ,[kebutuhan_khusus]
                FROM [Referensi].[ref].[kebutuhan_khusus]
                where kebutuhan_khusus like '%-%';";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getnamaortu($niksiswa, $nikortu)
    {
        $sql = "SELECT nik, nik_ayah, nik_ibu, nik_wali, nama_ayah, nama_ibu_kandung, nama_wali, kebutuhan_khusus_id_ayah, kebutuhan_khusus_ayah, kebutuhan_khusus_id_ibu, kebutuhan_khusus_ibu 
                FROM [Datamart].[datamart].[peserta_didik]
                where nik = :niksiswa: AND (nik_ayah = :nikortu: OR nik_ibu = :nikortu: OR nik_wali = :nikortu:)";

        $query = $this->db->query($sql, [
            'niksiswa' => $niksiswa,
            'nikortu' => $nikortu,
        ]);

        return $query->getRowArray();
    }

    public function getnamaortunondisabilitas($niksiswa, $nikortu, $statusortu)
    {
        if ($statusortu == "ayah")
            $wherenik = "nik_ayah = :nikortu:";
        else if ($statusortu == "ibu")
            $wherenik = "nik_ibu = :nikortu:";
        else if ($statusortu == "wali")
            $wherenik = "nik_wali = :nikortu:";
        $sql = "SELECT nik, nik_ayah, nik_ibu, nik_wali, nama_ayah, nama_ibu_kandung, nama_wali, 'nondata' as kebutuhan_khusus_id_ayah, 'nondata' as kebutuhan_khusus_ayah, 'nondata' as kebutuhan_khusus_id_ibu, 'nondata' as kebutuhan_khusus_ibu 
                FROM [Arsip].[dbo].[peserta_didik]
                where nik = :niksiswa: AND " . $wherenik;

        $query = $this->db->query($sql, [
            'niksiswa' => $niksiswa,
            'nikortu' => $nikortu,
        ]);

        return $query->getRowArray();
    }

    public function getsekolahtidakaktif($sekolahid)
    {
        $this->dbproses = \Config\Database::connect('proses');

        $builder = $this->dbproses->table('rekap_sekolah_tidak_aktif');

        $query = $builder->select('sekolah_id, kode_semester_tidak_aktif')
            ->whereIn('sekolah_id', $sekolahid)
            ->get();

        return $query->getResultArray();
    }

    public function get_kasus($kasus_id)
    {
        $sql = "SELECT * FROM [TPPK].[dbo].[kasus]  
        WHERE kasus_id = :kasus_id: AND soft_delete=0";

        $query = $this->db->query($sql, [
            'kasus_id' => $kasus_id
        ]);

        return $query->getRowArray();
    }

    public function get_pelaporan($kasus_id)
    {
        $sql = "SELECT * FROM [TPPK].[dbo].[pelaporan]  
        WHERE kasus_id = :kasus_id: and soft_delete = 0 
        ORDER BY tanggal_pelaporan DESC";

        $query = $this->db->query($sql, [
            'kasus_id' => $kasus_id
        ]);

        return $query->getRowArray();
    }

    public function get_daf_siswa($sekolah_id)
    {
        $sql = "SELECT nama, 
                nisn,
                nik
                FROM [Arsip].[dbo].[peserta_didik]
                WHERE aktif = 1 AND soft_delete = 0 AND sekolah_id = :sekolah_id:
                ORDER BY nama ASC";

        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id
        ]);

        return $query->getResultArray();
    }

    public function get_daf_ptk($sekolah_id, $jenis)
    {
        if ($jenis == "p") {
            $jenisptkid = "jenis_ptk_id IN (1,3,4,5,6,12,13,14,15,16,17,60,63)";
        } else if ($jenis == "tk") {
            $jenisptkid = "jenis_ptk_id NOT IN (1,3,4,5,6,12,13,14,15,16,17,20,60,63)";
        } else if ($jenis == "kepsek") {
            $jenisptkid = "jenis_ptk_id = 20";
        }
        $sql = "SELECT nuptk,nama,nik FROM [Arsip].[dbo].[ptk]  
        WHERE " . $jenisptkid . " and aktif = 1 and soft_delete = 0 and sekolah_id=:sekolah_id: 
        ORDER BY nama ASC";

        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id
        ]);

        return $query->getResultArray();
    }

    public function get_kepsek($sekolah_id)
    {
        $sql = "SELECT nuptk,nama,nik FROM [Arsip].[dbo].[ptk]  
        WHERE jenis_ptk_id = 20 and aktif = 1 and soft_delete = 0 and sekolah_id=:sekolah_id: 
        ORDER BY nama ASC";

        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id
        ]);

        return $query->getResultArray();
    }

    public function get_korban_pelaku($kasus_id, $sebagai)
    {
        $sql = "SELECT r1.nama as kota, r2.nama as kecamatan, r3.nama as desa, kk.kebutuhan_khusus, kp.* 
                FROM [TPPK].[dbo].[korban_pelaku] kp
                LEFT JOIN Referensi.ref.mst_wilayah r1 ON LEFT(kp.kode_wilayah,4)=LEFT(r1.kode_wilayah,4) and r1.id_level_wilayah=2
				LEFT JOIN Referensi.ref.mst_wilayah r2 ON LEFT(kp.kode_wilayah,6)=LEFT(r2.kode_wilayah,6) and r2.id_level_wilayah=3
				LEFT JOIN Referensi.ref.mst_wilayah r3 ON LEFT(kp.kode_wilayah,8)=LEFT(r3.kode_wilayah,8) and r3.id_level_wilayah=4
                LEFT JOIN Referensi.ref.kebutuhan_khusus kk ON kp.kebutuhan_khusus_id=kk.kebutuhan_khusus_id 
                WHERE kasus_id = :kasus_id: and sebagai=:sebagai: and soft_delete = 0
                ORDER BY sebagai, urutan";

        $query = $this->db->query($sql, [
            'kasus_id' => $kasus_id,
            'sebagai' => $sebagai,
        ]);

        return $query->getResultArray();
    }

    public function cekketua($sekolah_id)
    {
        $sql = "SELECT 
                (CASE 
                    WHEN UPPER(peran_ang) LIKE 'KETUA%' THEN 1
                    WHEN UPPER(peran_ang) LIKE 'KOOR%' THEN 2
                    WHEN UPPER(peran_ang) LIKE 'KORD%' THEN 3
                    ELSE 4
                END) AS urutan, 
                ua.nama as nama_unsur2,
                l.ptk_id_ketua,
                l.ptk_id_anggota_1,
                l.ptk_id_anggota_2,
                l.ptk_id_anggota_3,
                k.sk_tugas,k.ptk_id,
                CASE 
                    WHEN DATEADD(YEAR, 2, (SELECT MAX(tmt_sk_tugas) 
                                            FROM [TPPK].[dbo].[kepanitiaan] 
                                            WHERE sekolah_id = :sekolah_id: 
                                                AND soft_delete_kepanitiaan = 0 
                                                AND soft_delete_anggota_panitia = 0)
                        ) < GETDATE() THEN 'kadaluwarsa' 
                    ELSE 'aktif' 
                END AS status_kadaluwarsa
            FROM 
                [TPPK].[dbo].[kepanitiaan] k
            LEFT JOIN 
                TPPK.dbo.ref_unsur_anggota ua ON ua.id_unsur_anggota = k.unsur_ang 
            LEFT JOIN 
                Arsip.dbo.ptk p ON p.ptk_id = k.ptk_id
            LEFT JOIN 
                Arsip.dbo.sekolah s ON s.sekolah_id = p.sekolah_id
            LEFT JOIN 
                [Referensi].[ref].[jenis_ptk] r ON r.jenis_ptk_id = p.jenis_ptk_id 
            LEFT JOIN 
                [TPPK].[dbo].[login_tppk] l ON l.sk_tugas = k.sk_tugas 
            WHERE 
                k.sekolah_id = :sekolah_id: 
                AND soft_delete_kepanitiaan = 0 
                AND soft_delete_anggota_panitia = 0
                AND tmt_sk_tugas = (SELECT MAX(tmt_sk_tugas) 
                                    FROM [TPPK].[dbo].[kepanitiaan] 
                                    WHERE sekolah_id = :sekolah_id: 
                                        AND soft_delete_kepanitiaan = 0 
                                        AND soft_delete_anggota_panitia = 0)
                                        ORDER BY urutan";

        $query = $this->db->query($sql, [
            'sekolah_id' => $sekolah_id,
        ]);

        return $query->getRowArray();
    }

    public function getortusiswa($nik, $jenis)
    {
        $nama = $jenis;
        if ($jenis == "ibu")
            $nama = "ibu_kandung";

        $sql = "SELECT nik_" . $jenis . " as nikortu, nama_" . $nama . " as namaortu 
        FROM arsip.dbo.peserta_didik 
        WHERE nik = :nik: and aktif=1";

        $query = $this->db->query($sql, [
            'nik' => $nik,
        ]);

        return $query->getRowArray();
    }

    public function cekpsw($email_user, $password)
    {
        // Mendapatkan password yang dimasukkan oleh pengguna
        $sql = "SELECT psw_user, sebagai 
        FROM tppk.dbo.user_login 
        WHERE email_user = :email_user: AND soft_delete = 0";

        $query = $this->db->query($sql, [
            'email_user' => $email_user,
        ]);

        $hasil = $query->getRowArray();

        $hashedPasswordInput = strtoupper(hash('sha256', $password));
        $stored_hash_password = $hasil['psw_user'];

        if ($hashedPasswordInput === $stored_hash_password) {
            $result = $hasil['sebagai'];
        } else {
            $result = 0;
        }

        return $result;
    }

    public function getAllSKSatgas()
    {
        $sql = "SELECT nomor_sk, sk.kode_wilayah, nomor_sk, nama 
        FROM [TPPK].[dbo].[sk_satgas_provinsi] sk
        LEFT JOIN [Referensi].[ref].[mst_wilayah] w ON sk.kode_wilayah = w.kode_wilayah
        ORDER BY sk.kode_wilayah";
        $query = $this->db->query($sql)->getResultArray();
        return $query;
    }

    public function update_login_ketua($data_simpan)
    {
        $sekolah_id = $data_simpan['sekolah_id'];
        $sk_tugas = $data_simpan['sk_tugas'];
        $ptk_id_ketua = $data_simpan['ptk_id_ketua'];
        $ptk_id = $data_simpan['ptk_id'];
        $sql = "SELECT sk_tugas FROM [TPPK].[dbo].[login_tppk] 
        WHERE sekolah_id = '" . $sekolah_id . "' AND sk_tugas ='" . $sk_tugas . "'";
        $query = $this->db->query($sql)->getResult();

        if ($query) {
            if ($ptk_id != $ptk_id_ketua) {
                $sql2 = "UPDATE [TPPK].[dbo].[login_tppk] SET ptk_id_ketua = '" . $ptk_id_ketua . "'  
                     WHERE sekolah_id = '" . $sekolah_id . "' AND sk_tugas ='" . $sk_tugas . "'";
                $this->db->query($sql2);
            }
        } else {
            $sql2 = "INSERT INTO [TPPK].[dbo].[login_tppk] (sekolah_id, sk_tugas, ptk_id_ketua) VALUES ('" . $sekolah_id . "', '" . $sk_tugas . "', '" . $ptk_id_ketua . "')";
            $this->db->query($sql2);
        }
    }

    public function simpan_login_anggota($sekolah_id, $sk_tugas, $ptk_id)
    {
        $sql = "UPDATE [TPPK].[dbo].[login_tppk] SET ptk_id_anggota_1 = '" . $ptk_id . "'  
                     WHERE sekolah_id = '" . $sekolah_id . "' AND sk_tugas ='" . $sk_tugas . "'";
        $this->db->query($sql);
    }

    public function softdel($kodewilayah, $kode)
    {
        $sql = "UPDATE [TPPK].[dbo].[sk_satgas_provinsi] SET soft_delete = " . $kode . "  
                     WHERE kode_wilayah = '" . $kodewilayah . "'";
        $this->db->query($sql);
    }

    private function query_residu_sekolah_sesuai_jenjang()
    {
        $jenjangPAUD = '1,2,3,4,43,52';
        $jenjangSMP = '6,54';
        $PAUD = "TK, KB, TPA, SPS, SPK TK, dan SPK KB";
        $SMP = "SMP itu SMP dan SPK SMP";
        $sql = "SELECT 
                    w3.nama, w2.nama, w1.nama, s.kode_wilayah,
                    s.sekolah_id,
                    s.nama,
                    s.npsn,
                    s.bentuk_pendidikan_id,
                    r.kode_semester_tidak_aktif
                FROM 
                    arsip.dbo.sekolah s
                JOIN 
                    Dataprocess.rpt.rekap_sekolah_tidak_aktif r ON s.sekolah_id = r.sekolah_id
                JOIN 
                    Referensi.ref.mst_wilayah w1 ON w1.kode_wilayah = LEFT(s.kode_wilayah,6)
                JOIN 
                    Referensi.ref.mst_wilayah w2 ON w1.mst_kode_wilayah = w2.kode_wilayah
                JOIN 
                    Referensi.ref.mst_wilayah w3 ON w2.mst_kode_wilayah = w3.kode_wilayah
                WHERE 
                    r.kode_semester_tidak_aktif > 0 and s.aktif=1 and bentuk_pendidikan_id IN (6,54)";
    }

    private function rekap_kabupaten_per_jenjang()
    {
        $query = "SELECT w.nama
                    ,t.[wilayah]
                    ,[jenjang_sekolah]
                    ,SUM ([jml_satuan_pendidikan]) AS jml_satuan_pendidikan
                    ,SUM ([jml_tppk]) AS jml_tppk
                    ,SUM ([sekolah_belum_sync]) AS sekolah_belum_sync
                    ,SUM ([sekolah_sudah_sync]) AS [sekolah_sudah_sync]
                    ,SUM ([residu_jumlah_siswa]) AS [residu_jumlah_siswa]
                    FROM [TPPK].[rpt].[rekap_tppk] t
                    LEFT JOIN Referensi.ref.mst_wilayah w ON t.mst_kode_wilayah = w.kode_wilayah 
                    where t.id_level_wilayah = 2 and jenjang_sekolah<>'semua'
                    GROUP BY w.nama,jenjang_sekolah,t.[kode_wilayah]
                        ,[wilayah]
                        ORDER BY t.kode_wilayah, jenjang_sekolah DESC
                ";
    }
}
