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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Operasional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <form action="" id="form-pengajuan">
                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_pengajuan_proyek" id="i-id_pengajuan_proyek">
                        <input type="hidden" name="_method" value="POST">
                     
                        <div class="row">
                            <div class="col-12 col-md-8">
                                
                                <div class="form-group">
                                    <label for="i-id_pengaju">Pengaju</label>
                                    <select name="id_pengaju" id="i-id_pengaju" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="i-id_jenis_pengajuan">Jenis Pengajuan</label>
                                    <select name="id_jenis_pengajuan" id="i-id_jenis_pengajuan" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="i-no_surat_pengajuan_proyek">No Surat</label>
                                    <input type="text" name="no_surat_pengajuan_proyek" id="i-no_surat_pengajuan_proyek" class="form-control" disabled>
                                </div>
                                

                                <div class="form-group">
                                    <label for="i-id_anggaran">Perihal</label>
                                    <select name="id_anggaran" id="i-id_anggaran" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="i-perihal_pengajuan_proyek">Perihal</label>
                                    <input type="text" name="perihal_pengajuan_proyek" id="i-perihal_pengajuan_proyek" value="" class="form-control">
                                </div> -->
                            </div>  

                            <?php $current_date = date('Y-m-d'); ?>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="i-tanggal_pengajuan_proyek">Tanggal Pengajuan</label>
                                    <input type="date" name="tanggal_pengajuan_proyek" id="i-tanggal_pengajuan_proyek" value="<?php echo $current_date ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="i-due_date_pengajuan_proyek">Due Date Pengajuan</label>

                                    <input type="date" name="due_date_pengajuan_proyek" id="i-due_date_pengajuan_proyek" value="<?php echo date('Y-m-d', strtotime("{$current_date} + 14 days")) ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="js-save-pengajuan">Simpan Pengajuan</button>
                        
                    </form>

                    <hr>
                    
                    <div id="js-operasional-item" class="collapse">
                        <form action="" id="form-operasional-item">
                            <input type="hidden" name="id_pengajuan_proyek_item" id="i-id_pengajuan_proyek_item">
                            <div class="row">
                                <div class="col-12 col-md-8">

                                    <div class="form-group">
                                        <label for="i-id_anggaran_item">Nama</label>
                                        <!-- <input type="text" name="pengajuan_proyek_name" class="form-control" id="i-pengajuan_proyek_name"> -->
                                        <select name="id_anggaran_item" id="i-id_anggaran_item" class="form-control"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="i-pengajuan_proyek_desc">Deskripsi</label>
                                        <textarea name="pengajuan_proyek_desc" class="form-control" rows="5" id="i-pengajuan_proyek_desc"></textarea>
                                    </div>


                                </div>
                                <div class="col-12 col-md-4">

                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-4">
                                            <label for="i-pengajuan_proyek_qty">Qty</label>
                                            <input type="text" name="pengajuan_proyek_qty" class="form-control" id="i-pengajuan_proyek_qty">
                                        </div>

                                        <div class="form-group col-12 col-md-8">
                                            <label for="i-pengajuan_proyek_price">Harga</label>
                                            <input type="text" name="pengajuan_proyek_price" class="form-control" id="i-pengajuan_proyek_price">
                                        </div>

                                        <!-- <div class="form-group col-6">
                                            <label for="i-pengajuan_proyek_unit">Satuan</label>
                                            <input type="text" name="pengajuan_proyek_unit" class="form-control" id="i-pengajuan_proyek_unit">
                                        </div> -->
                                    </div>

                                    <button class="btn btn-primary" id="js-add-pengajuan-item">Simpan Item</button>
                                    <button class="btn btn-warning" id="js-clear-pengajuan-item">Cancel</button>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="i-pengajuan_proyek_keterangan">Keterangan</label>
                                <textarea name="pengajuan_proyek_keterangan" class="form-control" rows="5" id="i-pengajuan_proyek_keterangan"></textarea>
                            </div>
                        </form>

                        <div class="">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle">Nama</th>
                                            <th rowspan="2" class="text-center align-middle">Qty</th>
                                            <th rowspan="2" class="text-center align-middle">Harga</th>
                                            <th colspan="2" class="text-center">Total</th>
                                            <th colspan="2" class="text-center">Keterangan</th>
                                            <th>Aksi</th>
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
                url: "<?php echo base_url('/api/pengajuan-proyek') ?>",
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
                                    <span class="${parseFloat(v.total_nilai_pengajuan) > parseFloat(v.total_anggaran) ? 'text-danger' : 'text-success'} ">${Rp(v.total_nilai_pengajuan)}</span> / ${Rp(v.total_anggaran)}
                                </td>
                                <td>

                                    <a href="javascript:void(0)"  data-toggle="table-action"  data-action="lihat-laporan" data-id="${v.id_pengajuan_proyek}">Lihat Laporan</a>
                  
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

        // <a href="javascript:void(0)" class="btn btn-warning mb-2" title="Edit Pengajuan" data-toggle="table-action" data-action="edit" data-id="${v.id_pengajuan_proyek}" data-permintaan="${v.id_permintaan}">
        //     <span class="fas fa-edit"></span>
        // </a>
        
        // <a href="javascript:void(0)" class="btn btn-danger mb-2" title="Hapus Pengajuan" data-toggle="table-action"  data-action="delete" data-id="${v.id_pengajuan_proyek}">
        //     <span class="fas fa-trash"></span>
        // </a>

    
        getAnggaran()
        .then(response => {
            console.log('getPermintaan');
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_anggaran}">${v.nama_pekerjaan}</option>`;
            })

            $('#i-id_anggaran').html(html);
            $('#i-id_anggaran').select2({
                themes: 'bootstrap'
            });

        }).catch(err => {
            console.log(err);
        });

        

        getJenisPengajuan()
        .then(response => {
            console.log('getJenisPengajuan', response);
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_jenis_pengajuan}">${v.kode_jenis_pengajuan} - ${v.nama_jenis_pengajuan}</option>`;
            })

            $('#i-id_jenis_pengajuan').html(html);

        }).catch(err => {
            console.log(err);
        });

        getPengaju()
        .then(response => {
            console.log('getJenisPengajuan', response);
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_user}">${v.user_fullname} - ${v.role_name}</option>`;
            })

            $('#i-id_pengaju').html(html);

        }).catch(err => {
            console.log(err);
        });

        

        function getAnggaran(data = {}) {

            return $.ajax({
                url: `${baseUrl}/api/anggaran?page_group1=-1`,
                data: data
            })

        }

        function getAnggaranItem(data = {}) {
            return $.ajax({
                url: `${baseUrl}/api/anggaran-item`,
                data: data,
            }) 
        }

        function getJenisPengajuan() {
            return $.ajax({
                url: `${baseUrl}/api/jenis-pengajuan?page_group1=-1`,
            })
        }

        function getPengaju(data = {}) {

            return $.ajax({
                url: `${baseUrl}/api/users?page_group1=-1`,
                data: data
            })

        }

        function addData() {

            let form = $('#form-pengajuan');
            let data = form.serialize();

            
            console.log('add data', data);

            // /return false;
            /** let data = {
                id_permintaan: $('#i-id_permintaan').val(),
                nego_term: tinyMCE.activeEditor.getContent(),
                nego_pic_nama: $('#i-nego_pic_nama').val(),
                nego_pic_jabatan: $('#i-nego_pic_jabatan').val(),
                nego_tgl_surat: $('#i-nego_tgl_surat').val(),
                nego_lokasi: $('#i-nego_lokasi').val(),
                nego_no: $('#i-nego_no').val()
            } **/ 

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/pengajuan-proyek`,
                data: data, 
                success: function(response) {
                    console.log('success response add', response);
                    switch(response.code) {

                        case 200: 
                            Toast('success', 'Berhasil menambahkan data');
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
            
            
            let form = $('#form-pengajuan');
            let data = form.serialize();

            console.log('update data', data);
            /** let data = {
                id_nego: $('#i-id_nego').val(),
                id_permintaan: $('#i-id_permintaan').val(),
                nego_term: tinyMCE.activeEditor.getContent(),
                nego_pic_nama: $('#i-nego_pic_nama').val(),
                nego_pic_jabatan: $('#i-nego_pic_jabatan').val(),
                nego_no: $('#i-nego_no').val(),
                nego_tgl_surat: $('#i-nego_tgl_surat').val(),
                nego_lokasi: $('#i-nego_lokasi').val(),
            } **/

            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/pengajuan-proyek/update') ?>",
                data: data, 
                success: function(response) {
                    console.log('success response add', response);

                    switch(response.code) {

                        case 200: 
                            Toast('success', 'Berhasil memperbaharui data');
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
                url: `${baseUrl}/api/pengajuan-proyek/show/${id}`,
                success: function(response) {
                    truthAction.val('update');

                    for(data in response.data) {
                        
                        if(data == 'nego_term') {
                            tinymce.activeEditor.setContent(response.data[data]);
                        }else {
                            $('#i-' + data).val(response.data[data]);
                        }
                        

                    }

                    loadPengajuanProyekItem({
                        filters: [
                            { key: 'id_pengajuan_proyek', value: response.data.id_pengajuan_proyek }
                        ]
                    })
                    .then(results => {
                        
                        let tbody = $('#js-operasional-item').find('tbody');
                        tbody.html('');
                        results.data.lists.map((v, i) => {
                            tbody.append(createRowPengajuanItem(v));
                        })
                    })
                    .then(() => {

                        getAnggaranItem({
                            no_limit: true,
                            filters: [
                                { key: 'id_anggaran', value: $('#i-id_anggaran').val() }
                            ]
                        })
                        .then(anggaranItems => {
                            console.log('anggaran items', anggaranItems);
                            let options = "<option value=''>Pilih</option>";
                            anggaranItems.data.lists.map((v,i) => {
                                options += `<option value="${v.id_anggaran_item}">${v.anggaran_item} - Tersisa (${v.sisa_qty} ${v.anggaran_unit}) - Anggaran (${Rp(v.sisa_price)})</option>`;
                            })
                            $('#i-id_anggaran_item').html(options);
                            $('#i-id_anggaran_item').select2();
                        })

                    })



                    $('#js-operasional-item').collapse('show');
                    
                    $('#pengajuan-modal').modal('show');
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/pengajuan-proyek/${id}/delete`,
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

            if(truthAction.val() == 'update') return updateData();
            
            return addData();

        }

      
        function clearForm() {
            $('#form-pengajuan')[0].reset();
            //$('#form-estimasi').find('tbody').html('');
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

                        // $('#i-id_permintaan').val(data.data.id_permintaan);
                        // $('#i-id_permintaan').attr('disabled', true);

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
 
        function createRowPengajuanItem(data) {

            let stringfy = JSON.stringify(data);

            html = `<tr>
                <td class="text-left align-middle">
                    <div class="font-weight-bold">${data.anggaran_item}</div>
                    <div><pre class="p-0 m-0">${data.pengajuan_proyek_desc}</pre></div>
                </td>
                <td class="text-center align-middle">${data.pengajuan_proyek_qty} ${data.anggaran_unit}</td>
                <td class="text-right align-middle">${Rp(data.pengajuan_proyek_price)}</td>
                <td colspan="2" class="text-right align-middle">${Rp(data.pengajuan_proyek_qty * data.pengajuan_proyek_price)}</td>
                <td colspan="2" class="text-left align-middle">${data.pengajuan_proyek_keterangan}</td>
                <td width="150">
                    <a href="javascript:void(0)" 
                        class="btn btn-warning js-proyek-item-edit" 
                        data-id="${data.id_pengajuan_proyek}"
                        data-item='${JSON.stringify(data)}'>
                        <span class="fas fa-edit"></span>
                    </a>
                    <a 
                        href="javascript:void(0)" 
                        class="btn btn-danger js-proyek-item-delete" 
                        data-id="${data.id_pengajuan_proyek_item}"
                        data-item="">
                        <span class="fas fa-trash"></span>
                    </a>
                </td>
            </tr>`;
            return html;
        }

        $('#js-add-pengajuan-item').click(function(e){
            e.preventDefault();
            let idPengajuanProyekItem   = $('#i-id_pengajuan_proyek_item').val();
            let idPengajuanProyek       =  $('#i-id_pengajuan_proyek').val();
            let data = $('#form-operasional-item').serialize();
            data += "&id_pengajuan_proyek=" + idPengajuanProyek;


            //return false;
            
            let tbody = $('#js-operasional-item').find('tbody');

            if(idPengajuanProyekItem) 
            {
                
                data += "&id_pengajuan_proyek_item=" + idPengajuanProyekItem;
                
                updatePengajuanProyekItem(data)
                .then(response => {
                    
                    console.log('update pengajuan proyek item', response)

                    switch(response.code) {
                        case 200:
                            Toast('success', 'Item berhasil di tambahkan');

                            loadPengajuanProyekItem({
                                filters: [
                                    { key: 'id_pengajuan_proyek', value: response.data['id_pengajuan_proyek'] }
                                ]
                            })
                            .then(results => {
                                
                                let tbody = $('#js-operasional-item').find('tbody');
                                tbody.html('');
                                results.data.lists.map((v, i) => {
                                    tbody.append(createRowPengajuanItem(v));
                                })
                            })

                            
                            $('#i-id_pengajuan_proyek_item').val('');
                            $('#i-id_anggaran_item').val('');
                            $('#i-id_anggaran_item').trigger('change');
                            $('#i-pengajuan_proyek_desc').val('');
                            $('#i-pengajuan_proyek_qty').val('');
                            $('#i-pengajuan_proyek_unit').val('');
                            $('#i-pengajuan_proyek_price').val('');
                            $('#i-pengajuan_proyek_keterangan').val('');
                            
                            $('#i-id_anggaran_item').val(null).trigger('change');
                            loadData();
                            
                            break;

                        case 400: 
                            
                            for(err in response.errors) {
                                Toast('warning', response.errors[err]);
                            } 
                            break;
                    }
                    



                });
            } else {
                addPengajuanProyekItem(data)
                .then(response => {
                    
                    console.log('add pengajuan proyek item', response)
                    
                    switch(response.code) {


                        case 200:

                            tbody.append(createRowPengajuanItem(response.data));
                    
                            Toast('success', 'Item berhasil di tambahkan');

                            $('#i-id_pengajuan_proyek_item').val('');
                            $('#i-id_anggaran_item').val('');
                            $('#i-id_anggaran_item').trigger('change');
                            $('#i-pengajuan_proyek_desc').val('');
                            $('#i-pengajuan_proyek_qty').val('');
                            $('#i-pengajuan_proyek_unit').val('');
                            $('#i-pengajuan_proyek_price').val('');
                            $('#i-pengajuan_proyek_keterangan').val('');

                            $('#i-id_anggaran_item').val(null).trigger('change');
                            loadData();


                            break;


                        case 400:

                            for(err in response.errors) {
                                Toast('warning', response.errors[err]);
                            } 

                            break;

                    }
                   
                });
            }

            
        })

        $(document).on('click', '.js-proyek-item-edit', function(e){
            e.preventDefault();
            let btn = $(this);
            let item = btn.data('item');

            console.log('edit item', item);

            $('#i-id_pengajuan_proyek_item').val(item.id_pengajuan_proyek_item);
            $('#i-id_anggaran_item').val(item.id_anggaran_item);
            $('#i-id_anggaran_item').trigger('change');
            $('#i-pengajuan_proyek_desc').val(item.pengajuan_proyek_desc);
            $('#i-pengajuan_proyek_qty').val(item.pengajuan_proyek_qty);
            $('#i-pengajuan_proyek_unit').val(item.pengajuan_proyek_unit);
            $('#i-pengajuan_proyek_price').val(item.pengajuan_proyek_price);
            $('#i-pengajuan_proyek_keterangan').val(item.pengajuan_proyek_keterangan);

        })


        $(document).on('click', '.js-proyek-item-delete', function(e){
            let id = $(this).data('id');

            console.log('delete id', id);

            let isDelete = confirm('Delete ???');

            if(isDelete)
            {

                deletePengajuanItem(id)
                .then(response => {
                    console.log('pengajuan item', response);
                    Toast('success', 'Item berhasil di hapus');
                    $(this).parent().parent().remove();
                })

            }

            
        })

        $('#js-clear-pengajuan-item').click(function(e){
            e.preventDefault();
            $('#form-operasional-item')[0].reset();
            $('#i-id_pengajuan_proyek_item').val('');
        })

        function loadPengajuanProyekItem(data) {
            return $.ajax({
                url: `${baseUrl}/api/laporan/pengajuan-proyek-item`,
                data: data
            })
        }

        function addPengajuanProyekItem(data) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/laporan/pengajuan-proyek-item`,
                data: data, 
            })
        }

        function updatePengajuanProyekItem(data) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/laporan/pengajuan-proyek-item/update`,
                data: data, 
            })
        }

        function deletePengajuanItem(id) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/laporan/pengajuan-proyek-item/${id}/delete`,
            })
        }

       
    })
</script>

<?php $this->endSection(); ?>   