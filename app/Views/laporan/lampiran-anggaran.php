<?php 

//var_dump($items);

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Lampiran Anggaran</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-size: 11px;
        }
    </style>
  </head>
  <body>
    <div class="text-center pt-4">
        <h3 class="font-weight-bold">Anggaran</h3>
        <p><?php echo $anggaran->nama_pekerjaan; ?></p>
    </div>
     <table class="table table-sm table-bordered">
         <thead>
             <tr>
                 <th class="text-center">No</th>
                 <th class="text-center">Item</th>
                 <th class="text-center">Qty</th>
                 <th class="text-center">Harga</th>
                 <th class="text-center">Total</th>
             </tr>
         </thead>
         <tbody>
            <?php 
            
                $no = 0; 
                $total = 0;        
            ?>
            <?php foreach($subs as $key => $value) : ?>
                <tr>
                    <td></td>
                    <th colspan="4"><?php echo $value; ?></th>
                </tr>
                <?php foreach($items[$key] as $item) : ?>

                    <?php 

                    $subtotal = $item->anggaran_qty * $item->anggaran_price;
                    $total += $subtotal;

                    ?>

                    <tr>
                        <td width="30" class="text-center"><?php echo ++$no; ?></td>
                        <td width="200"><?php echo $item->anggaran_item; ?></td>
                        <td width="50" class="text-center"><?php echo $item->anggaran_qty?> <?php echo $item->anggaran_unit ?></td>
                        <td width="50" class="text-right"><?php echo number_format($item->anggaran_price) ?></td>
                        <td width="50"class="text-right">Rp. <?php echo number_format($subtotal); ?></td>
                    </tr>


                <?php endforeach; ?>
            <?php endforeach; ?>
            

         </tbody>
         <tfoot>
             <tr>
                 <th colspan="4" class="text-center">Grand Total</th>
                 <th class="text-right">Rp. <?php echo number_format($total); ?></th>
             </tr>
         </tfoot>
     </table>
   
  </body>
</html>