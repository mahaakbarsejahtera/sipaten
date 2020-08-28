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
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#form-modal" class="btn btn-primary mb-3" id="js-add-tambah-data">Tambah Data</a>
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
                <!-- <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div> -->
                <div class="modal-body">
                    <form action="" id="form">

                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_jenis_pengajuan" id="i-id_jenis_pengajuan">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <label for="i-nama_jenis_pengajuan">Nama</label>
                            <input type="text" name="nama_jenis_pengajuan" class="form-control" id="i-nama_jenis_pengajuan">
                        </div>


                        <div class="form-group">
                            <label for="i-kode_jenis_pengajuan">Kode</label>
                            <input type="text" name="kode_jenis_pengajuan" class="form-control" id="i-kode_jenis_pengajuan">
                        </div>
          

                        <div class="form-group">
                            <label for="i-jenis_pengajuan_term">Ketentuan</label>
                            <textarea name="jenis_pengajuan_term" id="i-jenis_pengajuan_term" rows="10" class="form-control"></textarea>
                        </div>

                        

                        <div class="collapse" id="js-penanggung-jawab">

                            <div class="table-responsive">

                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Sebagai</th>
                                        </tr>
                                        <tbody id="js-penanggung-jawab-tbody"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">
                                                    <div class="form-row">
                                                        <div class="form-group col-12 col-md-5">
                                                            <select name="penanggung_jawab_user" id="i-penanggung_jawab_user" class="form-control">
                                                                <option value="">Pilih</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-12 col-md-5">
                                                            <select name="sebagai_penanggung_jawab" id="i-sebagai_penanggung_jawab" class="form-control">
                                                                <option value="Di Periksa">Di Periksa</option>
                                                                <option value="Di Ketahui">Di Ketahui</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <a href="javascript:void(0)" class="btn btn-primary" id="js-add-penanggung_jawab">
                                                                <span class="fas fa-plus"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </thead>
                                </table>

                            </div>

                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Jenis Pengajuan</button>

                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div> -->
            </div>
        </div>
    </div>

<?php $this->endSection(); ?>


<?php $this->section('headerScript') ?>
    <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/jquery-ui/jquery-ui.min.css') ?>">
<?php $this->endSection() ?>




<?php $this->section('footerScript') ?>

<script src="<?php echo base_url('/assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>

