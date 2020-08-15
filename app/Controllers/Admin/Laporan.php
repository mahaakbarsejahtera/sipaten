<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;
use Dompdf\Dompdf;

class Laporan extends Controller
{

    public function lampiranPenawaran() {
        return view('laporan/lampiran-penawaran');
    }

    public function lampiranBoq() {

        $db = db_connect();
        $builder = $db->table('hasil_survey')
            ->where('id_survey', $this->request->getGet('id_survey'))
            ->where('survey_divisi', $this->request->getGet('divisi'));

        $hasil_survey = $builder->get()->getResult();


        $permintaan = $db->table('permintaan')->where('id_permintaan', $this->request->getGet('permintaan'))->get()->getRowObject();
        $boq = view('laporan/lampiran-boq', [
            'permintaan' => $permintaan,
            'hasil_survey' => $hasil_survey,
        ]);
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($boq);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($permintaan->nama_pekerjaan . "-" . date('his'));
                    
        return $boq;


    }


}