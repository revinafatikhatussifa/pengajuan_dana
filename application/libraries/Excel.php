<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'../vendor/autoload.php'; // autoload Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    public function newSpreadsheet()
    {
        return new Spreadsheet();
    }

    public function newWriter($spreadsheet)
    {
        return new Xlsx($spreadsheet);
    }
}
