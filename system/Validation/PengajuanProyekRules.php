<?php 

namespace CodeIgniter\Validation;


class PengajuanProyekRules
{

    public function outOfAnggaran(): bool {

        
        $request = \Config\Services::request();
        
        $id_pengajuan_proyek_item   = (double)$request->getPost('id_pengajuan_proyek_item');
        $id_anggaran_item           = (int)$request->getPost('id_angggaran_item');
        $pengajuan_proyek_qty       = (double)$request->getPost('pengajuan_proyek_qty');
        $pengajuan_proyek_price     = (double)$request->getPost('pengajuan_proyek_price');
        $pengajuan_proyek_total     = $pengajuan_proyek_qty * $pengajuan_proyek_price;

        
        $anggaran_item  = (new \App\Models\AnggaranItemModel())->find($id_anggaran_item);

        $anggaran_unit  = $anggaran_item['anggaran_unit'];
        $anggaran_price = (double)$anggaran_item['anggaran_price'];
        $anggaran_qty   = (double)$anggaran_item['anggaran_qty'];
        $anggaran_total = $anggaran_price * $anggaran_qty;
            

        $item_dipakai   = (new \App\Models\PengajuanProyekItemModel())
                        ->builder()
                        ->select("
                            SUM(pengajuan_proyek_qty) as total_item, 
                            SUM(pengajuan_proyek_price) as total_price
                        ")
                        ->where('id_anggaran_item', $id_anggaran_item)
                        ->get()
                        ->getRow();

        $total_item     = (double)$item_dipakai->total_item;
        $total_price    = (double)$item_dipakai->total_price;


        if($id_pengajuan_proyek_item) 
        {

            $exist_pengajuan_proyek_item    = (new \App\Models\PengajuanProyekItemModel())->find($id_pengajuan_proyek_item);

            if(!$exist_pengajuan_proyek_item) return false;

            $exist_price                    = (double)$exist_pengajuan_proyek_item['pengajuan_proyek_price'];
            $exist_qty                      = (double)$exist_pengajuan_proyek_item['pengajuan_proyek_qty'];
            $exist_total                    = $exist_price * $exist_qty;
      
            if(!in_array(strtolower($anggaran_unit), [ 'ls', 'lot', 'lots' ])) 
            {
                
                //if($pengajuan_proyek_qty > $anggaran_qty ) return false;

            }

            if($pengajuan_proyek_total > $anggaran_total) return false;
        
        }
        else 
        {

            if(!in_array(strtolower($anggaran_unit), [ 'ls', 'lot', 'lots' ])) 
            {
                
                if(($total_item + $pengajuan_proyek_qty) > $anggaran_qty) return false;

            }

            if($total_price + $pengajuan_proyek_price > $anggaran_price) return false;

        }


        

        return true;

    }

    public function isOutOfQty() {



        return true;

    }
    

}