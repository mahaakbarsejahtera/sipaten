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
        
        $pecahkan = explode('-', $penawaran->penawaran_validasi_date);
        $validasi_date = $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];

        $pecahkan_due_date = explode('-', $penawaran->penawaran_due_date);
        $validasi_due_date = $pecahkan_due_date[2] . ' ' . $bulan[ (int)$pecahkan_due_date[1] ] . ' ' . $pecahkan_due_date[0];
        

    ?>


    <div class="clearfix">
        <div class="float-left">
            <div>Kepada Yth,</div>
            <strong>
                <div>Bapak/Ibu</div>
                <?php echo $penawaran->nama_customer; ?>
            </strong></br>

            <p>Di Tempat</p>
        </div>
        <div class="float-right">
            Medan, <?php echo $validasi_date; ?>            
            <table class="">
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td><?php echo $penawaran->penawaran_no; ?></td>
                </tr>
                <tr>
                    <td>Lamp</td>
                    <td>:</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>C. Person</td>
                    <td>:</td>
                    <td><?php echo $penawaran->user_fullname ?></td>
                </tr>
                
                <tr>
                    <td>Due Date</td>
                    <td>:</td>
                    <td><?php echo $validasi_due_date ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clearfix">
        <div class="mb-5"></div>
    </div>

    <div class="clearfix font-weight-bold mt-4 mb-4">
        <div class="float-left mr-1">Perihal:</div>
        <div class="float-left"> <?php echo $penawaran->nama_pekerjaan; ?></div>
    </div>

    <div class="clearfix mb-4"></div>

    <div class="clearfix">
        <div class="float-left">
            <p>
                Dengan Hormat, </br>
                Berkenan dengan adanya kebutuhan Pekerjaan "<?php echo $penawaran->nama_pekerjaan; ?>" di dalam lingkungan perusahaan/instansi yang bapak/ibu pimpin maka kami lampirkan penawaran harga sebagai berikut.
            </p>
        </div>
    </div>

    <div class="clearfix"></div>
    
    <div class="clearfix">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">1</th>
                    <th><?php echo $penawaran->nama_pekerjaan; ?></th>
                    <th>
                        <div class="clearfix">
                            <span class="float-left">Rp.</span>
                            <span class="float-right"><?php echo number_format($harga->estimasi_harga_jual)?></span>
                            
                        </div>
                    </th>
                </tr>
                <tr>
                    <th colspan="2"><?php echo $terbilang; ?></th>
                </tr>
            </thead>
        </table>

        <div>
            <div>Kondisi Penawaran</div>
            <?php echo $penawaran->penawaran_term ?>
        </div>

        <p>Demikian penawaran ini kami buat dan besar harapan kami mendapatkan respon positif dari Bapak/Ibu segera, atas kerja sama dan perhatiannya kami ucapkan terimkasih.</p>
    
        
        <div class="mt-5 clearfix">
            <div class="float-left">
                <div>Hormat Kami,</div>
                <div><strong>PT. MAHA AKBAR SEJAHTERA</strong></div>


                <div style="margin-top: 80px">
                    <div class="float-left">
                        <strong class="mb-0"><u>(HAZRI FADILLAH HARAHAP)</u></strong>
                        <div>Direktur Utama</div>
                    </div>

                </div>
            </div>

        </div>
    
    </div>
    
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>