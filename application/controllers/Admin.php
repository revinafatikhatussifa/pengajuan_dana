<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->user['role_id'] != 1) {
            redirect('auth/blocked');  
        }
        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Dokumen_model');
        $this->load->model('Laporan_model');
        $this->load->helper('url');

    }

    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['user'] = $this->user; 
        $data['total_pengajuan']     = $this->pengajuan->count_all();
       $data['total'] = $this->db->count_all('pengajuan');
       $data['proses'] = $this->db->where('status', 'Diproses')->count_all_results('pengajuan');
       $data['setuju'] = $this->db->where('status', 'Disetujui')->count_all_results('pengajuan');
       $data['tolak'] = $this->db->where('status', 'Ditolak')->count_all_results('pengajuan');

        $this->loadDashboardView('admin/index', $data);
    }

public function daftar()
{
    $data['title'] = 'Daftar Pengajuan';
    $data['user']  = $this->user; 

    $data['pengajuan'] = $this->pengajuan->getAllPengajuan();
    $data['rincian'] = [];
    
   foreach ($data['pengajuan'] as $key => $p) {
    $data['pengajuan'][$key]['rincian'] = $this->pengajuan->getRincianByUserId($p['user_id']);
    $data['pengajuan'][$key]['pengajuan'] = $this->pengajuan->getPengajuanByUserId($p['user_id']);
}

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_admin', $data);
    $this->load->view('templates/topbar_admin', $data);
    $this->load->view('admin/daftar', $data);
    $this->load->view('templates/footer');
}

