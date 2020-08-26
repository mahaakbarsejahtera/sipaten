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
        <div class="modal-dialog modal-xl" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form">

                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_permintaan" id="i-id_permintaan">
                        <input type="hidden" name="id_anggaran" id="i-id_anggaran">
                        <input type="hidden" name="jenis_anggaran" id="i-jenis_anggaran">
                        <input type="hidden" name="_method" value="POST">
                        
                        <?php 
                        
                        $subs = [
                            'boq' => 'BOQ',
                            'teknik' => 'TEKNIK', 
                            'pemasaran' => 'PEMASARAN',
                            'keuangan' => 'KEUANGAN',
                            'proyek' => 'JASA PROYEK'
                        ]; 
                        
                        ?>

                        <?php foreach($subs as $key => $value) : ?>
                            <div class="card text-left">
                                <div class="card-header">
                                    <div class="cart-title"><?php echo $value; ?></div>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-sm table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Unit</th>
                                                    <th class="text-center">Harga</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                        
                                            </thead>
                                            <tbody id="js-<?php echo $key ?>-tbody"></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="text" id="js-<?php echo $key ?>-item-name" value="" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" id="js-<?php echo $key ?>-item-qty" value="" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" id="js-<?php echo $key ?>-item-unit" value="" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" id="js-<?php echo $key ?>-item-price" value="" class="form-control">
                                                    </td>
                                                    <td class="text-left">
                                                        <button class="btn btn-primary" id="js-add-<?php echo $key ?>-item">
                                                            <span class="fas fa-plus"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


