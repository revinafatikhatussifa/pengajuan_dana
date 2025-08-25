<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Batasi akses hanya untuk admin (role_id = 1)
        if ($this->user['role_id'] != 1) {
            redirect('auth/blocked');  // Bisa kamu buat halaman blocked untuk akses ditolak
        }
        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Dokumen_model');

    }

    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['user'] = $this->user; // Data user untuk header/topbar
        $data['total_pengajuan']     = $this->pengajuan->count_all();
       $data['total'] = $this->db->count_all('pengajuan');
       $data['proses'] = $this->db->where('status', 'Diproses')->count_all_results('pengajuan');
       $data['setuju'] = $this->db->where('status', 'Disetujui')->count_all_results('pengajuan');
       $data['tolak'] = $this->db->where('status', 'Ditolak')->count_all_results('pengajuan');

        // Load view dashboard admin dengan template lengkap
        $this->loadDashboardView('admin/index', $data);
    }

    // Menampilkan semua pengajuan lengkap
public function daftar()
{
    $data['title'] = 'Daftar Pengajuan';
    $data['user']  = $this->user; // data user untuk topbar/header

    // Ambil semua pengajuan
    $data['pengajuan'] = $this->pengajuan->getAllPengajuan();
    $data['rincian'] = [];
    
   foreach ($data['pengajuan'] as $key => $p) {
    $data['pengajuan'][$key]['rincian'] = $this->pengajuan->getRincianByUserId($p['user_id']);
    $data['pengajuan'][$key]['pengajuan'] = $this->pengajuan->getPengajuanByUserId($p['user_id']);
}


    // Load view lengkap dengan template
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

        // ambil data pengajuan
        $data['pengajuan'] = $this->db->get_where('pengajuan', ['id' => $id])->row_array();

        // ambil rincian & dokumen
        $data['rincian'] = $this->pengajuan->getRincianByPengajuanId($id);
        $data['dokumen'] = $this->pengajuan->getDokumenByPengajuanId($id);

        $this->load->view('admin/detail', $data);
    }

public function cetak() {
    $data['pengajuan'] = $this->pengajuan->getAllPengajuan(); // ambil semua data pengajuan
    $this->load->view('admin/cetak', $data); // view khusus cetak
}

    public function download_excel()
    {
        $this->load->model('Pengajuan_model');

        // Ambil semua pengajuan
        $pengajuan = $this->Pengajuan_model->getAllPengajuan();

        // Buat objek spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Tempat Tujuan');
        $sheet->setCellValue('D1', 'Tanggal Berangkat');
        $sheet->setCellValue('E1', 'Tanggal Pulang');
        $sheet->setCellValue('F1', 'Status');

        // Isi data
        $row = 2;
        $no = 1;
        foreach ($pengajuan as $p) {
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $p['nama']);
            $sheet->setCellValue('C'.$row, $p['tempat_tujuan']);
            $sheet->setCellValue('D'.$row, $p['tgl_berangkat']);
            $sheet->setCellValue('E'.$row, $p['tgl_pulang']);
            $sheet->setCellValue('F'.$row, $p['status']);
            $row++;
        }

        // Output ke browser
        $filename = "pengajuan_" . date('Y-m-d_His') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

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
    $data['rincian'] = $this->rincian->getAllWithUser();
     $pengajuan = $this->pengajuan->getAllPengajuan();

    if (!empty($pengajuan)) {
        foreach ($pengajuan as $p) {
            $p['rincian'] = $this->rincian->getRincianByPengajuanId($p['id']); // perhatikan: pake $p['id'], bukan pengajuan_id
            
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
    $this->load->model('Pengajuan_model', 'pengajuan');
    $this->load->model('Rincian_model', 'rincian');
    
      $data['rincian'] = $this->pengajuan->getRincianByNama($nama_user);


    if (!empty($pengajuan)) {
        foreach ($pengajuan as $p) {
            $p['rincian'] = $this->rincian->getRincianByPengajuanId($p['id']); // perhatikan: pake $p['id'], bukan pengajuan_id
            
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

// Di Admin.php
public function dokumen()
{
    $data['title'] = 'Daftar Upload Dokumen';
    $data['user']  = $this->session->userdata();

    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // Ambil semua dokumen beserta info user
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

}

