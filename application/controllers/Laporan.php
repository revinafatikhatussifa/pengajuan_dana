<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->helper('url');
    }

    public function index()
    {
         $tanggal_awal  = $this->input->get('tanggal_awal') ?? date('Y-m-01');
         $tanggal_akhir = $this->input->get('tanggal_akhir') ?? date('Y-m-d'); 

         if ($tanggal_awal && $tanggal_akhir) {
            $data['laporan'] = $this->Laporan_model->get_laporan_per_tanggal($tanggal_awal, $tanggal_akhir);
            $data['total']   = $this->Laporan_model->get_total_per_tanggal($tanggal_awal, $tanggal_akhir);
        } else {
            $tanggal_awal  = date('Y-m-01'); 
            $tanggal_akhir = date('Y-m-d');  

            $data['laporan'] = $this->Laporan_model->get_laporan_per_tanggal($tanggal_awal, $tanggal_akhir);
            $data['total']   = $this->Laporan_model->get_total_per_tanggal($tanggal_awal, $tanggal_akhir);
        }

        $this->load->view('admin/laporan', $data);
    }

    // excel laporan
public function export_excel()
{
    require FCPATH . 'vendor/autoload.php';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $tanggal_awal  = $this->input->get('tanggal_awal');
    $tanggal_akhir = $this->input->get('tanggal_akhir');

    $this->db->select('SUM(jumlah) as total');
         $this->db->where('DATE(created_at)', $tanggal);
         $total = $this->db->get('rincian')->row()->total;

         $data['tanggal'] = $tanggal;
         $data['total']   = $total ?? 0;
        
     if ($tanggal_awal && $tanggal_akhir) {
        $this->db->where('DATE(created_at) >=', $tanggal_awal);
        $this->db->where('DATE(created_at) <=', $tanggal_akhir);
    }
    $data = $this->db->get('rincian')->result_array();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Nama');
     $sheet->setCellValue('D1', 'Nominal');
    $sheet->setCellValue('E1', 'Jumlah');

    $row = 2; $no = 1;
    foreach ($data as $d) {
        $sheet->setCellValue('A'.$row, $no++);
        $sheet->setCellValue('B'.$row, date('d-m-Y', strtotime($d['created_at'])));
        $sheet->setCellValue('C'.$row, $d['nama_user']);
        $sheet->setCellValue('D'.$row, $d['nominal']);
        $sheet->setCellValue('E'.$row, $d['jumlah']);
        $grandTotal += $d['jumlah'];
        $row++;
    }

    $sheet->setCellValue('D'.$row, 'TOTAL');
    $sheet->setCellValue('E'.$row, $grandTotal);
   
    $writer = new Xlsx($spreadsheet);
    $filename = "Rincian_".($tanggal ?: date('Y-m-d')).".xlsx";

     if (ob_get_contents()) ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

//pdf laporan
public function export_pdf()
{
    require FCPATH . 'vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf();

    $tanggal_awal  = $this->input->get('tanggal_awal');
    $tanggal_akhir = $this->input->get('tanggal_akhir');

    if ($tanggal_awal && $tanggal_akhir) {
        $this->db->where('DATE(created_at) >=', $tanggal_awal);
        $this->db->where('DATE(created_at) <=', $tanggal_akhir);
    }
    $data = $this->db->get('rincian')->result_array();

    $grandTotal = 0;
    foreach ($data as $d) {
        $grandTotal += $d['jumlah'];
    }

    $html = '<h3 style="text-align:center;">LAPORAN RINCIAN PENGAJUAN</h3>';
    $html .= '<p>Tanggal: ' . ($tanggal_awal ?: '-') . ' s/d ' . ($tanggal_akhir ?: '-') . '</p>';

    $html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">';
    $html .= '<thead>
                <tr style="background-color:#f2f2f2;">
                    <th style="width:5%; text-align:center;">No</th>
                    <th style="width:20%; text-align:center;">Tanggal</th>
                    <th style="width:35%; text-align:center;">Nama</th>
                    <th style="width:20%; text-align:center;">Nominal</th>
                    <th style="width:20%; text-align:center;">Jumlah</th>
                </tr>
              </thead><tbody>';

    $no = 1;
    foreach ($data as $d) {
        $html .= '<tr>
                    <td style="text-align:center;">'.$no++.'</td>
                    <td style="text-align:center;">'.date('d-m-Y', strtotime($d['created_at'])).'</td>
                    <td>'.$d['nama_user'].'</td>
                    <td style="text-align:right;">'.number_format($d['nominal'],0,',','.').'</td>
                    <td style="text-align:right;">'.number_format($d['jumlah'],0,',','.').'</td>
                  </tr>';
    }

    $html .= '<tr style="font-weight:bold;">
                <td colspan="4" style="text-align:right;">TOTAL</td>
                <td style="text-align:right;">'.number_format($grandTotal,0,',','.').'</td>
              </tr>';

    $html .= '</tbody></table>';

    $mpdf->WriteHTML($html);

    $filename = 'Laporan_'.($tanggal_awal ?: date('Y-m-d')).'.pdf';
    $mpdf->Output($filename, 'D'); 
}
}

