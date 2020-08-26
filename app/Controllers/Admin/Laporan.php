<?php

namespace App\Controllers\Admin;

use App\Controllers\Api\PermintaanItem;
use App\Models\NegosiasiModel;
use App\Models\PermintaanItemsModel;
use App\Models\PermintaanModel;
use CodeIgniter\Controller;
use Template\BreadCrumb;
use Template\Table;
use Dompdf\Dompdf;
use Template\Total;

class Laporan extends Controller
{

    public function lampiranPenawaran() {

        
        $penawaran = (new PermintaanModel())
            ->builder()
            ->join('customers', 'permintaan.id_customer = customers.id_customer')
            ->join('users as sales', 'permintaan.permintaan_sales=sales.id_user')
            ->join('penawaran', 'permintaan.id_permintaan=penawaran.id_permintaan')
            ->where('penawaran.id_penawaran', $this->request->getGet('id_penawaran'))
            ->get()->getRow();

        $harga = (new PermintaanItemsModel())
            ->builder()
            ->select("SUM(item_qty * item_hp) as estimasi_harga_pokok, SUM(item_qty * item_hj) as estimasi_harga_jual")
            ->where('id_permintaan', $penawaran->id_permintaan)
            ->groupBy('id_permintaan')
            ->get()
            ->getRow();

    


        $penawaran_html = view('laporan/lampiran-penawaran', [
            'penawaran' => $penawaran,
            'harga' => $harga,
            'terbilang' => ucwords((new Total)->terbilang($harga->estimasi_harga_jual))
        ]);


        $dompdf = new Dompdf();
        $dompdf->loadHtml($penawaran_html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($penawaran->penawaran_no . "-" . date('his'));
                    
        return $penawaran_html;
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

    public function lampiranNego() {

        
        
        $penawaran = (new NegosiasiModel())
            ->builder()
            ->join('permintaan', 'negosiasi.id_permintaan = permintaan.id_permintaan', 'left')
            ->join('customers', 'permintaan.id_customer = customers.id_customer', 'left')
            ->where('negosiasi.id_nego', $this->request->getGet('id_nego'))
            ->get()->getRow();

        $harga = (new PermintaanItemsModel())
            ->builder()
            ->select("SUM(item_qty * item_hp) as estimasi_harga_pokok, SUM(item_qty * item_hj) as estimasi_harga_jual")
            ->where('id_permintaan', $penawaran->id_permintaan)
            ->groupBy('id_permintaan')
            ->get()
            ->getRow();


            

        $items = (new PermintaanItemsModel())
        ->builder()
        ->where('id_permintaan', $penawaran->id_permintaan)
        ->get()
        ->getResult();

    
         

        $negoHtml = view('laporan/lampiran-nego', [
            'penawaran' => $penawaran,
            'items'     => $items,
            //'terbilang' => ucwords((new Total)->terbilang($harga->estimasi_harga_jual))
        ]);

        //return $negoHtml;
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($negoHtml);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($penawaran->id_nego . "-" . date('his'));
                    
        return $negoHtml;
    }


    public function hasilEstimasi() {

        $db = db_connect();
        $builder = $db->table('permintaan_item')
            ->where('id_permintaan', $this->request->getGet('id_permintaan'));
            //->where('survey_divisi', $this->request->getGet('divisi'));

        $items = $builder->get()->getResult();


        $permintaan = $db
            ->table('permintaan')
            ->where('id_permintaan', $this->request->getGet('id_permintaan'))
            ->get()
            ->getRowObject();
        // echo "<pre>";
        // var_dump($items);
        // echo "</pre>";
        // die();
        $boq = view('laporan/estimasi', [
            'permintaan' => $permintaan,
            'items' => $items,
        ]);
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($boq);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($permintaan->nama_pekerjaan . "-" . date('his'));
                    
        return $boq;


    }


    public function lampiranAnggaran() {
        
        

        $items = [];

        $subs = [
            'boq' => 'BOQ',
            'teknik' => 'TEKNIK',
            'pemasaran' => 'PEMASARAN',
            'keuangan' => 'KEUANGAN',
            'proyek' => 'PROYEK',
        ];

        $anggaran = (new \App\Models\AnggaranModel)
            ->builder()
            ->join('permintaan', 'anggaran.id_permintaan=permintaan.id_permintaan', 'left')
            ->where('anggaran.id_anggaran', $this->request->getGet('id_anggaran'))
            ->get()
            ->getRow();

        

        if($anggaran) 
        {

            

            foreach($subs as $key => $value) {
                $items[$key] = (new \App\Models\AnggaranItemModel())
                ->where('id_anggaran', $this->request->getGet('id_anggaran'))
                ->where('jenis_anggaran', $key)
                ->get()
                ->getResult(); 
            }

        }

        $html = view('laporan/lampiran-anggaran', [
            'anggaran' => $anggaran,
            'items' => $items,
            'subs' => $subs
            //'terbilang' => ucwords((new Total)->terbilang($harga->estimasi_harga_jual))
        ]);

        //return $html;
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($anggaran->nama_pekerjaan . "-" . date('his'));
                    
        return $html;
    }



}