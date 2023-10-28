<?php

namespace App\Controllers;

use App\Models\M_tools;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Tools extends BaseController
{
    function __construct()
    {
        $this->M_tools = new M_tools();
    }

    public function inf()
    {
        echo phpinfo();
    }

    public function rekaptppk()
    {
        $kode_wilayah = $_GET['npsn'];
        $data1 = $this->M_tools->get_rekap_tppk($kode_wilayah);
        $data2 = $this->M_tools->get_sk_tppk($kode_wilayah);
        $data3 = $this->M_tools->get_anggota_tppk($kode_wilayah);

        $columns = array_keys($data1[0]);
        echo "Rekap TPPK<br>";
        echo "<table border='1'><tr>";
        foreach ($columns as $column) {
            echo "<th>$column</th>";
        }
        echo "</tr>";

        foreach ($data1 as $row) {
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<td>{$row[$column]}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";


        if ($data2) {
            $columns = array_keys($data2[0]);
            echo "SK TPPK<br>";
            echo "<table border='1'><tr>";
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr>";
            foreach ($data2 as $row) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>{$row[$column]}</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Belum upload SK<br>";
        }

        if ($data2) {
            $columns = array_keys($data3[0]);
            echo "Anggota TPPK<br>";
            echo "<table border='1'><tr>";
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr>";
            foreach ($data3 as $row) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>{$row[$column]}</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Belum ada anggota";
        }
    }

    public function eksporData($a)
    {

        // for ($a = 1; $a <= 8; $a++) {
        if ($a == 1)
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        else
            $spreadsheet = IOFactory::load(ROOTPATH . 'public/rekap/rekap_tppk.xlsx');
        $data = $this->M_tools->get_tppk_wilayah($a);


        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Propinsi");
        $sheet->setCellValue('B1', "Kota/kabupaten");
        $sheet->setCellValue('C1', "Kecamatan");
        $sheet->setCellValue('D1', "Bentuk");
        $sheet->setCellValue('E1', "Status");
        $sheet->setCellValue('F1', "Jenjang");
        $sheet->setCellValue('G1', "Jumlah SP");
        $sheet->setCellValue('H1', "Jumlah TPPK");
        $sheet->setCellValue('I1', "Prosentase (%)");

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(20);

        $style = $sheet->getStyle('A1:I1');
        $style->getFont()->setBold(true);
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setAutoFilter('A1:I1');
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode('0.00');


        $spreadsheet->getProperties()
            ->setCreator('TPPK')
            ->setTitle('Data TPPK');

        $spreadsheet->getActiveSheet()->setTitle('Rekap ' . date('d_m_Y'));
        $spreadsheet->getActiveSheet()->setSelectedCell('A1');

        $row = 2 + (($a - 1) * 10000);
        foreach ($data as $item) {

            $sheet->setCellValue('A' . $row, $item['propinsi']);
            $sheet->setCellValue('B' . $row, $item['kota_kab']);
            $sheet->setCellValue('C' . $row, $item['kecamatan']);
            $sheet->setCellValue('D' . $row, $item['bentuk_pendidikan']);
            $sheet->setCellValue('E' . $row, $item['status_sekolah']);
            $sheet->setCellValue('F' . $row, $item['jenjang_sekolah']);
            $sheet->setCellValue('G' . $row, $item['jml_satuan_pendidikan']);
            $sheet->setCellValue('H' . $row, $item['jml_tppk']);
            $sheet->setCellValue('I' . $row, $item['jml_tppk'] * 100 / $item['jml_satuan_pendidikan']);
            $row++;
        }

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="rekap_tppk.xlsx"');
        // header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(ROOTPATH . 'public/rekap/rekap_tppk.xlsx');
        // $writer->save('php://output');
        sleep(15);
        // }
        echo "SELESAI....";
        exit;
    }
}
