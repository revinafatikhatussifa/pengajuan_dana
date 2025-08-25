<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Batasi hanya role user
        if ($this->user['role_id'] != 2) {
            redirect('auth/blocked');
        }

        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Rincian_model', 'rincian');
        $this->load->library('form_validation');

    }

    public function add()
    {
        $user_id = $this->user['id']; // ambil ID dari properti user di MY_Controller

        if (!$user_id) {
            redirect('auth');
        }

        // Validasi form
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('tujuan', 'Tempat Tujuan', 'required|trim');
        $this->form_validation->set_rules('tgl_berangkat', 'Tanggal Berangkat', 'required');
        $this->form_validation->set_rules('tgl_pulang', 'Tanggal Pulang', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Tampilkan form jika validasi gagal
            $data['title'] = 'Buat Pengajuan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar_user', $data);
            $this->load->view('pengajuan/add', $data);
            $this->load->view('templates/footer');
        } else {
            // Data dari form
            $data = [
                'user_id'           => $this->user['id'],
                'nama'              => $this->input->post('nama', true),
                'jabatan'           => $this->input->post('jabatan', true),
                'tempat_tujuan'     => $this->input->post('tujuan', true),
                'tgl_berangkat'     => $this->input->post('tgl_berangkat', true),
                'tgl_pulang'        => $this->input->post('tgl_pulang', true),
                'status'            => 'pending'
            ];

            $this->db->insert('pengajuan', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Pengajuan berhasil disimpan</div>');
            redirect('user');
        }
    }

    public function rinci() 
{
    $user_id = $this->user['id']; // ambil dari MY_Controller

    // Ambil pengajuan user terakhir (misal status pending atau terbaru)
    $data['rincian'] = $this->rincian->getLastByUser($user_id);
 
    $data['pengajuan'] = $this->pengajuan->getLastByUser($user_id);

    if (!$data['rincian']) {
        show_404(); // jika tidak ada data pengajuan
    }

    $data['user_id'] = $user_id; // untuk form

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_user', $data);
    $this->load->view('templates/topbar_user', $data);
    $this->load->view('pengajuan/rinci', $data);
    $this->load->view('templates/footer');

}


}
