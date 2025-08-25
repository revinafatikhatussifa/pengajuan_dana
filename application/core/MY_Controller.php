<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $user;

    public function __construct()
    {
        parent::__construct();

        // Cek session user login
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }

        // Ambil data user dari database berdasarkan email session
        $this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Set data user untuk view
        $this->load->vars(['user' => $this->user]);
    }

    // Fungsi load template untuk dashboard sesuai role
    protected function loadDashboardView($view, $data = [])
    {
        // Pastikan $data['title'] ada
        if (!isset($data['title'])) {
            $data['title'] = 'Dashboard';
        }

        // Load header
        $this->load->view('templates/header', $data);

        // Load sidebar sesuai role
        if ($this->user['role_id'] == 1) {
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('templates/topbar_admin', $data);
        } else {
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar_user', $data);
        }

        // Load main content
        $this->load->view($view, $data);

        // Load footer
        $this->load->view('templates/footer', $data);
    }
}
