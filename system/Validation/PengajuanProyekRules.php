<?php 

namespace CodeIgniter\Validation;


class PengajuanProyekRules
{

    public function outOfControl(): bool {

        
        $request = \Config\Services::request();

        $id_anggaran_item       = $request->getPost('id_angggaran_item');
        $pengajuan_proyek_qty   = $request->getPost('pengajuan_proyek_qty');
        $pengajuan_proyek_price = $request->getPost('pengajuan_proyek_price');

        
        $anggaran_item = (new \App\Models\AnggaranItemModel())->find($id_anggaran_item);

            
        $item_dipakai = (new \App\Models\PengajuanProyekItemModel())
                        ->builder()
                        ->select("
                            SUM(pengajuan_proyek_qty) as total_item, 
                            SUM(pengajuan_proyek_price) as total_price
                        ")
                        ->where('id_anggaran_item', $id_anggaran_item)
                        ->get()
                        ->getRow();

        if((double)$item_dipakai->total_item > $pengajuan_proyek_qty) 
        {

            return false;

        }

        if((double)$item_dipakai->total_price > $pengajuan_proyek_price) 
        {

            return false;

        }

        return true;
    }

    public function isOutOfQty() {



        return true;

    }
    

}