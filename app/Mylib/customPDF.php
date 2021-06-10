<?php

namespace App\Mylib;

use PHPUnit\Util\PHP\WindowsPhpProcess;
use TCPDF;


class customPDF extends TCPDF{

    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'gmdp_logo.jpg';
        // $image_file = '<img src="{{asset('images/gmdp-logo.png');}}" width="180" height="70">';
        $this->Image($image_file, 20, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 25);
        // Title
        $this->Cell(0, 15, 'PT. Global Media Data Prima', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}