<script>

    $(function(){

        let truthAction = $('#i-truth_action');
        let tableData = $('#table-data');
        let form = $('#form');

        $('#js-add-tambah-data').click(function(e){
            e.preventDefault();
            clearForm();
        })

        function getUsers() {
            return $.ajax({
                url: `${baseUrl}/api/users`
            })
        }

        getUsers()
        .then(response => {
            console.log('response', response);
            let html = `<option value=''>Pilih</option>`;

            response.data.lists.map((v,i) => {
                html += `<option value="${v.id_user}">${v.user_fullname}</option>`;
            })

            $('#i-penanggung_jawab_user').html(html);
        })
        .catch(err => {
            console.log('err', err);
        })

        loadData();
        function loadData(data = {}) {
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="4">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: `${baseUrl}/api/jenis-pengajuan`,
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {

                        let penanggungJawabHTML = ``;

                        v.penanggung_jawab.map((value, key) => {
                            penanggungJawabHTML += `

                                <div>${value.user_fullname} - ${value.role_name}</div>
                            
                            `
                        })

                        html += `
                        
                            <tr>
                                <td width="300">${v.nama_jenis_pengajuan}</td>
                                <td>${v.jenis_pengajuan_term}</td>
                                <td width="300">${penanggungJawabHTML}</td>
                                <td width="200">

                                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="table-action" data-action="edit" data-id="${v.id_jenis_pengajuan}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="table-action"  data-action="delete" data-id="${v.id_jenis_pengajuan}">
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


        function addData() {

            let data = form.serialize();

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/jenis-pengajuan`,
                data: data, 
                success: function(response) {
                    console.log('success response add', response);
                    switch(response.code) {
                        case 200: 
                            Toast('success', 'Berhasil menambahkan data');
                            $('#i-id_jenis_pengajuan').val(response.data.id_jenis_pengajuan)
                            //clearForm();
                            $('#js-penanggung-jawab').collapse('show')
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
            
            let data = form.serialize();

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/jenis-pengajuan/update`,
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
                url: `${baseUrl}/api/jenis-pengajuan/show/${id}`,
                success: function(response) {

                    truthAction.val('update');

                    for(data in response.data) {
                        $('#i-' + data).val(response.data[data]);
                    }
                    
                    $('#js-penanggung-jawab-tbody').html('');
                    loadPenanggungJawab({
                        filters: [
                            { 
                                key: 'id_jenis_pengajuan',  
                                value: response.data.id_jenis_pengajuan 
                            }
                        ]
                    })

                    .then(results => {
                      
                        console.log('load Penanggung Jawab', results)
                        results.data.lists.map((v,i) => {
                            $('#js-penanggung-jawab-tbody').append(createPenanggungJawabRow(v));
                        })

                        $('#js-penanggung-jawab').collapse('show');
                    })
                    
                    $('#form-modal').modal('show');
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/jenis-pengajuan/${id}/delete`,
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
            $('#i-id_jenis_pengajuan').val('');
            $('#i-truth_action').val('');
            $('#js-penanggung-jawab').collapse('hide');
            $('#js-penanggung-jawab-tbody').html('');
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


            btn.html(`<span class="fas fa-spin fa-spinner"></span>`);

            console.log(action);
            switch(action) {    
                case 'edit':

                    getData($(this).data('id'))
                    .then(() => btn.html(`<span class="fas fa-edit"></span>`));

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
                //orders: [{ orderby: orderby, order: order }],
                filters: [
                    { key: 'search', value: $(this).val() }
                ]
            })
        })

        function loadPenanggungJawab(data) {
            return $.ajax({
                url: `${baseUrl}/api/penanggung-jawab`,
                data: data
            })
        }

        function addPenanggungJawab(data) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/penanggung-jawab`,
                data: data
            })
        }

        function deletePenanggungJawab(id) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/penanggung-jawab/${id}/delete`
            })
        }

        function createPenanggungJawabRow(data) {  
            return `
            
                <tr>
                    <td>
                        <div>
                            <div>${data.user_fullname} - ${data.role_name}</div>
                            <div>
                                <a href="javascript:void(0)" class="js-delete-penanggung_jawab" data-id="${data.id_penanggung_jawab}">
                                    <span>Delete</span>
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>${data.sebagai_penanggung_jawab}<div>
                        
                    </td>
                </tr>

            
            `
        }

        $(document).on('click', '.js-delete-penanggung_jawab', function(e){
            e.preventDefault();
            let btn = $(this)

            deletePenanggungJawab(btn.data('id'))
            .then(response => {

                $('#js-penanggung-jawab-tbody').html('');
                loadPenanggungJawab({
                    filters: [
                        { 
                            key: 'id_jenis_pengajuan',  
                            value: response.data.id_jenis_pengajuan 
                        }
                    ]
                })

                .then(results => {
                    console.log('load Penanggung Jawab', results)
                    results.data.lists.map((v,i) => {
                        $('#js-penanggung-jawab-tbody').append(createPenanggungJawabRow(v));
                    })

                })

            })
        })

        let sortAble = $('#js-penanggung-jawab-tbody').sortable();

        $('#js-add-penanggung_jawab').click(function(e){

            e.preventDefault();

            let data = {
                penanggung_jawab_user: $('#i-penanggung_jawab_user').val(),
                id_jenis_pengajuan: $('#i-id_jenis_pengajuan').val(),
                sebagai_penanggung_jawab: $('#i-sebagai_penanggung_jawab').val(),
            };

            addPenanggungJawab(data)
            .then(response => {
                console.log('response add penanggung jawanb', response);
                $('#js-penanggung-jawab-tbody').html('');
                loadPenanggungJawab({
                    filters: [
                        { 
                            key: 'id_jenis_pengajuan',  
                            value: response.data.id_jenis_pengajuan 
                        }
                    ]
                })

                .then(results => {
                    console.log('load Penanggung Jawab', results)
                    results.data.lists.map((v,i) => {
                        $('#js-penanggung-jawab-tbody').append(createPenanggungJawabRow(v));
                    })

                })

                loadData();

               
            })
            .catch(err => console.log(err));

        })

    })
</script>

<?php $this->endSection(); ?>