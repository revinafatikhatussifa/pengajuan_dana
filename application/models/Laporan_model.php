<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function get_laporan_per_tanggal($awal, $akhir)
    {
        $this->db->select('nama_user, keterangan, jumlah, created_at');
        $this->db->from('rincian');
        $this->db->where('DATE(created_at) >=', $awal);
        $this->db->where('DATE(created_at) <=', $akhir);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_total_per_tanggal($awal, $akhir)
    {
        $this->db->select_sum('jumlah');
        $this->db->from('rincian');
        $this->db->where('DATE(created_at) >=', $awal);
        $this->db->where('DATE(created_at) <=', $akhir);
        $query = $this->db->get();
        return $query->row()->jumlah ?? 0;
    }

    public function get_laporan_all()
    {
        $this->db->select('nama_user, keterangan, jumlah, created_at');
        $this->db->from('rincian');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