<!-- 
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary js-save-penunjukan" data-status="Accept">Accept</button>
                            <button class="btn btn-warning js-save-penunjukan" data-status="Draft">Draft</button>
                        </div> -->

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

        loadData()

        function loadData(data = {}) {
            
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="7">Loading...</td>
                </tr>
            `);

            return $.ajax({
                url: "<?php echo base_url('/api/permintaan') ?>",
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    // `<td><a href="javascript:void(0)" data-toggle="table-action" data-action="create-timeline" data-id="${v.id_permintaan}">Buat Timeline</a></td><td><a href="">Berkas</a></td>`
                    response.data.lists.map((v, i) => {

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
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0)" data-permintaan="${v.id_permintaan}" data-anggaran="${escStr(v.id_anggaran)}" class="js-load-anggaran">Lihat Anggaran</a>
                                        <a href="${baseUrl}/dashboard/laporan/anggaran?id_anggaran=${v.id_anggaran}" target="_blank">Download</a>
                                    </div>
                                </td>
           
                            </tr>
                        
                        `
                    })

                    tableData.find('tbody').html(html);
                    $('#pagination-wrapper').html(response.data.pagination);
                }
            })

        }

     

        $(document).on('click', '#pagination-wrapper .page-item', function(e){
            e.preventDefault();

            let pagination = $(this).data('ci-pagination');

            console.log('ci-pagination', pagination);

            loadData({
                page_group1: pagination,
            })
        
        })

        function loadHasilSurvey( id_survey, divisi = 'teknik' ) {

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
                            value: divisi
                        } 
                    ]
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

            let filters = getFilters();
            //filters.push({ key: 'permintaan_status', value: 'kontrak' });

            loadData({
                page_group1: currentPagination,
                orders: [{
                    orderby: orderby,
                    order: order,
                    
                }],
                filters: filters
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
                    { key: 'search', value: $(this).val() },
                    
                ]
            })
        })


        $(document).on('click', '.js-load-anggaran', function(e){
            e.preventDefault();


            let btn         = $(this);
            let permintaan  = btn.data('permintaan');
            let anggaran    = btn.data('anggaran');

            
            $('#js-boq-tbody').html('');
            $('#js-teknik-tbody').html('');
            $('#js-pemasaran-tbody').html('');
            $('#js-keuangan-tbody').html('');
            $('#js-proyek-tbody').html('');

        
            if(anggaran == "") {
                createAnggaran(permintaan)
                .then(response => {

                    console.log('create anggaran', response);
                    
                    loadData()

                    $('#i-id_angaran').val(response.data.id_anggaran);

                    $('#form-modal').modal('show');

                })
            }
            else if(parseInt(anggaran) > 0) {
                let data = {
                    filters: [{
                        key:  'id_anggaran',
                        value: anggaran,
                    }]
                }

                $('#i-id_anggaran').val(anggaran);

                loadAnggaranItems(data)
                .then(response => {

                    console.log('load anggaran', response);
                    response.data.lists.map((v,i) => {
                        $('#js-' +  v.jenis_anggaran + '-tbody').append(createAnggaranRow(v, v.jenis_anggaran));
                    })
                    
                    
                    $('#form-modal').modal('show');
                })
            }

        })

        function createAnggaranRow(data, jenis = "boq") {

            console.log('create anggaran row', data);

            let html = `
                <tr>
                    <td class="text-center" width="200">
                        <input type="text" id="js-${jenis}-item-name-${data.id_anggaran_item}" class="form-control" value="${data.anggaran_item}">
                    </td>
                    <td class="text-center" width="30">
                        <input type="text" id="js-${jenis}-item-qty-${data.id_anggaran_item}" class="form-control" value="${data.anggaran_qty}">
                    </td>
                    <td class="text-center" width="30">
                        <input type="text" id="js-${jenis}-item-unit-${data.id_anggaran_item}" class="form-control" value="${data.anggaran_unit}">
                    </td>
                    <td class="text-center" width="80">
                        <input type="text" id="js-${jenis}-item-price-${data.id_anggaran_item}" class="form-control" value="${data.anggaran_price}">
                    </td>
                    <td class="text-left" width="40">
                        <button class="btn btn-warning js-anggaran-update" id="js-update-${jenis}-item-${data.id_anggaran_item}" 
                            data-id="${data.id_anggaran_item}" data-jenis="${jenis}">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button class="btn btn-danger js-anggaran-delete" id="js-delete-${jenis}-item-${data.id_anggaran_item}" data-id="${data.id_anggaran_item}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
                
            `;

            return html;
        }

        function createAnggaran(id_permintaan) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/anggaran`,
                data: {
                    id_permintaan: id_permintaan
                }
            })
        }

        function loadAnggaranItems(data) {   
            return $.ajax({
                method: 'GET',
                url: `${baseUrl}/api/anggaran-item`,
                data: data
            })

        }

        function addAnggaranItem(data) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/anggaran-item/add`,
                data: data
            })
        }

        function updateAnggaranItem(data) {

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/anggaran-item/update`,
                data: data
            })

        }

        function deleteAnggaranItem(id) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/anggaran-item/${id}/delete`
            }) 
        }

        $(document).on('click', '.js-anggaran-delete', function(e){
            e.preventDefault();

            let btn = $(this);
            let idAnggaranItem = btn.data('id')

            deleteAnggaranItem(idAnggaranItem)
            .then(response => {
                console.log(response);
                Toast('success', 'Berhasil dihapus');
                btn.closest('tr').remove();
            })
        })

        $(document).on('click', '.js-anggaran-update', function(e){
            e.preventDefault();

            let btn             = $(this);
            let idAnggaranItem  = btn.data('id');

            let data = {
                id_anggaran_item: idAnggaranItem,
                id_anggaran: $('#i-id_anggaran').val(),
                anggaran_item: $('#js-boq-item-name-' + idAnggaranItem).val(),
                anggaran_qty: $('#js-boq-item-qty-' + idAnggaranItem).val(),
                anggaran_unit: $('#js-boq-item-unit-' + idAnggaranItem).val(),
                anggaran_price: $('#js-boq-item-price-' + idAnggaranItem).val(),
                jenis_anggaran: btn.data('jenis')
            };

            console.log('updateAnggaranItem', data);

            updateAnggaranItem(data)
            .then(response => {
                console.log(response);
                Toast('success', 'Berhasil memperbaharui');
            })
        });

        let subs = [
            'boq', 'pemasaran', 'keuangan', 'teknik', 'proyek'
        ];

        subs.map(sub => {

            $('#js-add-' + sub + '-item').click(function(e){
                
                e.preventDefault();

                let data = {
                    id_anggaran: $('#i-id_anggaran').val(),
                    anggaran_item: $('#js-' + sub + '-item-name').val(),
                    anggaran_qty: $('#js-' + sub + '-item-qty').val(),
                    anggaran_unit: $('#js-' + sub + '-item-unit').val(),
                    anggaran_price: $('#js-' + sub + '-item-price').val(),
                    jenis_anggaran: sub,
                };

                console.log('add-boq-item', data);


                addAnggaranItem(data)
                .then(function(response){
                    console.log(response);
                    $('#js-' + sub + '-tbody').append(createAnggaranRow(response.data))
                    
                    $('#js-' + sub + '-item-name').val('');
                    $('#js-' + sub + '-item-qty').val('');
                    $('#js-' + sub + '-item-unit').val('');
                    $('#js-' + sub + '-item-price').val('');

                })

            })

        })

        

        // $('#js-add-teknik-item').click(function(e){
            
        //     e.preventDefault();

        //     let data = {
        //         id_anggaran: $('#i-id_anggaran').val(),
        //         anggaran_item: $('#js-teknik-item-name').val(),
        //         anggaran_qty: $('#js-teknik-item-qty').val(),
        //         anggaran_unit: $('#js-teknik-item-unit').val(),
        //         anggaran_price: $('#js-teknik-item-price').val(),
        //         jenis_anggaran: 'teknik',
        //     };

        //     addAnggaranItem(data)
        //     .then(function(response){
        //         console.log(response);
        //         $('#js-teknik-tbody').append(createAnggaranRow(response.data))
        //         $('#js-teknik-item-name').val('');
        //         $('#js-teknik-item-qty').val('');
        //         $('#js-teknik-item-unit').val('');
        //         $('#js-teknik-item-price').val('');

        //     })

        // })



    })
</script>

<?php $this->endSection(); ?>