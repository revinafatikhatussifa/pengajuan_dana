<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in() {
    $CI = get_instance();
    if (!$CI->session->userdata('email')) {
        redirect('auth');
    }
}
