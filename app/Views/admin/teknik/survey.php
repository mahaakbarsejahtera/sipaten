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
                            <label for="i-permintaan_supervisi">Superivisi</label>
                            <select name="permintaan_supervisi" id="i-permintaan_supervisi" class="form-control" style="max-width: 300px">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
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
                                                <input id="i-survey_item_unit" type="text" class="form-control mr-2" placeholder="Satuan">
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0)" id="js-add-new-item" class="btn btn-primary"><span class="fas fa-plus"></span></a>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <button class="btn btn-warning js-save" data-status="Draft">Draft</button>
                        <button class="btn btn-primary js-save" data-status="Accept">Accept</button>

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

                    // `<td><a href="javascript:void(0)" data-toggle="table-action" data-action="create-timeline" data-id="${v.id_permintaan}">Buat Timeline</a></td><td><a href="">Berkas</a></td>`
                    response.data.lists.map((v, i) => {
                        
                        let hasilSurveyHTML = "";
                        let statusHasilSurveyHTML = "";

                        hasilSurveyHTML = `
                                <a href="javascript:void(0)" 
                                    class="js-lihat-hasil-survey" 
                                    data-permintaan="${v.id_permintaan}" 
                                    data-survey="${v.id_survey}"
                                    data-supervisi="${v.permintaan_supervisi}">
                                    <span>Lihat</span>
                                </a>`;
                        

                        if(v.permintaan_hasil_survey_status == "Draft") statusHasilSurveyHTML = `<span class="badge badge-warning">${v.permintaan_hasil_survey_status}</span>`;
                        if(v.permintaan_hasil_survey_status == "Accept") statusHasilSurveyHTML = `<span class="badge badge-success">${v.permintaan_hasil_survey_status}</span>`;

                        html += `
                        
                            <tr>
                                <td>
                                    <div>${v.nama_pekerjaan}</div>
                                </td>
                                <td>${v.nama_customer}</td>
                                <td>${v.permintaan_lokasi_survey}</td>
                                <td>${v.permintaan_jadwal_survey}</td>
                                <td>${v.keterangan_pekerjaan}</td>
                                
                                <td>${v.user_fullname}</td>
                                <td>${hasilSurveyHTML}</td>
                                <td>${statusHasilSurveyHTML}</td>
           
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

            console.log(response)

            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_user}">${v.user_fullname}</option>`;
            })

            $('#i-permintaan_supervisi').html(html);

        }).catch(err => {
            console.log(err)
        });

        function getUsers() {

            return $.ajax({
                url: "<?php echo base_url('/api/users?page_group1=-1') ?>",
                data: {
                    filters: [
                        { key: 'user_role', value: 16 }
                    ]
                }
            })

        }

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


        $(document).on('click', '.js-penunjukan', function(e){
            e.preventDefault();
            console.log('click');
            $('#i-permintaan_supervisi').val($(this).data('supervisi'))
            $('#i-id_permintaan').val($(this).data('permintaan'));
            $('#form-modal').modal('show');

        })


        function loadHasilSurvey(id_permintaan, divisi = 'teknik') {

            return $.ajax({
                url: "<?php echo base_url('/api/permintaan-item') ?>",
                data: {
                    per_group1: -1,
                    filters: [
                        {
                            key: 'id_permintaan',
                            value: id_permintaan
                        },
                        { 
                            key: 'survey_divisi',
                            value: divisi,
                        }
                    ]
                }
            })

        }


                    
        $(document).on('click', '.js-lihat-hasil-survey',  function(e){
            let btn = $(this);

            $('#i-permintaan_supervisi').val(btn.data('supervisi'));
            $('#i-id_permintaan').val(btn.data('permintaan'));

            loadHasilSurvey(btn.data('id_permintaan'))
            .then(response => {

                console.log('lihat hasil survey', response)

                let tbody = $('#js-add-new-item')
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .prev();
                
                tbody.html('');

                let html = ``;
                response.data.lists.map((v, i) => {
                    html += createRowHasilSurvey(v.id_item, v.item_name, v.item_qty, v.item_unit);
  
                })

                btn.html('Lihat')

                tbody.append(html);
                
                $('#form-modal').modal('show');
            });
            
        })


        function addNewItem( data = {} ) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/permintaan-item/add'); ?>", 
                data: data
            })
        }

        function deleteItem(id) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/permintaan-item/'); ?>/" + id + '/delete', 
            })
        }


        $(document).on('click', '#js-add-new-item', function(e){
        
            let name = $('#i-survey_item_name').val();
            let qty = $('#i-survey_item_qty').val();
            let unit = $('#i-survey_item_unit').val()
            let id_permintaan = $('#i-id_permintaan').val();
            
            console.log('id_permintaan', id_permintaan)

            addNewItem({
                id_permintaan: id_permintaan,
                item_name: name,
                item_qty: qty,
                item_unit: unit
            })
            .then(response => {
                console.log(response);
                Toast('success', 'Berhasil menambahkan')

                let tbody = $('#js-add-new-item')
                        .parent()
                        .parent()
                        .parent()
                        .parent()
                        .prev();
                
                tbody.append(
                    createRowHasilSurvey(
                        response.data.id, 
                        response.data.item_name, 
                        response.data.item_qty, 
                        response.data.item_unit
                    )
                );

                $('#i-survey_item_name').val('');
                $('#i-survey_item_qty').val('');
                $('#i-survey_item_unit').val('');
            })

        });

        $(document).on('click', '.js-remove-item', function(e){

            let btn = $(this);

            deleteItem(btn.data('item'))
            .then(response => {
                btn
                    .parent()
                    .parent()
                    .remove();
            })
        })

        function savePermintaan(id, data = {}) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/permintaan/hasil-survey') ?>/" + id ,
                data: data
            })
        }



        $('.js-save').click(function(e){
            e.preventDefault();
            let status = $(this).data('status');
            let id_permintaan =  $('#i-id_permintaan').val();

            let data = {
                permintaan_hasil_survey_status: status,
                permintaan_supervisi: $('#i-permintaan_supervisi').val()
            };
            
            savePermintaan(id_permintaan, data)  
            .then(response => {
                console.log('save permintaan', response);
                Toast('success', 'Berhasil menyimpan data');
                $('#form-modal').modal('hide');

                loadData()

            })

        })


    })
</script>

<?php $this->endSection(); ?>