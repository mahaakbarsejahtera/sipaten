<!doctype html>
<html lang="en">
  <head>
    <title>Selamat Datang</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>


    <div class="clearfix container">
        <div class="float-left">
            Kepada Yth, <br>
            Bapak/Ibu</br>
            PT. Hutama Karya (Persero),
            Divisi Pengembangan Jalan Tol Ruas Medan Binjai,
            Di Template
        </div>
        <div class="float-right">

            Medan, 7 Desember 2019
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>068/PN/MK.H/XII/2019</td>
                </tr>
                <tr>
                    <td>Lamp</td>
                    <td>:</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>C. Person</td>
                    <td>:</td>
                    <td>Hazri/082164590261</td>
                </tr>
                
                <tr>
                    <td>Due Date</td>
                    <td>:</td>
                    <td>14 Dessember 2019</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clearfix mb-5"></div>

    <div class="clearfix container font-weight-bold">
        <div class="float-left">Perihal:</div>
        <div class="float-left"> Relokasi Tower CCTX 30M, Penambahan Stick Tower 5 Meter, Tower Extender 5 Meter dan Maintenance Sistem Video Surveilance Tower CCTV Pematang pasir dan Tower CCTV Baracuda</div>
    </div>

    <div class="clearfix mb-4"></div>

    <div class="clearfix container">
        <div class="float-left">
            <p>
                Dengan Hormat, </br>
                Berkenan dengan adanya kebutuhan Pekerjaan "Perihal" di dalam lingkungan perusahaan/instansi yang bapak/ibu pimpin maka kami lampirkan penawaran harga sebagai berikut.
            </p>
        </div>
    </div>

    <div class="clearfix"></div>
    
    <div class="clearfix container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">1</th>
                    <th>
                    Relokasi Tower CCTX 30M, Penambahan Stick Tower 5 Meter, Tower Extender 5 Meter dan Maintenance Sistem Video Surveilance Tower CCTV Pematang pasir dan Tower CCTV Baracuda
                    </th>
                    <th>Rp. 89.298.000</th>
                </tr>
                <tr>
                    <th colspan="2" id="format-angka"></th>
                </tr>
            </thead>
        </table>
    </div>
    
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>

    function currencyToWord(nominalCurrency) { 

        console.log(nominalCurrency)

        let words = [];
        let temp = [];

        let strCurrency = nominalCurrency.toString();

        let constNumber = {
            0: null,
            1: "SATU",
            2: "DUA",
            3: "TIGA",
            4: "EMPAT",
            5: "LIMA",
            6: "ENAM",
            7: "TUJUH",
            8: "DELAPAN",
            9: "SEMBILAN",
            10: "SEPULUH",
            11: "SEBELAS"
        }

        let unit = [
            "BELAS",
            "PULUH",
            "RATUS",
            "RIBU",
            "JUTA",
            "MILIAR",
        ];

        let i = 0;
        while(i < strCurrency.length) {
            temp.push(strCurrency[i]);
            i++;
        }
        return temp;

    }

    $('#format-angka').html(currencyToWord(12));

    </script>
</body>
</html>