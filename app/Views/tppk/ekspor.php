<?php
$object = new PHPExcel();

$object->setActiveSheetIndex(0);
$sheet = $object->getActiveSheet();

$sheet->setCellValue('B2', 'DAFTAR SEKOLAH YANG BELUM MEMILIKI TPPK [' . strtoupper($namawilayah) . ']');
$sheet->setCellValue('B3', '[per tanggal: ' . ($tgldownload) . ']');
if ($instansiid <= 2) {

    $column = 1;
    $table_columns = array("No", "Kabupaten", "Kecamatan", "Nama Sekolah", "NPSN", "Bentuk Pendidikan", "Status Sekolah", "Residu Update");
    foreach ($table_columns as $field) {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 5, $field);
        $column++;
    }

    $nomor = 0;
    foreach ($daf_sekolah_non_tppk as $key => $value) {
        $nomor++;
        $takupdate = "";
        if ($value['sekolah_belum_sync'] == 1)
            $takupdate = "tidak update";
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $nomor + 5, $nomor);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $nomor + 5, $value['kota_kab']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $nomor + 5, $value['kecamatan']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $nomor + 5, $value['Sekolah']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $nomor + 5, $value['NPSN']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $nomor + 5, $value['bentuk_pendidikan']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $nomor + 5, $value['status_sekolah']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $nomor + 5, $takupdate);
    }

    $sheet->getColumnDimension('B')->setWidth(6);
    $sheet->getColumnDimension('C')->setWidth(18);
    $sheet->getColumnDimension('D')->setWidth(18);
    $sheet->getColumnDimension('E')->setWidth(40);
    $sheet->getColumnDimension('F')->setWidth(10);
    $sheet->getColumnDimension('G')->setWidth(16);
    $sheet->getColumnDimension('H')->setWidth(12);
    $sheet->getColumnDimension('I')->setWidth(12);

    $style = $sheet->getStyle('F');
    $style->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B2');
    $sheet->mergeCells('B2:H2');
    $style->getFont()->setBold(true);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B3');
    $sheet->mergeCells('B3:H3');
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B4:I4');
    $style->getFont()->setBold(true);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
} else {

    $column = 1;
    $table_columns = array("No", "Kecamatan", "Nama Sekolah", "NPSN", "Bentuk Pendidikan", "Status Sekolah", "Residu Update");
    foreach ($table_columns as $field) {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 5, $field);
        $column++;
    }

    $nomor = 0;
    foreach ($daf_sekolah_non_tppk as $key => $value) {
        $nomor++;
        $takupdate = "";
        if ($value['sekolah_belum_sync'] == 1)
            $takupdate = "tidak update";
        else if ($value['residu_jumlah_siswa'] == 1)
            $takupdate = "jumlah siswa 0";
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $nomor + 5, $nomor);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $nomor + 5, $value['kecamatan']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $nomor + 5, $value['Sekolah']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $nomor + 5, $value['NPSN']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $nomor + 5, $value['bentuk_pendidikan']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $nomor + 5, $value['status_sekolah']);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $nomor + 5, $takupdate);
    }

    $sheet->getColumnDimension('B')->setWidth(6);
    $sheet->getColumnDimension('C')->setWidth(18);
    $sheet->getColumnDimension('D')->setWidth(40);
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->getColumnDimension('F')->setWidth(16);
    $sheet->getColumnDimension('G')->setWidth(12);
    $sheet->getColumnDimension('H')->setWidth(12);

    $style = $sheet->getStyle('D');
    $style->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B2');
    $sheet->mergeCells('B2:G2');
    $style->getFont()->setBold(true);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B3');
    $sheet->mergeCells('B3:G3');
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $style = $sheet->getStyle('B4:H4');
    $style->getFont()->setBold(true);
    $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

$object->getProperties()
    ->setCreator("Puspeka")
    ->setTitle('Daftar Sekolah Non TPPK');

$object->getActiveSheet()->setTitle('Sekolah');
$object->getActiveSheet()->setSelectedCell('A1');

$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');

if (ob_get_contents()) ob_end_clean();

// Set the appropriate headers for the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $namawilayah . '-' . $jenjang . '-' . $tglfile . '.xlsx');
header('Cache-Control: max-age=0');

// Send the Excel file directly to the browser

$object_writer->save('php://output');
exit;
