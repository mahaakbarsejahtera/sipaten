<?php $this->extend('admin/layouts'); ?>



<?php $this->section('content'); ?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <?php echo $breadcrumb; ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
          </h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-3">
                    <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#form-modal" class="btn btn-primary mb-3">Tambah Data</a> -->
                </div>
                <div class="col-12 col-md-9">
                    <form class="w-100" id="filter-form">

                        <div class="form-row d-flex justify-content-end">
                            <div class="form-group col-12 col-md-4">
                                <input type="text" class="form-control" placeholder="Search" id="filter-search" v-model="keyword">
                            </div>
                        </div>

                        
                    
                    </form>
                </div>

               <div class="col-12">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenis Pengajuan</th>
                                    <th class="text-center">Nomor Surat</th>
                                    <th class="text-center">Tanggal Surat</th>
                                    <th class="text-center">Nilai Pengajuan</th>
                                    <th class="text-center">Nilai Actual Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody id="table-data"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">Grand Total</th>
                                    <td class="text-right" id="grandtotal"></td>
                                    <td class="text-right" id="grandtotal-actual"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

               </div>
            </div>    
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
 


<?php $this->endSection(); ?>


<?php $this->section('footerScript') ?>

<script>

    $(function(){


        async function loadData(data) {

            $('#table-data').html('');

            return await $.ajax({
                url: `${baseUrl}/api/pengajuan-proyek`,
                data: data
            })

        }

        loadData({
            no_limit: true,
            filters: [{ 
                key: 'id_anggaran', value: '<?php echo $id_anggaran ?>',
            }]
        })
        .then(response => {
            console.log('response', response);
            let total = 0;
            let total_actual = 0;
            response.data.lists.map((v, i) => {

                $('#table-data').append(`
                
                    <tr>
                        <td>${v.nama_jenis_pengajuan}</td>
                        <td>${v.no_surat_pengajuan_proyek}</td>
                        <td class="text-center">${v.tanggal_pengajuan_proyek}</td>
                        <td class="text-right">${Rp(v.total_nilai_pengajuan)}</td>
                        <td class="text-right">${Rp(v.total_actual_nilai_pengajuan)}</td>
                    </tr>
                
                `);

                total        += parseInt(v.total_nilai_pengajuan);
                total_actual += parseInt(v.total_actual_nilai_pengajuan);

            })

            $('#grandtotal').html(Rp(total));
            $('#grandtotal-actual').html(Rp(total_actual));

        })
        .catch(err => console.log(err));

    })

</script>

<?php $this->endSection(); ?>