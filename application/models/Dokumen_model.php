<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Ambil semua dokumen, bisa ditambahkan filter status jika perlu
    public function getAllDokumen($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('upload_date', 'DESC');
        return $this->db->get('dokumen')->result_array();
    }

    // Ambil dokumen berdasarkan ID
    public function getDokumenById($id) {
        return $this->db->get_where('dokumen', ['id' => $id])->row_array();
    }

    // Verifikasi dokumen
    public function verifyDokumen($id) {
        $this->db->where('id', $id);
        return $this->db->update('dokumen', ['status' => 'verified']);
    }

    // Tolak dokumen dengan alasan
    public function rejectDokumen($id, $reason) {
        $this->db->where('id', $id);
        return $this->db->update('dokumen', [
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }

    // Simpan / upload dokumen baru
    public function insertDokumen($data) {
        return $this->db->insert('dokumen', $data);
    }

    // Hapus dokumen
    public function deleteDokumen($id) {
        $this->db->where('id', $id);
        return $this->db->delete('dokumen');
    }

    public function getAllDokumenWithUser()
    {
        $this->db->select('dokumen.*, user.name as user_name, user.email as user_email');
        $this->db->from('dokumen');
        $this->db->join('user', 'user.id = dokumen.user_id', 'left');
        $this->db->order_by('dokumen.upload_date', 'DESC');
        return $this->db->get()->result_array();
    }

}