public function detail($id)
    {
        $data['title'] = 'Detail Pengajuan';
        $data['user']  = $this->user;

        $data['pengajuan'] = $this->db->get_where('pengajuan', ['id' => $id])->row_array();

        $data['rincian'] = $this->pengajuan->getRincianByPengajuanId($id);
        $data['dokumen'] = $this->pengajuan->getDokumenByPengajuanId($id);

        $this->load->view('admin/detail', $data);
    }

    //cetak daftar
    public function cetak() {
        $data['pengajuan'] = $this->pengajuan->getAllPengajuan(); 
        $this->load->view('admin/cetak', $data);
    }

    //excel daftar
    public function download_excel()
    {
        $this->load->model('Pengajuan_model');

        $pengajuan = $this->Pengajuan_model->getAllPengajuan();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Jabatan');
        $sheet->setCellValue('D1', 'Tempat Tujuan');
        $sheet->setCellValue('E1', 'Tanggal Berangkat');
        $sheet->setCellValue('F1', 'Tanggal Pulang');
        $sheet->setCellValue('G1', 'Status');

        $row = 2;
        $no = 1;
        foreach ($pengajuan as $p) {
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $p['nama']);
            $sheet->setCellValue('C'.$row, $p['jabatan']);
            $sheet->setCellValue('D'.$row, $p['tempat_tujuan']);
            $sheet->setCellValue('E'.$row, $p['tgl_berangkat']);
            $sheet->setCellValue('F'.$row, $p['tgl_pulang']);
            $sheet->setCellValue('G'.$row, $p['status']);
            $row++;
        }

        $filename = "pengajuan_" . date('Y-m-d_His') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

        //pdf daftar
        public function download_pdf()
    {
        $this->load->model('Pengajuan_model');

        $pengajuan = $this->Pengajuan_model->getAllPengajuan();

        require_once FCPATH . 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();

        $html = '<h3 style="text-align:center;">Laporan daftar pengajuan</h3>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">';
        $html .= '<thead style="background-color:#f2f2f2; text-align:center;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tempat Tujuan</th>
                        <th>Tanggal Berangkat</th>
                        <th>Tanggal Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead><tbody>';

        $no = 1;
        foreach ($pengajuan as $p) {
            $html .= '<tr>
                        <td style="text-align:center;">'.$no++.'</td>
                        <td>'.$p['nama'].'</td>
                        <td>'.$p['nama'].'</td>
                        <td>'.$p['jabatan'].'</td>
                        <td>'.$p['tempat_tujuan'].'</td>
                        <td>'.$p['tgl_berangkat'].'</td>
                        <td>'.$p['tgl_pulang'].'</td>
                        <td>'.$p['status'].'</td>
                    </tr>';
        }

        $html .= '</tbody></table>';

        $mpdf->WriteHTML($html);

        $filename = "pengajuan_" . date('Y-m-d_His') . ".pdf";
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit;
    }

    //daftar
    public function updateStatus($id)
    {
        $status = $this->input->post('status');
        if($status) {
        $this->db->where('id', $id);
        $this->db->update('pengajuan', ['status' => $status]);
        $this->pengajuan->updateStatus($id, $status);
        $this->session->set_flashdata('message', 'Status berhasil diperbarui!');
        }
        redirect('admin/daftar');
    }


    public function rincian()
    {
        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Rincian_model', 'rincian');
        $data['tanggal_awal']  = $this->input->get('tanggal_awal') ?? '';
        $data['tanggal_akhir'] = $this->input->get('tanggal_akhir') ?? '';
        $data['rincian'] = $this->rincian->getAllWithUser();
        $pengajuan = $this->pengajuan->getAllPengajuan();

        if($data['tanggal_awal'] && $data['tanggal_akhir']){
                $data['laporan'] = $this->Laporan_model->get_laporan_per_tanggal($data['tanggal_awal'], $data['tanggal_akhir']);
                $data['total']   = $this->Laporan_model->get_total_per_tanggal($data['tanggal_awal'], $data['tanggal_akhir']);
            } else {
                $data['laporan'] = [];
                $data['total']   = 0;
            }

        if (!empty($pengajuan)) {
            foreach ($pengajuan as $p) {
                $p['rincian'] = $this->rincian->getRincianByPengajuanId($p['id']); 
                
            }
        }

        $data['title'] = 'Daftar Rincian';
        $data['user']  = $this->user;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/topbar_admin', $data);
        $this->load->view('admin/rincian', $data);
        $this->load->view('templates/footer');
    }

    public function detrinci($nama_user)
    {
        $nama_user = urldecode($nama_user);
        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Rincian_model', 'rincian');
        
        $data['rincian'] = $this->pengajuan->getRincianByNama($nama_user);
        if (!empty($pengajuan)) {
            foreach ($pengajuan as $p) {
                $p['rincian'] = $this->rincian->getRincianByPengajuanId($p['id']); 
                
            }
        }
        $data['title'] = 'Daftar Rincian';
        $data['user']  = $this->user;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/topbar_admin', $data);
        $this->load->view('admin/detrinci', $data);
        $this->load->view('templates/footer');
    }

    public function dokumen()
    {
        $data['title'] = 'Daftar Upload Dokumen';
        $data['user']  = $this->session->userdata();

        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        
        $data['dokumen'] = $this->Dokumen_model->getAllDokumenWithUser();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('templates/topbar_admin', $data);
        $this->load->view('admin/dokumen', $data);
        $this->load->view('templates/footer');
    }

    public function dokumen_verify($id)
    {
        $this->Dokumen_model->updateStatus($id, 'verified');
        redirect('admin/dokumen');
    }

    public function dokumen_reject($id)
    {
        $reason = $this->input->post('reason');
        $this->Dokumen_model->updateStatus($id, 'rejected', $reason);
        redirect('admin/dokumen');
    }

    public function dokumen_download($id)
    {
        $doc = $this->Dokumen_model->getById($id);
        if ($doc) {
            force_download($doc['file_path'], NULL);
        } else {
            show_404();
        }
    }

    //excel detrinci
    public function download_rincian_excel($nama_user = null)
    {
        $this->load->model('Rincian_model', 'rincian');
        $data['rincian'] = $this->rincian->getRincianByNamaUser(urldecode($nama_user));

        if (empty($data['rincian'])) {
            show_error('Data tidak ditemukan untuk user: ' . $nama_user);
        }

        $this->load->library('excel');
        $spreadsheet = $this->excel->newSpreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Keterangan');
        $sheet->setCellValue('C1', 'Satuan');
        $sheet->setCellValue('D1', 'Nominal');
        $sheet->setCellValue('E1', 'Jumlah');

        $row = 2;
        foreach ($data['rincian'] as $r) {
            $sheet->setCellValue('A' . $row, $r['nama_user']);
            $sheet->setCellValue('B' . $row, $r['keterangan']);
            $sheet->setCellValue('C' . $row, $r['satuan']);
            $sheet->setCellValue('D' . $row, $r['nominal']);
            $sheet->setCellValue('E' . $row, $r['jumlah']);
            $row++;
        }

        $writer = $this->excel->newWriter($spreadsheet);
        $filename = 'Rincian_' . $nama_user . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //pdf detrinci
    public function download_rincian_pdf($nama_user = null)
    {
        $this->load->model('Rincian_model', 'rincian');
        $rincian = $this->rincian->getRincianByNama($nama_user);

        if (!empty($rincian)) {
            
            $data['nama_user'] = $rincian[0]['nama_user'];
        } else {
            $data['nama_user'] = null;
        }
        
        $html = $this->load->view('admin/rincian_pdf', ['rincian' => $rincian], true);

        $this->load->library('Mpdf_library');
        $this->mpdf_library->create($html, "rincian_".date('Y-m-d_His').".pdf", 'D');
    }

    public function laporan()
        {
            $tanggal_awal  = $this->input->get('tanggal_awal') ?? date('Y-m-01'); 
            $tanggal_akhir = $this->input->get('tanggal_akhir') ?? date('Y-m-d'); 
            
            if ($tanggal_awal && $tanggal_akhir) {
                $data['laporan'] = $this->Laporan_model->get_laporan_per_tanggal($tanggal_awal, $tanggal_akhir);
                $data['total']   = $this->Laporan_model->get_total_per_tanggal($tanggal_awal, $tanggal_akhir);
            } else {
                $tanggal_awal  = date('Y-m-01'); // tanggal 1 bulan ini
                $tanggal_akhir = date('Y-m-d');  // hari ini

                $data['laporan'] = $this->Laporan_model->get_laporan_per_tanggal($tanggal_awal, $tanggal_akhir);
                $data['total']   = $this->Laporan_model->get_total_per_tanggal($tanggal_awal, $tanggal_akhir);
            }

            $data['title'] = 'Laporan Harian Pengajuan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/topbar_admin', $data);
            $this->load->view('admin/laporan', $data);
            $this->load->view('templates/footer');
        }
        
        //excel laporan
        public function export_excel_rincian()
        {
            $data['laporan'] = $this->Laporan_model->get_laporan_all();
            $this->load->view('laporan/export_excel', $data);
        }

        //pdf laporan
        public function export_pdf_rincian()
        {
            $this->load->library('pdf'); // dompdf atau tcpdf
            $data['laporan'] = $this->Laporan_model->get_laporan_all();
            $html = $this->load->view('laporan/export_pdf', $data, true);
            $this->pdf->loadHtml($html);
            $this->pdf->render();
            $this->pdf->stream("laporan_pengajuan.pdf");
        }
        //cetak laporan pengajuan
        public function cetak_pengajuan()
{
    $data['pengajuan'] = $this->pengajuan->getAllPengajuan();
    $this->load->view('admin/cetak_pengajuan', $data);
}

//cetak pengajuan
public function cetak_by_nama()
{
    $nama = $this->input->get('nama', TRUE);

    if (empty($nama)) {
        $nama = $this->input->get('nama_user', TRUE);
    }

    if (empty($nama)) {
        show_error("Nama tidak boleh kosong", 400, "Error");
    }

    // Ambil data pengajuan + rincian
    $pengajuan = $this->pengajuan->getPengajuanWithRincian($nama);

    if (empty($pengajuan)) {
        show_error("Data tidak ditemukan untuk nama: " . $nama);
    }

    // Kirim ke view
    $data['pengajuan'] = $pengajuan;
    $data['rincian']   = $pengajuan['rincian']; // agar view bisa akses rincian

    $this->load->view('admin/cetak_pengajuan', $data);
}

public function daftar_rincian()
{
    $nama_user = $this->input->get('nama_user', TRUE);
    $created_at = $this->input->get('created_at', TRUE);

    $this->load->model('Rincian_model');
    $data['rincian'] = $this->Rincian_model->getDaftarRincian($nama_user, $created_at);

    $this->load->view('templates/header');
    $this->load->view('admin/rincian', $data);
    $this->load->view('templates/footer');
}







    }