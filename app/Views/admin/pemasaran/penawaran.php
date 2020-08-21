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
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#form-modal" class="btn btn-primary mb-3">Tambah Data</a>
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

    
    <!-- Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
  
                <div class="modal-body">
                    <form action="" id="form">

                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_penawaran" id="i-id_penawaran">
                        <input type="hidden" name="_method" value="POST">
                        
                        <div class="form-group">
                            <label for="id_permintaan">Pekerjaan</label>
                            <select name="id_permintaan" id="i-id_permintaan" class="form-control" style="width: 100%;">
                                <option value="">Pilih</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Nomor</label>
                            <input type="text" class="form-control" id="i-penawaran_no" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="i-nama_customer">Customer</label>
                            <input type="text" class="form-control" id="i-nama_customer" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="i-nama_sales">Sales</label>
                            <input type="text" class="form-control" id="i-nama_sales" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="i-nilai_penawaran">Nilai Penawaran</label>
                            <input type="text" name="nilai_penawaran" class="form-control" id="i-nilai_penawaran" readonly>
                        </div>
                    
                        <div class="form-group">
                            <label for="i-penawaran_validasi_date">Tanggal Penawaran</label>
                            <input type="date" name="penawaran_validasi_date" class="form-control" id="i-penawaran_validasi_date">
                        </div>

                        <div class="form-group">
                            <label for="i-penawaran_due_date">Due Date Penawaran</label>
                            <input type="date" name="penawaran_due_date" class="form-control" id="i-penawaran_due_date">
                        </div>

                        <div class="form-group">
                            <label for="i-penawaran_term">Kondisi Penawaran</label>
                            <textarea name="penawaran_term" id="i-penawaran_term" rows="5" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Penawaran</button>

                    </form>
                </div>
            </div>
        </div>
    </div>




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

        tinymce.init({
            selector: '#i-penawaran_term',
            menubar: false,
            plugins: "lists",
            toolbar: "numlist bullist",
        });

        $('#form-modal').on('hide.bs.modal', function () {
            clearForm();
        })

        loadData();
        function loadData(data = {}) {
            
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="12">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/penawaran') ?>",
                data: data,
                success: function(response) {
                    console.log('load data', response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        
                        html += `
                        
                            <tr>
                                <td>
                                    <a href="${baseUrl}/dashboard/laporan/lampiran-penawaran?id_penawaran=${v.id_penawaran}" target="_blank">${v.penawaran_no}</a><br/>
                                    <a href="${baseUrl}/dashboard/laporan/estimasi/?id_permintaan=${v.id_permintaan}" target="_blank">${Rp(v.estimasi_harga_jual)}</a>
                                </td>
                                <td>
                                    <div>${v.nama_pekerjaan}</div>
                                </td>
                                <td>${v.nama_customer}</td>
                                <td>${v.user_fullname}</td>
                                <td>${Rp(v.estimasi_harga_pokok)}</td>
                                <td>
                                    <ol style="list-style: none;" class="p-0">
                                        <li>Due Date: <b>${v.penawaran_due_date}</b></li>
                                        <li>Tanggal Penawaran: <b>${v.penawaran_validasi_date}</b></li>
                                    <ol>
                                </td>
                                <td>${v.penawaran_term}</td>
                                <td>

                                    <a href="javascript:void(0)" class="btn btn-warning mb-2" title="Edit Permintaan" data-toggle="table-action" data-action="edit" data-id="${v.id_penawaran}" data-permintaan="${v.id_permintaan}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    
                                    <a href="javascript:void(0)" class="btn btn-danger mb-2" title="Hapus Permintaan" data-toggle="table-action"  data-action="delete" data-id="${v.id_penawaran}">
                                        <span class="fas fa-trash"></span>
                                    </a>

                                
                                </td>
                            </tr>
                        
                        `
                    })

                    tableData.find('tbody').html(html);
                    $('#pagination-wrapper').html(response.data.pagination);
                }
            })

        }

        getPermintaan()
        .then(response => {
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_permintaan}">${v.nama_pekerjaan}</option>`;
            })

            $('#i-id_permintaan').html(html);
            $('#i-id_permintaan').select2({
                themes: 'bootstrap'
            });

        });


        function getPermintaan() {

            return $.ajax({
                url: `${baseUrl}/api/permintaan?page_group1=-1`,
                data: {
                    filters: [{
                        key: 'permintaan_status',
                        value: 'Publish'
                    }]
                }
            })

        }

        function getInfoPermintaan(id) {
            return $.ajax({
                url: `${baseUrl}/api/permintaan/show/` + id,
            })
        }

        $('#i-id_permintaan').change(function(){
            getInfoPermintaan($(this).val())
            .then(response => {

                console.log('infor permintaan', response);
                $('#i-penawaran').val(`PN/${response.data.sales_code}/`);
                $('#i-nama_customer').val(response.data.nama_customer);
                $('#i-nama_sales').val(response.data.user_fullname);
                $('#i-nilai_penawaran').val(Rp(response.data.estimasi_harga_jual));
                
                


            })
        });



        function addData() {

            let data =  {
                id_permintaan: $('#i-id_permintaan').val(),
                //penawaran_no: $('#i-penawaran_no').val(),
                penawaran_term: tinyMCE.activeEditor.getContent(),
                penawaran_due_date: $('#i-penawaran_due_date').val(),
                penawaran_validasi_date: $('#i-penawaran_validasi_date').val()
            }

            console.log(data);
            //return false;
            
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/penawaran') ?>",
                data: data, 
                success: function(response) {
                    console.log('success response add', response);
                    switch(response.code) {

                        case 200: 
                            Toast('success', 'Berhasil menambahkan data');
                            clearForm();
                            loadData();
                        break;

                        case 400:
                            Toast('error', response.message);
                            break;

                    }
                    
                }, 
                error: function(response) {
                    Toast('error', 'Something Wrong!!!');
                }
            })

        }

        function updateData() {
            
            let data =  {
                id_penawaran: $('#i-id_penawaran').val(),
                id_permintaan: $('#i-id_permintaan').val(),
                //penawaran_no: $('#i-penawaran_no').val(),
                penawaran_term: tinyMCE.activeEditor.getContent(),
                penawaran_due_date: $('#i-penawaran_due_date').val(),
                penawaran_validasi_date: $('#i-penawaran_validasi_date').val()
            }


            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/penawaran/update') ?>",
                data: data, 
                success: function(response) {
                    console.log('success response add', response);

                    switch(response.code) {

                        case 200: 
                            Toast('success', 'Berhasil memperbaharui data');
                            clearForm();
                            loadData();
                        break;

                        case 400:
                            Toast('error', response.message);
                            break;
                    }
                    
                }, 
                error: function(response) {
                    console.log(response)
                    Toast('error', 'Something Wrong!!!');
                }
            })
        }
        
        function getData( id ) {
            
            return $.ajax({
                url: `<?php echo base_url('/api/penawaran/show') ?>/${id}`,
                success: function(response) {

                    truthAction.val('update');

                    for(data in response.data) {
                        $('#i-' + data).val(response.data[data]);
                    }
                    
                    $('#form-modal').modal('show');

                    return response;
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `<?php echo base_url('/api/penawaran') ?>/${id}/delete`,
                success: function(response) {
                    switch(response.code) {
                        case 200:
                            Toast('success', 'Data berhasil dihapus');
                            loadData();
                            break;

                        case 400:
                            Toast('warning', response.message);
                            break;
                    }
                },
                error: function(response) {
                    Toast('error','Something Wrong!!');
                }
            })
        }

        function saveData() {

            if(truthAction.val() == 'update') updateData();
            else addData();

        }

        function clearForm() {
            $('#form')[0].reset();
            $('#i-id_permintaan').val(null).trigger('change');
        }


        $('#js-save').click(function(e){{
            e.preventDefault();
            saveData();
        }})

        $(document).on('click', '#pagination-wrapper .page-item', function(e){
            e.preventDefault();

            let pagination = $(this).data('ci-pagination');

            console.log('ci-pagination', pagination);

            loadData({
                page_group1: pagination
            })
        
        })


        $(document).on('click', '[data-toggle=table-action]', function(e){
            e.preventDefault();
            
            let btn = $(this);
            let action = btn.data('action');
            let tbody ;


            //btn.html(`<span class="fas fa-spin fa-spinner"></span>`);
            console.log(action);
            switch(action) {    

                case 'edit':


                    $('#i-id_permintaan').val($(this).data('permintaan'));
                    $('#i-id_permintaan').trigger('change');

                    getData($(this).data('id'))
                    .then((response) => {
                        
                        tinymce.activeEditor.setContent(response.data.penawaran_term);
                        btn.html(`<span class="fas fa-edit"></span>`)
                    
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
                filters: [
                    { key: 'search', value: $(this).val() }
                ]
            })
        })


 
   


 
    

    })
</script>

<?php $this->endSection(); ?>