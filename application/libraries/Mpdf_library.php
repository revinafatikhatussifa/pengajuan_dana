<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH.'vendor/autoload.php';

use Mpdf\Mpdf;

class Mpdf_library {
    public function __construct()
    {
        // bisa kosong, hanya untuk load library
    }

    public function create($html, $filename = 'document.pdf', $mode = 'D')
    {
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, $mode);
    }
}
