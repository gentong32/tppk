<?php
if (!function_exists('namabulan_panjang')) {
	function namabulan_panjang($strtanggal)
	{
		$namabulan = array(
			'', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember'
		);



		$hasiltanggal = intval(substr($strtanggal, 8, 2)) . " " . $namabulan[intval(substr($strtanggal, 5, 2))] . " " .
			substr($strtanggal, 0, 4);
		return $hasiltanggal;
	}
}

if (!function_exists('tgl_jam')) {
	function tgl_jam($strtanggal)
	{
		$hasiltanggal = intval(substr($strtanggal, 8, 2)) . "/" . substr($strtanggal, 5, 2) . "/" .
			substr($strtanggal, 0, 4) . " " . substr($strtanggal, 11, 8);
		return $hasiltanggal;
	}
}
