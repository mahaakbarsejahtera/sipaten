<html lang="en">
  <head>
    <title>Lampiran Nego</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr th,
        table tr td {
            border: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .clear::after {
            display: block;
            clear: both;
            content: "";
        }

    </style>
  </head>
  <body>

    <?php 
        // echo "<pre>";
        // var_dump($hasil_survey) ;
        // echo "</pre>";

    ?>

    <div class="text-center font-weight-bold mb-4 mt-4"> 
        <h6 class="mb-0">BERITA ACARA KLARIFIKASI DAN NEGOSIASI</h6>
        <h6><?php echo $penawaran->nama_pekerjaan; ?></h6>
        <p><?php echo $penawaran->nego_no; ?></p>
    </div>

    <div class="inner">
        <table class="table table-sm table-bordered" style="max-width: 1191px; margin-bottom: 16px;">
            <thead>
            
                <tr>
                    <th class="text-center align-middle" rowspan="2" width="50">No</th>
                    <th class="text-center align-middle" rowspan="2" width="150">Uraian</th>
                    <th class="text-center align-middle" colspan="2">Kuantitas</th>
                    <th class="text-center align-middle" colspan="2">Penawaran</th>
                    <th class="text-center align-middle" colspan="2">Negosiasi</th>
                </tr>

                <tr>
                    <th class="text-center align-middle">Volume</th>
                    <th class="text-center align-middle">Satuan</th>
                    <th class="text-center align-middle">Harga Satuan <br> (Rp)</th>
                    <th class="text-center align-middle">Jumlah <br> (Rp)</th>
                    <th class="text-center align-middle">Harga Satuan <br> (Rp)</th>
                    <th class="text-center align-middle">Jumlah <br> (Rp)</th>
                </tr>


            </thead>
            <tbody>
                <?php 
                
                $no         = 0;  
                $total      = 0;
                $total_nego = 0;
                
                ?>
                <?php 
                

                foreach($items as $item) : 
                
                $subtotal_hj    = $item->item_qty * $item->item_hj;
                $subtotal_nego  = $item->item_qty * $item->item_hj_nego;
                $total          += $subtotal_hj;
                $total_nego     += $subtotal_nego;

                ?>
                <tr>
                    <td class="text-center"><?php echo ++$no; ?></td>
                    <td><?php echo $item->item_name ?></td>
                    <td class="text-center" width="30"><?php echo $item->item_qty ?></td>
                    <td class="text-center" width="30"><?php echo $item->item_unit ?></td>
                    <td class="text-right"><?php echo number_format($item->item_hj); ?></td>
                    <td class="text-right"><?php echo number_format($subtotal_hj); ?></td>
                    <td class="text-right"><?php echo number_format($item->item_hj_nego); ?></td>
                    <td class="text-right"><?php echo number_format($subtotal_nego); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php 
                
                $ppn                = $total * 0.1;
                $ppn_nego           = $total_nego * 0.1;

                $grandtotal         = $total + $ppn;
                $grandtotal_nego    = $total_nego + $ppn_nego;
                ?>
                <tr>
                    <td></td>
                    <td class="font-weight-bold"></td>
                    <td class="text-center font-weight-bold" colspan="2">
                        <b>JUMLAH</b>
                    </td>
                    <td class="text-center font-weight-bold">
                        <b>JUMLAH</b>
                    </td>
                    <td class="text-right font-weight-bold"><?php echo number_format($total); ?></td>
                    <td class="text-center font-weight-bold">
                        <b>JUMLAH</b>
                    </td>
                    <td class="text-right font-weight-bold"><?php echo number_format($total_nego); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="font-weight-bold"></td>
                    <td class="text-center font-weight-bold" colspan="2">
                        <b>PPN 10%</b>
                    </td>
                    <td class="text-center font-weight-bold"><b>PPN 10%</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($ppn); ?></td>
                    <td class="text-center font-weight-bold"><b>PPN 10%</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($ppn_nego); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="font-weight-bold"></td>
                    <td class="text-center font-weight-bold" colspan="2">
                        <b>TOTAL</b>
                    </td>
                    <td class="text-center font-weight-bold"><b>TOTAL</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($grandtotal); ?></td>
                    <td class="text-center font-weight-bold"><b>TOTAL</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($grandtotal_nego); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="font-weight-bold"></td>
                    <td class="text-center font-weight-bold" colspan="2">
                        <b>DIBULATKAN</b>
                    </td>
                    <td class="text-center font-weight-bold"><b>DIBULATKAN</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format(round($grandtotal)); ?></td>
                    <td class="text-center font-weight-bold"><b>DIBULATKAN</b></td>
                    <td class="text-right font-weight-bold"><?php echo number_format(round($grandtotal_nego)); ?></td>
                </tr>
            </tfoot>
        </table>



        <div style="margin-bottom: 24px;">
            <div>Kondisi Penawaran</div>
            <div><?php echo $penawaran->nego_term ?></div>
        </div>
        
        <div class="clear">
            <div class="float-left text-center">
                <p><?php echo $penawaran->nego_lokasi ?>, <?php echo $penawaran->nego_tgl_surat ?></p>
            </div>
        </div>

        <div class="clear">

            <div class="float-left text-center" style="width: 50%;">
                <h6 style="margin-bottom: 80px">PT. MAHA AKBAR SEJAHTERA</h6>
                
                <div class="">
                    <u>Hazri Fadillah Harahap</u>
                    <div>Director</div>
                </div>


            </div>

            <?php 
            
            $pic_names = explode(', ', $penawaran->nego_pic_nama);

            if(is_array($pic_names) && count($pic_names) > 0) {

                $num_of_name = count($pic_names);
                $columns = 50 / $num_of_name;


                foreach($pic_names as $name) {
                    
                    $extract_name = explode(':', $name);
                    $pic_name = isset($extract_name[0]) ? $extract_name[0] : '';
                    $pic_jabatan = isset($extract_name[1]) ? $extract_name[1] : '';

                    ?>

                    <div class="float-left text-center" style="width: <?php echo $columns ?>%;">

                        <h6 style="margin-bottom: 80px"><?php echo $penawaran->nama_customer; ?></h6>

                        <div class="">
                            <u><?php echo $pic_name ?></u>
                            <div><?php echo $pic_jabatan ?></div>
                        </div>


                    </div>


                    <?php 

                }

            }
            
            ?>

            
            
        </div>

        



    </div>
      
    <!-- Optional JavaScript -->
  </body>
</html>