<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function getUserByEmail($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }
}
