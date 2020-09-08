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

    public function lampiranPengajuan() 
    {

        $dataToView = [
            'pengajuan'         => [],
            'penanggung_jawab'  => [],
            'items'             => [],
            'pengaju'           => []
        ];


        $id_pengajuan = $this->request->getGet('id_pengajuan');

        $pengajuan = (new \App\Models\PengajuanProyekModel())
            ->builder()
            ->join('jenis_pengajuan', 'pengajuan_proyek.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan')
            ->join('anggaran', 'pengajuan_proyek.id_anggaran=anggaran.id_anggaran')
            ->join('permintaan', 'anggaran.id_permintaan=permintaan.id_permintaan')
            ->find($id_pengajuan);

        $dataToView['pengajuan'] = $pengajuan;

        //var_dump($pengajuan);


        if($pengajuan) 
        {
            
            $penanggung_jawab = (new \App\Models\PenanggungJawabModel())
            ->builder()
            ->join('users', 'penanggung_jawab.penanggung_jawab_user=users.id_user', 'left')
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->where('id_jenis_pengajuan', $pengajuan['id_jenis_pengajuan'])
            ->get()
            ->getResult();


            $items = (new \App\Models\PengajuanProyekItemModel())
                ->builder()
                ->where('id_pengajuan_proyek', $pengajuan['id_pengajuan_proyek'])
                ->get()
                ->getResult();



            $pengaju = (new \App\Models\UsersModel())->find($pengajuan['id_pengaju']);

            // /var_dump($penanggung_jawab);

            $dataToView['items']            = $items;
            $dataToView['penanggung_jawab'] = $penanggung_jawab;
            $dataToView['pengaju']          = $pengaju;

        }
        
        $html = view('laporan/lampiran-pengajuan', $dataToView);

        //return $html;
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("{$pengajuan['nama_pekerjaan']} - {$pengajuan['nama_jenis_pengajuan']}" . date('his'));
                    
        return $html;

    }

    public function lampiranPengajuanInternal() 
    {

        $dataToView = [
            'pengajuan'         => [],
            'penanggung_jawab'  => [],
            'items'             => [],
            'pengaju'           => []
        ];


        $id_pengajuan = $this->request->getGet('id_pengajuan');

        $pengajuan = (new \App\Models\PengajuanInternalModel())
            ->builder()
            ->join('jenis_pengajuan', 'pengajuan_internal.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan')
            ->find($id_pengajuan);

        $dataToView['pengajuan'] = $pengajuan;

        //var_dump($pengajuan);


        if($pengajuan) 
        {
            
            $penanggung_jawab = (new \App\Models\PenanggungJawabModel())
            ->builder()
            ->join('users', 'penanggung_jawab.penanggung_jawab_user=users.id_user', 'left')
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->where('id_jenis_pengajuan', $pengajuan['id_jenis_pengajuan'])
            ->get()
            ->getResult();


            $items = (new \App\Models\PengajuanInternalItemModel())
                ->builder()
                ->where('id_pengajuan_internal', $pengajuan['id_pengajuan_internal'])
                ->get()
                ->getResult();



            $pengaju = (new \App\Models\UsersModel())->find($pengajuan['id_pengaju']);

            // /var_dump($penanggung_jawab);

            $dataToView['items']            = $items;
            $dataToView['penanggung_jawab'] = $penanggung_jawab;
            $dataToView['pengaju']          = $pengaju;

        }
        



        $html = view('laporan/lampiran-pengajuan-internal', $dataToView);

        //`return $html;
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("{$pengajuan['perihal_pengajuan_internal']} - {$pengajuan['nama_jenis_pengajuan']}" . date('his'));
                    
        return $html;

    }



    public function laporanPengajuanProyek()
    {
        
        $idPp = $this->request->getGet('id_pp');
        $pengajuan = (new \App\Models\PengajuanProyekModel())  
            ->builder()
            ->select('anggaran.*, pengajuan_proyek.*, pengaju.user_fullname as nama_lengkap_pengaju, permintaan.*, jenis_pengajuan.*, roles.*')
            ->join('anggaran', 'pengajuan_proyek.id_anggaran = anggaran.id_anggaran', 'left')
            ->join('permintaan', 'anggaran.id_permintaan = permintaan.id_permintaan', 'left')
            ->join('users as pengaju', 'pengajuan_proyek.id_pengaju = pengaju.id_user', 'left')
            ->join('roles', 'pengaju.user_role=roles.id_role')
            ->join('jenis_pengajuan', 'pengajuan_proyek.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan', 'left')
            ->where('pengajuan_proyek.id_pengajuan_proyek', $idPp)
            ->get()
            ->getRow();

        $penanggung_jawab = (new \App\Models\PenanggungJawabModel())
            ->builder()
            ->join('users', 'penanggung_jawab.penanggung_jawab_user=users.id_user', 'left')
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->where('id_jenis_pengajuan', $pengajuan->id_jenis_pengajuan)
            ->get()
            ->getResult();
        
        $items =  (new \App\Models\PengajuanProyekItemModel())
            ->builder()
            ->join('anggaran_item', 'pengajuan_proyek_item.id_anggaran_item = anggaran_item.id_anggaran_item', 'left')
            ->where('pengajuan_proyek_item.id_pengajuan_proyek', $idPp)
            ->get()
            ->getResult();
        
        $nilai_pengajuan = (new \App\Models\PengajuanProyekItemModel())
        ->builder()
        ->select('SUM(pengajuan_proyek_qty * pengajuan_proyek_price) as total, SUM(pengajuan_proyek_actual_qty * pengajuan_proyek_actual_price) as total_actual')
        ->where('pengajuan_proyek_item.id_pengajuan_proyek', $idPp)
        ->get()
        ->getRow();


        $html = view('laporan/laporan-pengajuan-proyek', [
            'pengajuan'             => $pengajuan,
            'items'                 => $items,
            'nilai_pengajuan'       => $nilai_pengajuan,
            'penanggung_jawab'      => $penanggung_jawab
        ]);


        //return $html;

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($pengajuan->nama_pekerjaan . "-" . date('his'));
        
        return $html;
    }

    public function laporanPengajuanInternal()
    {
        
        $idPp = $this->request->getGet('id_pp');
        $pengajuan = (new \App\Models\PengajuanInternalModel())  
            ->builder()
            ->select('pengajuan_internal.*, pengaju.user_fullname as nama_lengkap_pengaju, jenis_pengajuan.*, roles.*')
            ->join('users as pengaju', 'pengajuan_internal.id_pengaju = pengaju.id_user', 'left')
            ->join('roles', 'pengaju.user_role=roles.id_role')
            ->join('jenis_pengajuan', 'pengajuan_internal.id_jenis_pengajuan=jenis_pengajuan.id_jenis_pengajuan', 'left')
            ->where('pengajuan_internal.id_pengajuan_internal', $idPp)
            ->get()
            ->getRow();

        $penanggung_jawab = (new \App\Models\PenanggungJawabModel())
            ->builder()
            ->join('users', 'penanggung_jawab.penanggung_jawab_user=users.id_user', 'left')
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->where('id_jenis_pengajuan', $pengajuan->id_jenis_pengajuan)
            ->get()
            ->getResult();
        
        $items =  (new \App\Models\PengajuanInternalItemModel())
            ->builder()
            ->where('pengajuan_internal_item.id_pengajuan_internal', $idPp)
            ->get()
            ->getResult();
        
        $nilai_pengajuan = (new \App\Models\PengajuanInternalItemModel())
        ->builder()
        ->select('SUM(pengajuan_internal_qty * pengajuan_internal_price) as total, SUM(pengajuan_internal_actual_qty * pengajuan_internal_actual_price) as total_actual')
        ->where('pengajuan_internal_item.id_pengajuan_internal', $idPp)
        ->get()
        ->getRow();


        $html = view('laporan/laporan-pengajuan-internal', [
            'pengajuan'             => $pengajuan,
            'items'                 => $items,
            'nilai_pengajuan'       => $nilai_pengajuan,
            'penanggung_jawab'      => $penanggung_jawab
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($pengajuan->perihal_pengajuan_internal . "-" . date('his'));
        
        return $html;
    }

}