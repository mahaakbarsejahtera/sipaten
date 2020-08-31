<!doctype html>
<html lang="en">
  <head>
    <title>Selamat Datang</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body{
            font-size: 14.66px;
            font-family: 'times new roman' !important;
        }


        body li {
            font-size: 14.66px !important;
            font-family: 'times new roman' !important;
        }
    </style>
  </head>
  <body>

    <?php 

        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        
        $pecahkan = explode('-', $pengajuan['tanggal_pengajuan_proyek']);
        $validasi_date = $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];

        $pecahkan_due_date = explode('-', $pengajuan['due_date_pengajuan_proyek']);
        $validasi_due_date = $pecahkan_due_date[2] . ' ' . $bulan[ (int)$pecahkan_due_date[1] ] . ' ' . $pecahkan_due_date[0];
        

    ?>

    <div class="clearfix">
        <div>
            <h4 class="text-center mb-4" style="font-size: 16px;"><?php echo $pengajuan['nama_jenis_pengajuan']; ?></h4>
        </div>
    </div>

    <div class="clearfix">
        <div class="float-left">
            <table>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?php echo $validasi_date; ?></td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td><?php echo $pengajuan['perihal_pengajuan_proyek'] ?></td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td><?php echo $pengajuan['no_surat_pengajuan_proyek'] ?></td>
                </tr>
            </table>
        </div>
        <div class="float-right">
                       
            <table class="">
                <tr>
                    <td>Due Date,</td>
                    <td>:</td>
                    <td><?php echo $validasi_due_date; ?> </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clearfix">
        <div class="mb-5"></div>
    </div>


    <div class="clearfix"></div>
    
    <div class="clearfix">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Harga (Rp)</th>
                    <th class="text-center">Jumlah (Rp)</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                $no = 0;
                $total = 0;

                ?>
                <?php foreach($items as $item) : ?>
                    <?php 
                    
                    $subtotal = $item->pengajuan_proyek_qty * $item->pengajuan_proyek_price;
                    $total += $subtotal;

                    ?>
                    <tr>
                        <td class="text-center" width="30"><?php echo ++$no; ?></td>
                        <td width="150">
                            <div><?php echo $item->pengajuan_proyek_name ?></div>
                            <small><?php echo $item->pengajuan_proyek_desc ?></small>
                    
                        </td>
                        <td class="text-center" width="30"><?php echo $item->pengajuan_proyek_qty ?> <?php echo $item->pengajuan_proyek_unit ?></td>
                        <td class="text-right"><?php echo number_format($item->pengajuan_proyek_price) ?></td>
                        <td class="text-right"><?php echo number_format($subtotal) ?></td>
                        <td><?php echo $item->pengajuan_proyek_keterangan ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="">Grand Total</th>
                    <th class="text-right" colspan="4"><?php echo number_format($total) ?></th>
                </tr>
                <tr>
                    <th colspan="2">Terbilang</th>
                    <th colspan="4" class="text-right">
                        <b style="font-size: 11px;"><?php echo ucwords((new \Template\Total)->terbilang($total)); ?></b>
                    </th>
                </tr>
            </tfoot>
        </table>

        <div>
            <div>Syarat dan Ketentuan: </div>
            <?php   echo $pengajuan->jenis_pengajuan_term ?>
        </div>
   
        
        <?php 
            
            $num_of_pj = count($penanggung_jawab);
            $col       = 75/$num_of_pj;
        
        ?>

        <div class="mt-5 clearfix ">
            <div class="float-left" style="width: 25%;">
                <div class="text-center"><strong>Diajukan Oleh</strong></div>


                <div style="margin-top: 80px">
                    <div class="text-center">
                        <div>
                            <strong class="mb-0"><u><?php echo $pengaju['user_fullname']; ?></u></strong>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="float-right" style="width: <?php echo $col; ?>%">
                <?php foreach($penanggung_jawab as $pj) : //var_dump($pj); ?>

                    <div class="float-right" style="width: 25%">
                        <div class="text-center"><strong><?php echo $pj->sebagai_penanggung_jawab; ?> Oleh</strong></div>


                        <div style="margin-top: 80px">
                            <div class="text-center">
                                <strong class="mb-0"><u><?php echo $pj->user_fullname; ?></u></strong>
                                <div></div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </div>
    
    </div>
    
      

</body>
</html>