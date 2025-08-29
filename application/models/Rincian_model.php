<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rincian_model extends CI_Model {
    public function __construct()
{
    parent::__construct();

    

    $this->load->model('Pengajuan_model', 'pengajuan');
    $this->load->model('Rincian_model', 'rincian'); // Tambahkan ini
}

    public function insert($data)
    {
        return $this->db->insert('rincian', $data);
    }

    public function getByPengajuan($user_id)
    {
        return $this->db->get_where('rincian', ['user_id' => $user_id])->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('pengajuan', ['id' => $id])->row_array();
    }

    public function getLastByUser($user_id)
{
    return $this->db
        ->where('user_id', $user_id)
        ->order_by('id', 'DESC')
        ->limit(1)
        ->get('pengajuan')
        ->row_array();
}

public function getByPengajuanId($pengajuan_id)
{
    return $this->db->get_where('rincian', ['pengajuan_id' => $pengajuan_id])->result_array();
}

public function getAllWithUser()
{
    $this->db->select('rincian.*, pengajuan.status');
    $this->db->from('rincian');
    $this->db->join('pengajuan', 'rincian.pengajuan_id = pengajuan.id', 'left');
    $query = $this->db->get()->result_array();

     $totals = [];
    foreach ($query as $r) {
        $totals[$r['user_id']] = ($totals[$r['user_id']] ?? 0) + $r['jumlah'];
    }

    return $query;
}


public function getRincianByPengajuanId($pengajuan_id)
{
    return $this->db->get_where('rincian', ['pengajuan_id' => $pengajuan_id])->result_array();
}

public function getDokumenByPengajuanId($user_id)
{
    return $this->db->get_where('dokumen', ['user_id' => $user_id])->result_array();
}
public function getRincianByNama($nama_user)
{
     $this->db->like('nama_user', $nama_user);
    return $this->db->get('rincian')->result_array();
}
public function getRincianByNamaUser($nama_user)
{
    return $this->db->get_where('rincian', ['nama_user' => $nama_user])->result_array();
}

public function getDaftarRincian($nama_user = null, $created_at = null)
{
    $this->db->select('*');
    $this->db->from('rincian');

    if (!empty($nama_user)) {
        $this->db->like('nama_user', $nama_user);
    }

    if (!empty($created_at)) {
        $this->db->where('DATE(created_at)', $created_at);
    }

    $query = $this->db->get();
    return $query->result_array();
}

}
