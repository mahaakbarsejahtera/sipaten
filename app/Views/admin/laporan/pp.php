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
                    <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-pengajuan" class="btn btn-primary mb-3" id="js-trigger-modal-pengajuan">Tambah Data</a> -->
                </div>
                <div class="col-12 col-md-9">
                    <form class="w-100" id="filter-form">

                        <div class="form-row d-flex justify-content-end">
                            <div class="form-group col-12 col-md-4">
                                <input type="text" class="form-control" placeholder="Search" id="filter-search">
                            </div>
                        </div>

                        
                    
                    </form>
                </div>

                <div class="col-12">
                    <div><?php echo $table; ?></div>
                    <div id="pagination-wrapper"></div>
                </div>
            </div>    
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

    <!-- BOQ Modal -->
    <div class="modal fade" id="modal-pengajuan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Laporan Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
           
                    <div id="js-laporan-pp-item">
                        <div class="">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="200" class="text-center align-middle">Nama</th>
                                            <th width="20" class="text-center align-middle">Qty</th>
                                            <th width="100" class="text-center align-middle">Harga</th>
                                            <th width="100" class="text-center">Total</th>
                                            <th width="100" class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> 
    </div>
    <!-- /BOQ Modal -->


<?php $this->endSection(); ?>

<?php $this->section('headerScript'); ?>

    <link rel="stylesheet" href="<?php echo base_url("/assets/adminlte/plugins/select2/css/select2.min.css") ?>"/>
    <link rel="stylesheet" href="<?php echo base_url("/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>"/>

<?php $this->endSection(); ?>


<?php $this->section('footerScript') ?>

<script src="<?php echo base_url('/assets/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('/assets/plugins/tinymce/js/tinymce/tinymce.min.js') ?>"></script>

