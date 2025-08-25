<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pengajuan_model', 'pengajuan');
        $this->load->model('Rincian_model', 'rincian');
    }

    public function index()
    {
        $email = $this->session->userdata('email');
        $user  = $this->db->get_where('user', ['email' => $email])->row_array();
        $user_id = $user['id'];

       $data['total']     = $this->pengajuan->count_all($user_id);
       $data['proses'] = $this->db->where('status', 'Diproses')->count_all_results('pengajuan');
       $data['setuju'] = $this->db->where('status', 'Disetujui')->count_all_results('pengajuan');
       $data['tolak'] = $this->db->where('status', 'Ditolak')->count_all_results('pengajuan');

        $data['pengajuan']           = $this->pengajuan->get_recent_by_user($user_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_user', $data);
        $this->load->view('templates/topbar_user', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    // Menyimpan rincian ke database
    public function kirim($user_id)
    {
        $user_id = $user['id'];
        $uraian  = $this->input->post('uraian');
        $banyak  = $this->input->post('banyak');
        $satuan  = $this->input->post('satuan');
        $nominal = $this->input->post('nominal');
        $jumlah  = $this->input->post('jumlah');

        foreach ($uraian as $i => $u) {
            if(trim($u) != '') {
                $this->rincian->insert([
                    'user_id'      => $user_id,
                    'pengajuan_id' => $pengajuan_id,
                    'uraian'       => $u,
                    'banyak'       => $banyak[$i],
                    'satuan'       => $satuan[$i],
                    'nominal'      => $nominal[$i],
                    'jumlah'       => $jumlah[$i],
                    'status'       => 'Terkirim'
                ]);
            }
        }

         $this->db->where('id', $pengajuan_id);
        $this->db->update('pengajuan', ['status' => 'Menunggu Persetujuan']);

        $this->session->set_flashdata('success', 'Rincian berhasil dikirim ke admin');
        redirect('user/rincian/' . $user_id);
    }

    public function hapus($id)
{
    // Hapus data dari tabel, misal tabel rincian
    $this->db->delete('pengajuan', ['id' => $id]);

    $this->session->set_flashdata('success', 'Data berhasil dihapus!');
    redirect('user/index'); // ganti sesuai halaman list admin
}

public function detail($id)
{
    $data['pengajuan'] = $this->pengajuan->getById($id);

    if (!$data['pengajuan']) {
        show_404(); // ID tidak ditemukan
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar_user', $data);
    $this->load->view('templates/topbar_user', $data);
    $this->load->view('user/detail', $data);
    $this->load->view('templates/footer');
}

public function simpanRincian()
{
    

    $user_id = $this->input->post('user_id');
    $pengajuan_id = $this->input->post('pengajuan_id');
    $nama_user = $this->input->post('nama_user');
    $keterangan = $this->input->post('keterangan');
    $banyak = $this->input->post('banyak');
    $satuan = $this->input->post('satuan');
    $nominal = $this->input->post('nominal');


    for ($i = 0; $i < count($keterangan); $i++) {
        if (!empty($keterangan[$i])) {

            $banyakVal  = (int)str_replace('.', '', $banyak[$i]);
            $nominalVal = (int)str_replace('.', '', $nominal[$i]);

             $jumlah = $banyakVal * $nominalVal;
             
            $data = [
                'user_id' => $user_id,
                'pengajuan_id' => $pengajuan_id,
                'nama_user' => trim($_POST["nama_user"]),
                'keterangan' => $keterangan[$i],
                'banyak' => $banyak[$i],
                'satuan' => $satuan[$i],
                'nominal' => $nominal[$i],
                'jumlah' => $jumlah
            ];
            $this->db->insert('rincian', $data);

             // Update total pengajuan otomatis
            $this->db->select_sum('jumlah');
            $this->db->where('pengajuan_id', $pengajuan_id);
            $total = $this->db->get('rincian')->row()->jumlah;

            $this->db->where('id', $pengajuan_id);
            $this->db->update('rincian', ['jumlah' => $total]);

            $this->session->set_flashdata('success', 'Data rincian berhasil disimpan');
            redirect('user/rincian/'.$pengajuan_id);
            
            if ($this->db->affected_rows() > 0) {
                echo "✅ Data masuk: " . $this->db->last_query() . "<br>";
            } else {
                echo "❌ Gagal insert: " . $this->db->last_query() . "<br>";
            }

        }
    }

    $this->session->set_flashdata('success', 'Data rincian berhasil disimpan');
    redirect('user/rincian/'.$pengajuan_id);
}

public function rincian()
{
    $user_id = $this->session->userdata('id');

    if ($this->input->post()) {
        // Simpan pengajuan
        $user_id = $this->pengajuan->insert([
            'user_id' => $user_id,
            'status'  => 'Terkirim'
        ]);

        $this->db->insert('pengajuan', $pengajuan_data);
        $pengajuan_id = $this->db->insert_id(); 

        // Simpan rincian
        $uraian  = $this->input->post('keterangan');
        $banyak  = $this->input->post('banyak');
        $satuan  = $this->input->post('satuan');
        $nominal = $this->input->post('nominal');
        $jumlah  = $this->input->post('jumlah');

        foreach ($uraian as $i => $u) {
            if (!empty($u)) {
                $this->rincian->insert([
                    'pengajuan_id' => $pengajuan_id,
                    'banyak'       => $banyak[$i],
                    'satuan'       => $satuan[$i],
                    'nominal'      => $nominal[$i],
                    'jumlah'       => $jumlah[$i]
                ]);
            }
        }

        $this->session->set_flashdata('success', 'Pengajuan berhasil dikirim');
        redirect('user');
    }

    $this->loadDashboardView('user/rincian');
}


public function upload()
{
    // 1️⃣ Path upload: folder uploads/dokumen di root project
    $upload_path = FCPATH . 'uploads/dokumen/';

    // 2️⃣ Buat folder otomatis jika belum ada
    if (!is_dir($upload_path)) {
        if (!mkdir($upload_path, 0777, true)) {
            echo "❌ Gagal membuat folder: $upload_path";
            exit;
        }
    }

    // 3️⃣ Config upload
    $config['upload_path']   = $upload_path;
    $config['allowed_types'] = 'pdf|jpg|png|docx';
    $config['max_size']      = 2048;

    $this->load->library('upload', $config);

    // 4️⃣ Pastikan session user_id ada
    $user_id = $this->session->userdata('id');

    

    // 5️⃣ Upload file
   if (!$this->upload->do_upload('dokumen')) {
        $error = $this->upload->display_errors('', ''); // tanpa <p> tag
        $this->session->set_flashdata('error', 'Upload gagal: ' . $error);
        redirect('user');
    }

    $fileData = $this->upload->data();

    // 6️⃣ Simpan ke database
    $data = [
        'user_id'     => $user_id,
        'name'        => $fileData['file_name'],
        'file_url'    => 'uploads/dokumen/'.$fileData['file_name'],
        'type'        => $fileData['file_type'],
        'size'        => $fileData['file_size'],
        'upload_date' => date('Y-m-d H:i:s'),
        'status'      => 'diproses'
    ];

    if ($this->db->insert('dokumen', $data)) {
        $this->session->set_flashdata('success', 'Dokumen berhasil diupload!');
    } else {
          $db_error = $this->db->error();
        $this->session->set_flashdata('error', 'Gagal menyimpan ke database: ' . $db_error['message']);
    }
     redirect('user/rincian');
}

}


