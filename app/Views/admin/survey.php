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
                            <label for="i-survey_user">Surveyor</label>
                            <select name="survey_user" id="i-survey_user" class="form-control" style="max-width: 300px">
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
                        if(v.id_survey == null || v.id_survey == "") {

                            surveyBtn = `<a href="javascript:void(0)" 
                                data-toggle="table-action" 
                                data-action="create-hasil-survey" 
                                data-permintaan="${v.id_permintaan}"
                                data-survey="${v.id_survey}">Buat Hasil Survey</a>`;
                        } 
                        else  { 
                            surveyBtn = `<a href="javascript:void(0)" 
                                data-toggle="table-action" 
                                data-action="load-hasil-survey" 
                                data-permintaan="${v.id_permintaan}"
                                data-survey="${v.id_survey}">Lihat Hasil Survey</a>`;
                        }
                        
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

            $('#i-survey_user').html(html);

        });

        /** 
        getPermintaan()
        .then(response => {
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_permintaan}">${v.nama_pekerjaan} - ${v.permintaan_status}</option>`;
            })

            $('#i-id_permintaan').html(html);

        });
         */


        function getUsers() {

            return $.ajax({
                url: "<?php echo base_url('/api/users?page_group1=-1') ?>",
                data: {
                    filters: [
                        {
                            key: 'user_status',
                            value: 'Active'
                        }
                    ]
                }
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

            //if(truthAction.val() == 'update') updateData();
            //else addHasilSurvey();

            saveHasilSurvey();

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

        function saveHasilSurvey() {
            return $.ajax({
                method: 'POST',
                data: {
                    id_permintaan: $('#i-id_permintaan').val(),
                    id_survey: $('#i-id_survey').val(),
                    survey_user: $('#i-survey_user').val(),
                },
                url: "<?php echo base_url("api/survey/update") ?>",
                success: function(response) {

                    console.log(response);
                    Toast('success', 'Berhasil menyimpan');


                }
            })
        }

        function createSurvey( id_permintaan ) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('api/survey/') ?>",
                data: {
                    id_permintaan: id_permintaan
                }
            });  
        }

        function addHasilSurvey() {
            
            let id_survey   = $('#i-id_survey').val();
            let item        = $('#i-survey_item_name').val();
            let qty         = $('#i-survey_item_qty').val();
            let unit        = $('#i-survey_item_unit').val();

            let data =  {
                id_survey: id_survey,
                survey_item_name: item,
                survey_item_qty: qty,
                survey_item_unit: unit,
                survey_divisi: 'teknik'                            
            }

            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/survey/item/add') ?>",
                data: data, 
                success: function(response) {

                    console.log('success response add', response);
                    
                    switch(response.code) {

                        case 200: 

                            Toast('success', 'Berhasil menambahkan data');

                            let html = `
                                <tr>
                                    <th>
                                        <input name="items[name][${response.data.item.id_survey_item}]" type="text" class="form-control" placeholder="Nama item" value="${item}" readonly>
                                    </th>
                                    <th>
                                        <input name="items[qty][${response.data.item.id_survey_item}]" type="text" class="form-control" placeholder="Jumlah" value="${qty}" readonly>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <input name="item[unit][${response.data.item.id_survey_item}]" type="text" class="form-control mr-2" placeholder="Unit" value="${unit}" readonly>
                                            <a href="javascript:void(0)" data-item="${response.data.item.id_survey_item}" class="btn btn-danger js-remove-item"><span class="fas fa-minus"></span></a>
                                        </div>
                                    </th>
                                </tr>
                            `;

                            $('#js-add-new-item')
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .prev()
                                .append(html);

                            $('#i-survey_item_name').val('');
                            $('#i-survey_item_qty').val('');
                            $('#i-survey_item_unit').val('');
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


        function loadHasilSurvey(id_survey, divisi = 'teknik') {

            return $.ajax({
                url: "<?php echo base_url('/api/survey/item/load') ?>",
                data: {
                    filters: [
                        {
                            key: 'id_survey',
                            value: id_survey
                        },
                        { 
                            key: 'survey_divisi',
                            value: divisi,
                        }
                    ]
                }
            })

        }

        function deleteHasilSurvey(id_survey_item) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('api/survey/item/delete') ?>/" + id_survey_item
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
                    
                    createSurvey(btn.data('permintaan'))
                    .then(response => {

                        Toast('success', 'Generated');
                        $('#i-id_survey').val(response.data.id_survey);
                        $('#form-modal').modal('show');

                        loadData();

                    });
                    

                    break;

                case 'load-hasil-survey':
                    
                    $('#i-id_survey').val(btn.data('survey'));
                    $('#i-id_permintaan').val(btn.data('permintaan'));

                    getData(btn.data('survey')).then(() => {
                        
                        loadHasilSurvey(btn.data('survey'))
                        .then(response => {

                            console.log(response)

                            let tbody = $('#js-add-new-item')
                                    .parent()
                                    .parent()
                                    .parent()
                                    .parent()
                                    .prev();
                            
                            tbody.html('');

                            let html = ``;
                            response.data.lists.map((v, i) => {
                                html += `
                                    <tr>
                                        <th>
                                            <input name="items[name][${v.id_survey_item}]" type="text" class="form-control" placeholder="Nama item" value="${v.survey_item_name}" readonly>
                                        </th>
                                        <th>
                                            <input name="items[qty][${v.id_survey_item}]" type="text" class="form-control" placeholder="Jumlah" value="${v.survey_item_qty}" readonly>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <input name="item[unit][${v.id_survey_item}]" type="text" class="form-control mr-2" placeholder="Unit" value="${v.survey_item_unit}" readonly>
                                                <a href="javascript:void(0)" data-item="${v.id_survey_item}" class="btn btn-danger js-remove-item"><span class="fas fa-minus"></span></a>
                                            </div>
                                        </th>
                                    </tr>
                                `;

                                
                            })

                            btn.html('Lihat Hasil Survey')

                            tbody.append(html);
                            
                            $('#form-modal').modal('show');
                        });

                    })
                    

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

            addHasilSurvey();
                
        });

        $(document).on('click', '.js-remove-item', function(e){
            e.preventDefault();

            let btn = $(this);

            deleteHasilSurvey(btn.data('item'))
            .then(response => {

                btn.closest('tr').remove();

                Toast('success', 'Berhasil Menghapus Item')
                
            });
        
        })

    })
</script>

<?php $this->endSection(); ?>