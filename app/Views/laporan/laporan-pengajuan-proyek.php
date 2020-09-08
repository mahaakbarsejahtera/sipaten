<?php //var_dump($pengajuan); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <title>Selamat Datang</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-size: 11px;
        }
    </style>
</head>
<body>
    

    <div>
    
        <div>
            <h3 class="text-center mb-3">Laporan Pengajuan</h3>
        </div>

        <div class="clearfx">

            <div class="float-left">
                <table>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?php echo date('Y-m-d'); ?></td>
                    </tr>
                    <tr>
                        <td>Perihal/Pekerjaan</td>
                        <td>:</td>
                        <td><?php echo $pengajuan->nama_pekerjaan; ?></td>
                    </tr>
                    <tr>
                        <td>Dana Pengajuan yang diterima</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($nilai_pengajuan->total); ?></td>
                    </tr>
                    <tr>
                        <td>Rincian Biaya Sebenarnya</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($nilai_pengajuan->total_actual); ?></td>
                    </tr>
                </table>
            </div>

            <div class="float-right">
                <table>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>:</td>
                        <td><?php echo $pengajuan->tanggal_pengajuan_proyek ?></td>
                    </tr>
                    <tr>
                        <td>Yang Mengajukan</td>
                        <td>:</td>
                        <td><?php echo $pengajuan->nama_lengkap_pengaju ?></td>
                    </tr>
                </table>
            </div>


        </div>

        <div class="clearfix mb-3"></div>

        <div class="clearfix ">
            <div class="float-left w-100">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center" class="text-center">Jenis Pengajuan</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Harga Satuan (Rp)</th>
                            <th class="text-center">Jumlah Harga (Rp)</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php $no = 0; ?>
                        <?php foreach($items as $item) : ?>
                            <?php 
                            
                                $subtotal = $item->pengajuan_proyek_actual_qty * $item->pengajuan_proyek_actual_price;
                                
                            ?>
                            <tr>
                                <td class="text-center"><?php echo ++$no; ?></td>
                                <td class="text-center"><?php echo $item->anggaran_item ?></td>
                                <td class="text-center"><?php echo $item->pengajuan_proyek_actual_qty; ?> <?php echo $item->anggaran_unit; ?></td>
                                <td class="text-right"><?php echo number_format($item->pengajuan_proyek_actual_price); ?></td>
                                <td class="text-right"><?php echo number_format($subtotal) ?></td>
                                <td class="text-center"><?php echo $item->pengajuan_proyek_actual_keterangan; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Biaya</td>
                            <td colspan="5" class="text-right">Rp. <?php echo number_format($nilai_pengajuan->total_actual) ?></td>
                        </tr>
                        <tr>
                            <td>Terbilang</td>
                            <td colspan="5" class="text-right"><?php echo ($nilai_pengajuan->total_actual) ? strtoupper((new \Template\Total)->terbilang($nilai_pengajuan->total_actual)) : ''; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        

        </div>

        <div class="clearfix"></div>

        <div class="clearfix">

            <div class="float-left w-100">

                <table>
                    <tr>
                        <td>Dana yang diberikan atas pengajuan</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($nilai_pengajuan->total); ?></td>
                    </tr>
                    
                    <tr>
                        <td>Total biaya yang sebenernya</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($nilai_pengajuan->total_actual); ?></td>
                    </tr>
                    <tr>
                        <td>Sisa/kurang dana</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format(abs($nilai_pengajuan->total - $nilai_pengajuan->total_actual)); ?></td>
                    </tr>
                </table>

            </div>

        </div>

        <div class="clearfix">
            <div class="float-left w-100">
                <ol class="mt-3">
                    <li>Jika dana berlebih, dikembalikan kepada kasir /masuk ke Kas Kecil</li>
                    <li>Jika dana kurang di Reimbursement dengan mengajukan pengajuan pergantian biaya </li>
                </ol>

                <div class="mb-3">Demikianlah Laporan Pengajuan ini di perbuat untuk dapat dimaklumi dan diketahui sesuai deng</div>
                <div class="mb-3">NB : Seluruh Transaksi harus disertai dengan Bukti Transaksi (Kwitansi), Kalau tidak disertai dengan bukti voucher</div>
            </div>
        </div>
    </div>
    
    <div class="clearfix mt-3">
        <div class="float-left col-4">
            
            <div>Pengaju</div>

            <div style="margin-top: 80px">
                <div><?php echo $pengajuan->nama_lengkap_pengaju ?></div>
                <div><?php echo $pengajuan->role_name; ?></div>
            </div>
        </div>


        <?php foreach($penanggung_jawab as $penanggung) :  ?>
            <?php if($pengajuan->id_pengaju != $penanggung->id_user) : ?>
                <div class="float-left col-4">
                    <div><?php echo $penanggung->sebagai_penanggung_jawab; ?></div>



                    <div style="margin-top: 80px">
                        <div><?php echo $penanggung->user_fullname; ?></div>
                        <div><?php echo $penanggung->role_name; ?></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    

</body>
</html>