<script>
    $(function(){

        let truthAction = $('#i-truth_action');
        let tableData = $('#table-data');
        let form = $('#form');

        $('#js-trigger-modal-pengajuan').click(function(e){
            e.preventDefault();
            clearForm();
            $('#js-operasional-item').find('tbody').html('');
            $('#js-operasional-item').collapse('hide');
            $('#js-trigger-modal-pengajuan').val('');
        })

        $('#i-id_anggaran_item').select2({
            themes: 'bootstrap'
        });

        tinymce.init({
            selector: '#i-nego_term',
            menubar: false,
            plugins: "lists",
            toolbar: "numlist bullist",
        });

        loadData();
        function loadData(data = {}) {
            
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="12">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: `${baseUrl}/api/laporan/pengajuan-proyek`,
                data: data,
                success: function(response) {
                    console.log('load data', response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        
                        html += `
                        
                            <tr>
                                <td>
                                    <div>${v.nama_pekerjaan}</div>
                                    <div><a href="${baseUrl}/dashboard/laporan/pengajuan/?id_pengajuan=${v.id_pengajuan_proyek}" target="_blank">Download</a></div>
                                </td>
                                <td>${v.no_surat_pengajuan_proyek}</td>
                                <td>${v.tanggal_pengajuan_proyek}</td>
                                <td>${v.due_date_pengajuan_proyek}</td>
                                <td>${Rp(v.nilai_pengajuan)}</td>
                                  
                                <td>
                                    <div>${v.pengaju.user_fullname}</div>
                                </td>
                                <td>

                                    <a 
                                        href="javascript:void(0)"  
                                        data-toggle="table-action"  
                                        data-action="lihat-laporan" 
                                        data-id_pp="${v.id_pengajuan_proyek}" data-id_lpp="${v.id_lpp}">
                                            <span>Lihat Laporan</span>
                                    </a>
                  
                                </td>
                            </tr>
                        
                        `
                    })

                    tableData.find('tbody').html(html);
                    $('#pagination-wrapper').html(response.data.pagination);
                },
                error: function(err) {
                    console.log('operasonal', err);
                }
            })

        }
      
        function clearForm() {
            $('#form-pengajuan')[0].reset();
            $('#i-id_permintaan').attr('disabled', false);
            $('#i-id_nego').val('');
            $('#i-truth_action').val('');
        }



        $(document).on('click', '#pagination-wrapper .page-item', function(e){
            e.preventDefault();

            let pagination = $(this).data('ci-pagination');

            console.log('ci-pagination', pagination);

            loadData({
                page_group1: pagination,
            })
        
        })

        $(document).on('click', '[data-toggle=table-action]', function(e){
            e.preventDefault();
            
            let btn = $(this);
            let action = btn.data('action');
            let tbody ;


            switch(action) {    
                case 'edit':
                    $('#form-operasional-item')[0].reset();
                    getData(btn.data('id'))
                    .then((response) => {
                        console.log('edit data');
                        btn.html(`<span class="fas fa-edit"></span>`)
                        return response;

                    })
                    .then((response) => {

                        console.log(response);

                        for(d in response.data) {
                            $('#i-' . d).val(response.data[d]);
                        }
                        $('#modal-pengajuan').modal('show');
                        
                    });

                    break;

                case 'delete':

                    let tryToDelete = confirm('DELETE ???');

                    if(tryToDelete) {
                        deleteData($(this).data('id'))
                        .then(() => btn.html(`<span class="fas fa-trash"></span>`))
                    }else {
                        btn.html(`<span class="fas fa-trash"></span>`)
                    }

                    break;

                case 'lihat-laporan':

                    let idPp = btn.data('id_pp');
                    let idLpp = btn.data('id_lpp');

                    console.log(' lihat laporan ', { 
                        id_pp: idPp,
                        id_lpp: idLpp,
                    })

                    if(idLpp) {
                    


                    }
                    else {

                        let data = {
                            id_pp: idPp,
                            status_lpp: 'Pending'
                        }
                        
                        LaporanPengajuanProyek
                            .add(data) 
                            .then(afterCreate => {
                                console.log('afterCreate', afterCreate)
                                
                                PengajuanProyek
                                    .items({
                                        no_limit: true,
                                        filters: [
                                            { key: 'id_pengajuan_proyek', value: idPp }
                                        ]
                                    })
                                    .then( items => {
                                        
                                        console.log('get pengajuan protek items', items);
                                    
                                    })


                            })

                    }

                    $('#modal-pengajuan').modal('show');

                    break;
                
        
            }
        })

        function getFilters() {

            let filters = [];

            if(($('#filter-search').val())) {

                filters.push({ key: 'search', value: $('#filter-search').val() })

            }

            return filters;
        }


        $('[data-toggle=sort]').click(function(e){
            
            e.preventDefault();

            let currentPagination = $('#pagination-wrapper .page-item.active').find('a').data('ci-pagination')
            let order = $(this).data('sort');
            let orderby = $(this).data('field');
            loadData({
                page_group1: currentPagination,
                orders: [{
                    orderby: orderby,
                    order: order,
                }],
                filters: getFilters()
            })
        })


        $('#filter-search').keyup(function(){

            let dataToggleSort = $('[data-toggle=sort]');
            let order = dataToggleSort.data('sort');
            let orderby = dataToggleSort.data('field');


            console.log()
            
            loadData({
                //orders: [{ orderby: orderby, order: order }],
                filters: [
                    { key: 'search', value: $(this).val() }
                ]
            })
        })


        $('#js-save-pengajuan').click(function(e){
            e.preventDefault();

            saveData()
            .then(afterSave => {
                console.log('afterSave', afterSave);
                $('#i-id_pengajuan_proyek').val(afterSave.data.id_pengajuan_proyek);
                $('#i-no_surat_pengajuan_proyek').val(afterSave.data.no_surat_pengajuan_proyek);
                $('#js-operasional-item').collapse('show');

            })
            .then(afterSave => {

                let idAnggaran = $('#i-id_anggaran').val();
                getAnggaranItem({
                    no_limit: true,
                    filters: [
                        { key: 'id_anggaran', value: idAnggaran }
                    ]
                })
                .then(anggaranItems => {

                    let options = "<option value=''>Pilih</option>";
                    anggaranItems.data.lists.map((v,i) => {
                        options += `<option value="${v.id_anggaran_item}">${v.anggaran_item}</option>`;
                    })
                    $('#i-id_anggaran_item').html(options);

                })

            })
            .catch(err => console.log('afterSaveErr', err));

        })

       
    })
</script>

<?php $this->endSection(); ?>   