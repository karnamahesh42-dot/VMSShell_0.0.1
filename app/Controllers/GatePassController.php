<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class GatePassController extends Controller
{
    private $singleDir;
    private $groupDir;

    public function __construct()
    {
        $this->singleDir = FCPATH . 'public/uploads/gate_pass_pdf/';
        $this->groupDir  = FCPATH . 'public/uploads/group_qr/';

        if (!is_dir($this->singleDir)) {
            mkdir($this->singleDir, 0777, true);
        }

        if (!is_dir($this->groupDir)) {
            mkdir($this->groupDir, 0777, true);
        }
    }

    /*
    ====================================
    Single Visitor PDF
    ====================================
    */
    public function generateSingle($row)
    {
        $html = view('emails/gate_pass_layout', ['mailData' => $row]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('chroot', FCPATH);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 400, 550]);
        $dompdf->render();

        $pdfFile = $this->singleDir . 'GatePass_' . $row['v_code'] . '.pdf';

        if (file_exists($pdfFile)) {
            unlink($pdfFile);
        }

        file_put_contents($pdfFile, $dompdf->output());

        return $pdfFile; // ⭐ important
    }


    /*
    ====================================
    Group PDF
    ====================================
    */
    public function generateGroup($visitors)
    {
        $html = view('emails/group_gatepass_layout', [
            'visitors' => $visitors
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('chroot', FCPATH);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfFile = $this->groupDir . 'Group_QR_' . $visitors[0]['header_code'] . '.pdf';

        if (file_exists($pdfFile)) {
            unlink($pdfFile);
        }

        file_put_contents($pdfFile, $dompdf->output());

        return $pdfFile;
    }
}
