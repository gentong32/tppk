<?php

use App\Models\M_tppk;

if (!function_exists('cekstatuskeanggotaan')) {
	function cekstatuskeanggotaan($sekolah_id, $ptk_id)
	{
		$model_tppk = new M_tppk();
		$data = $model_tppk->cekketua($sekolah_id);
		$sk_tugas = $data['sk_tugas'];

		$skvalid = $data['status_kadaluwarsa'];
		$ptk_id_ketua = $data['ptk_id'];
		$ptk_id_ketua_login = $data['ptk_id_ketua'];
		$ptk_id_anggota_1_login = $data['ptk_id_anggota_1'];

		if ($ptk_id == $ptk_id_ketua) {
			if ($skvalid == "aktif" && $ptk_id_ketua_login == "" && $ptk_id_ketua != null) {
				$datasimpan = [];
				$datasimpan['sekolah_id'] = $sekolah_id;
				$datasimpan['sk_tugas'] = $sk_tugas;
				$datasimpan['ptk_id_ketua'] = $ptk_id_ketua;
				$datasimpan['ptk_id'] = $ptk_id;
				$model_tppk->update_login_ketua($datasimpan);
			}
			return "ketua";
		} else if ($ptk_id == $ptk_id_anggota_1_login) {
			return "anggota1";
		} else {
			return "anggotalain";
		}
	}
}
