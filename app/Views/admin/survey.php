<?php $this->extend('admin/layouts'); ?>

<?php $this->section('sidebarMenu'); ?>

    <li class="nav-item">
        <a href="<?php echo base_url('/dashboard/permintaan') ?>" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>Permintaan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('/dashboard/users') ?>" class="nav-link">
            <i class="nav-icon far fa-user"></i>
            <p>Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('/dashboard/roles') ?>" class="nav-link">
            <i class="nav-icon far fa-star"></i>
            <p>Roles</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url('/dashboard/survey') ?>" class="nav-link">
            <i class="nav-icon far fa-star"></i>
            <p>Survey</p>
        </a>
    </li>

<?php $this->endSection(); ?>

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
        <div class="modal-dialog modal-lg" role="document">
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
                        <input type="hidden" name="id_permintaan" id="i-id_permintaan">
                        <input type="hidden" name="id_survey" id="i-id_survey">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <label for="i-role_name">Surveyor</label>
                            <select name="permintaan_user" id="i-permintaan_user" class="form-control" style="max-width: 300px">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <input id="i-survey_item_name" type="text" class="form-control" placeholder="Nama item">
                                        </th>
                                        <th>
                                            <input id="i-survey_item_qty" type="text" class="form-control" placeholder="Jumlah">
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <input id="i-survey_item_unit" type="text" class="form-control mr-2" placeholder="Unit">
                                                <a href="javascript:void(0)" id="js-add-new-item" class="btn btn-primary"><span class="fas fa-plus"></span></a>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Hasil Survey</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $this->endSection(); ?>


<?php $this->section('footerScript') ?>

<script>
    $(function(){

        let truthAction = $('#i-truth_action');
        let tableData = $('#table-data');
        let form = $('#form');

        loadData();
        function loadData(data = {}) {
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="7">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/permintaan') ?>",
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {
                    
                        let surveyBtn = "";
                        if(v.id_survey == null || v.id_survey == "") surveyBtn = `<a href="javascript:void(0)" data-toggle="table-action" data-action="create-hasil-survey" data-id="${v.id_permintaan}">Buat Hasil Survey</a>`;
                        else surveyBtn = `<a href="javascript:void(0)" data-toggle="table-action" data-action="load-hasil-survey" data-id="${v.id_survey}">Lihat Hasil Survey</a>`;
                        html += `
                        
                            <tr>
                                <td>${v.nama_pekerjaan}</td>
                                <td>${v.user_fullname}</td>
                                <td>${v.permintaan_status}</td>
                                <td width="200">${surveyBtn}</td>
                            </tr>
                        
                        `
                    })

                    tableData.find('tbody').html(html);
                    $('#pagination-wrapper').html(response.data.pagination);
                }
            })

        }

        getUsers()
        .then(response => {
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_user}">${v.user_fullname} - ${v.role_name}</option>`;
            })

            $('#i-permintaan_user').html(html);

        });

        getPermintaan()
        .then(response => {
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_permintaan}">${v.nama_pekerjaan} - ${v.permintaan_status}</option>`;
            })

            $('#i-id_permintaan').html(html);

        });


        function getUsers() {

            return $.ajax({
                url: "<?php echo base_url('/api/users?page_group1=-1') ?>",
            })

        }

        function getPermintaan() {

            return $.ajax({
                url: "<?php echo base_url('/api/permintaan?page_group1=-1') ?>",
            })

        }


        function addData() {

            let data = form.serialize();

            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/survey') ?>",
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
            
            let data = form.serialize();

            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/survey/update') ?>",
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
                url: `<?php echo base_url('/api/survey/show') ?>/${id}`,
                success: function(response) {

                    truthAction.val('update');

                    for(data in response.data) {
                        $('#i-' + data).val(response.data[data]);
                    }
                    
                    $('#form-modal').modal('show');
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `<?php echo base_url('/api/survey') ?>/${id}/delete`,
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
            else addHasilSurvey();

        }

        function clearForm() {
            $('#form')[0].reset();
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

        function createSurvey( id_permintaan ) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('api/survey/') ?>",
                data: {
                    id_permintaan: id_permintaan
                }
            });  
        }




        function addHasilSurvey( id_survey ) {


            let data = form.serialize();


            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/survey/item/add') ?>",
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




        $(document).on('click', '[data-toggle=table-action]', function(e){
            e.preventDefault();
            
            let btn = $(this);
            let action = btn.data('action');


            btn.html(`<span class="fas fa-spin fa-spinner"></span>`);

            console.log(action);
            switch(action) {    

                case 'create-hasil-survey':
                    
                    createSurvey(btn.data('id'))
                    .then(response => {

                        Toast('success', 'Generated');

                        $('#form-modal').modal('show');

                    });
                    

                    break;

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

                case 'create-timeline': 
                    
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



        $('#js-add-new-item').click(function(e){
            e.preventDefault();



            let item    = $('#i-survey_item_name').val();
            let qty     = $('#i-survey_item_qty').val();
            let unit    = $('#i-survey_item_unit').val();

            let html = `
                <tr>
                    <th>
                        <input name="survey_item_name[]" type="text" class="form-control" placeholder="Nama item" value="${item}">
                    </th>
                    <th>
                        <input name="survey_item_qty[]" type="text" class="form-control" placeholder="Jumlah" value="${qty}">
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <input name="survey_item_unit[]" type="text" class="form-control mr-2" placeholder="Unit" value="${unit}">
                            <a href="javascript:void(0)" id="js-remove-item" class="btn btn-danger"><span class="fas fa-minus"></span></a>
                        </div>
                    </th>
                </tr>
            `;

            $(this)
                .parent()
                .parent()
                .parent()
                .parent()
                .prev()
                .append(html);

            $('#i-survey_item_name').val('');
            $('#i-survey_item_qty').val('');
            $('#i-survey_item_unit').val('');
        
        })

    })
</script>

<?php $this->endSection(); ?>