<!doctype html>
<html lang="en">
  <head>
    <title>Lamaran Boq</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>

        body {
            font-size: 10px;
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
        <h6>Bill of Quantity</h6>
        <div><?php echo $permintaan->nama_pekerjaan; ?></div>
    </div>

    <div class="inner">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="30">No</th>
                    <th class="text-center">Deskripsi</th>
                    <th colspan="2" class="text-center">Unit</th>
                    <th class="text-center">Harga Satuan</th>
                    <th class="text-center">Total</th>
                </tr>  
            </thead>
            <tbody>
                <?php 
                
                $no = 0;  
                $total = 0;
                
                ?>
                <?php 
                
                foreach($hasil_survey as $hasil) : 
                
                $subtotal = $hasil->survey_item_qty * $hasil->survey_harga_jual;
                $total += $subtotal;

                ?>
                <tr>
                    <td class="text-center"><?php echo ++$no; ?></td>
                    <td><?php echo $hasil->survey_item_name ?></td>
                    <td class="text-center" width="30"><?php echo $hasil->survey_item_qty ?></td>
                    <td class="text-center" width="30"><?php echo $hasil->survey_item_unit ?></td>
                    <td class="text-right"><?php echo number_format($hasil->survey_harga_jual); ?></td>
                    <td class="text-right"><?php echo number_format($subtotal); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php 
                
                $ppn = $total * 0.1;
                $grandTotal = $total + $ppn;
                ?>
                <tr>
                    <td></td>
                    <td class="font-weight-bold">PPN 10%</td>
                    <td class="text-center font-weight-bold" ></td>
                    <td class="text-center font-weight-bold"></td>
                    <td class="text-right font-weight-bold"></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($ppn); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="font-weight-bold">Grand Total</td>
                    <td class="text-center font-weight-bold" ></td>
                    <td class="text-center font-weight-bold"></td>
                    <td class="text-right font-weight-bold"></td>
                    <td class="text-right font-weight-bold"><?php echo number_format($grandTotal); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>