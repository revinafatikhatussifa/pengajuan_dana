<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->library('session');
    }

    // ===================== LOGIN ===================== //
    public function index()
    {
        // Jika sudah login, redirect
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
{
    $email = $this->input->post('email', true);
    $password = $this->input->post('password', true);

    $user = $this->db->get_where('user', ['email' => $email])->row_array();


    if ($user) {
        if ($user['is_active'] == 1) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id'      => $user['id'],   
                    'email' => $user['email'],
                    'role_id' => $user['role_id']
                ];
                $this->session->set_userdata($data);

                if ($user['role_id'] == 1) {
                    redirect('admin');
                } else {
                    redirect('user');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">This email has not been activated!</div>');
            redirect('auth');
        }
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered!</div>');
        redirect('auth');
    }
}

    // ===================== REGISTRATION ===================== //
    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Passwords do not match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your account has been created. Please login!</div>');
            redirect('auth');
        }
    }

    // ===================== FORGOT PASSWORD ===================== //
    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                // Nanti di sini bisa ditambahkan fitur kirim email reset password
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
                redirect('auth/forgotPassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');
                redirect('auth/forgotPassword');
            }
        }
    }

    // ===================== LOGOUT ===================== //
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->sess_destroy(); 

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth/login');
    }
}
