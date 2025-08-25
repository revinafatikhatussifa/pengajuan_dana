<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_model extends CI_Model {

    public function insert_pengajuan($data)
    {
        $this->db->insert('pengajuan', $data);
        return $this->db->insert_id(); // kembalikan id pengajuan yang baru
    }

    public function insert_detail($detail)
    {
        // Insert batch data rincian biaya
        $this->db->insert_batch('pengajuan_detail', $detail);
    }

    public function count_all()
{
    return $this->db->count_all('pengajuan');
}


public function count_by_status($status)
{
    return $this->db->where('status', $status)
                    ->from('pengajuan')
                    ->count_all_results();
}

public function count_all_by_user($user_id)
{
    return $this->db->where('user_id', $user_id)
                    ->from('pengajuan')
                    ->count_all_results();
}

public function count_by_status_and_user($user_id, $status)
{
    return $this->db->where('user_id', $user_id)
                    ->where('status', $status)
                    ->from('pengajuan')
                    ->count_all_results();
}


public function get_recent_by_user($user_id)
{
    return $this->db->where('user_id', $user_id)
                    ->order_by('id', 'DESC')
                    ->limit(5)
                    ->get('pengajuan')
                    ->result_array();
}



    public function getRincianByUserId($user_id)
{
    return $this->db->where('user_id', $user_id)->get('rincian')->result_array();
}

public function getPengajuanByUserId($user_id)
{
    return $this->db->where('user_id', $user_id)->get('pengajuan')->result_array();
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
public function insert($data)
    {
        return $this->db->insert('pengajuan', $data);
    }

    public function getPengajuanById($user_id)
{
     if (!$id) return null;
    return $this->db->get_where('pengajuan', ['user_id' => $id])->row_array();
}

public function getRincianByPengajuanId($user_id)
{
    return $this->db->get_where('rincian', ['user_id' => $user_id])->result_array();
}

public function getDokumenByPengajuanId($user_id)
{
    return $this->db->get_where('dokumen', ['user_id' => $user_id])->result_array();
}

 public function getAllPengajuan() {
        $this->db->select('*');
        $this->db->from('pengajuan');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $pengajuan = $query->result_array();

        // Ambil rincian masing-masing pengajuan
        foreach ($pengajuan as &$p) {
            $p['rincian'] = $this->db->get_where('rincian', ['pengajuan_id' => $p['id']])->result_array();
            $p['dokumen'] = $p['dokumen'] ?? null; // sesuaikan kolom dokumen di tabel pengajuan
        }

        return $pengajuan;
    }

    public function updateStatus($id, $status)
{
    $this->db->where('id', $id);
    $this->db->update('pengajuan', ['status' => $status]);
}

public function getRincianByNama($nama_user)
{
    return $this->db->get_where('rincian', ['nama_user' => $nama_user])->result_array();
}


}
