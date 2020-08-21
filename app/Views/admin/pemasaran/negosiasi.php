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
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-estimasi" class="btn btn-primary mb-3">Tambah Data</a>
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
    <div class="modal fade" id="modal-estimasi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Negosiasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <form action="" id="form-estimasi">
                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_nego" id="i-id_nego">
                        <input type="hidden" name="_method" value="POST">
                        
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4" >
                                <label for="i-id_permintaan">Permintaan</label>
                                <select name="id_permintaan" id="i-id_permintaan" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label for="i-nego_pic_nama">Negosiator</label>
                                <input type="text" name="nego_pic_nama" id="i-nego_pic_nama" class="form-control">
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label for="i-nego_pic_jabatan">Jabatan</label>
                                <input type="text" name="nego_pic_jabatan" id="i-nego_pic_jabatan" class="form-control">
                            </div>
                        </div>

                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" valign="middle" class="text-center align-middle" width="40">
                                            <span>No</span>
                                        </th>
                                        <th rowspan="2" class="text-center align-middle">Item</th>
                                        <th rowspan="2" class="text-center align-middle">Qty</th>
                                        <th colspan="2" class="text-center">Harga Jual</th>
                                        <th width="10" rowspan="2" class="border-top-0 border-right-0 border-bottom-0"></th>
                                        <th colspan="2" class="text-center">Harga Nego</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="120">Harga</th>
                                        <th class="text-center" width="120">Total</th>
                                        <th class="text-center" width="120">Harga</th>
                                        <th class="text-center" width="120">Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>


                        <div class="form-group">
                            <label for="i-nego_term">Kondisi Negosiasi</label>
                            <textarea name="nego_term" id="i-nego_term" rows="10" class="form-control"></textarea>
                        </div>


                        <button class="btn btn-primary" id="js-save-estimasi">Simpan Negosiasi</button>
                        
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <!-- /BOQ Modal -->


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
                url: "<?php echo base_url('/api/negosiasi') ?>",
                data: data,
                success: function(response) {

                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        
                        html += `
                        
                            <tr>
                                <td>
                                    <ul>
                                        <li><a href="${baseUrl}/dashboard/laporan/lampiran-penawaran?id_penawaran=${v.id_penawaran}" target="_blank">${v.penawaran_no}</a></li>
                                        <li>Harga Jual: <a href="${baseUrl}/dashboard/laporan/estimasi/?id_permintaan=${v.id_permintaan}" target="_blank">${Rp(v.estimasi_harga_jual)}</a></li>
                                        <li>Harga Nego: <a href="${baseUrl}/dashboard/laporan/nego/?id_permintaan=${v.id_permintaan}" target="_blank">${Rp(v.estimasi_harga_nego)}</a></li>
                                    </ul>
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
                                <td>${v.nego_term}</td>
                                <td>

                                    <a href="javascript:void(0)" class="btn btn-warning mb-2" title="Edit Negosiasi" data-toggle="table-action" data-action="edit" data-id="${v.id_nego}" data-permintaan="${v.id_permintaan}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    
                                    <a href="javascript:void(0)" class="btn btn-danger mb-2" title="Hapus Negosiasi" data-toggle="table-action"  data-action="delete" data-id="${v.id_nego}">
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
            console.log('getCustomers');
            let html = '<option value="">Pilih</option>';

            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_permintaan}">${v.nama_pekerjaan}</option>`;
            })

            $('#i-id_permintaan').html(html);

        }).catch(err => {
            console.log(err);
        });


        function getPermintaan() {

            return $.ajax({
                url: "<?php echo base_url('/api/permintaan?page_group1=-1') ?>",
                data: {
                    filters: [
                        {
                            key: 'permintaan_status',
                            value: 'Publish'
                        }
                    ]
                }
            })

        }

        function addData() {

            let formEstimasi = $('#form-estimasi');
            let data = {
                id_permintaan: $('#i-id_permintaan').val(),
                nego_term: tinyMCE.activeEditor.getContent(),
                nego_pic_nama: $('#i-nego_pic_nama').val(),
                nego_pic_jabatan: $('#i-nego_pic_jabatan').val()
            }

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/negosiasi`,
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
                url: "<?php echo base_url('/api/negosiasi/update') ?>",
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
                url: `${baseUrl}/api/negosiasi/show/${id}`,
                success: function(response) {

                    truthAction.val('update');

                    for(data in response.data) {
                        $('#i-' + data).val(response.data[data]);
                    }
                    
                    $('#estimasi-modal').modal('show');
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/negosiasi/${id}/delete`,
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
            $('#form-estimasi')[0].reset();
            $('#form-estimasi').find('tbody').html('');
        }



        $(document).on('click', '#pagination-wrapper .page-item', function(e){
            e.preventDefault();

            let pagination = $(this).data('ci-pagination');

            console.log('ci-pagination', pagination);

            loadData({
                page_group1: pagination
            })
        
        })

        function loadHasilPermintaan( id_permintaan, divisi = 'teknik' ) {


            return $.ajax({
                url: "<?php echo base_url('/api/permintaan-item') ?>",
                data: {
                    
                    filters: [
                        { 
                            key: 'id_permintaan',
                            value: id_permintaan
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
            let tbody ;


            switch(action) {    
                case 'edit':
                
                    getData(btn.data('id'))
                    .then((response) => {
                    
                        btn.html(`<span class="fas fa-edit"></span>`)
                        return response;

                    })
                    .then((data) => {
                        
                        console.log('get data pic', data);

                        getPic(data.data.id_customer)
                        .then(response => {
                            console.log(data.id_customer);
                            
                            console.log('get pic', response);

                            let options = `<option value=''>Pilih</option>`;

                            response.data.lists.map((v, i) => {
                                console.log(v);
                                options += `<option value="${v.id_pic}" ${data.data.id_pic == v.id_pic ? "selected" : ""}>${v.nama_pic} (${v.jabatan_pic}) - ${v.divisi_pic}</option>`;

                            })

                            $('#i-id_pic').html(options);
                        });
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
                
        

                case 'estimasi-harga':

                    
                    tbody = $('#modal-estimasi').find('tbody');
                    
                    tbody.html('');

                    let btnInnerHTML = btn.html();

                    loadHasilPermintaan($(this).data('permintaan'))
                    .then(response => {

                        console.log('load items');

                        let html = "";
                        let no = 0;


                        response.data.lists.map((v, i) => {

                            v.item_hp = parseFloat(v.item_hp);
                            v.item_hj = parseFloat(v.item_hj);

                            let total_harga_pokok   = parseFloat(v.item_hp) * parseFloat(v.item_qty);     
                            let total_harga_jual    = parseFloat(v.item_hj) * parseFloat(v.item_qty);     

                            
                            let hargaPokokInput = `

                                <input 
                                    name="item_hp[${v.id_item}]"
                                    class="form-control js-bind-harga-pokok" 
                                    id="js-bind-harga-pokok-${v.id_item}"
                                    data-id="${v.id_item}"
                                    data-target="#total-harga-pokok-${v.id_item}" 
                                    data-qty="${v.item_qty}" value="${v.item_hp}"
                                    data-margin="margin-${v.id_item}"
                                    style="max-width: 150px">

                            `;

                            let hargaPokokJual = `

                                <input
                                    name="item_hj[${v.id_item}]"
                                    class="form-control js-bind-harga-jual"  
                                    id="js-bind-harga-jual-${v.id_item}"
                                    data-id="${v.id_item}"
                                    data-target="#total-harga-jual-${v.id_item}" 
                                    data-qty="${v.item_qty}" value="${v.item_hj}"
                                    data-margin="margin-${v.id_item}"
                                    style="max-width: 150px">

                            `;


                            let marginHarga = InternalCalculation.getPersentaseMargin(v.item_hp, v.item_hj).toFixed(2)
                            let selisihHarga = selisihHasil(v.item_hp, v.item_hj);

                            let marginHTML = `
            
                                <div class="d-flex justify-content-between">
                                    <span>${Rp(selisihHarga).toString()}</span>
                                    <span>${marginHarga.toString()}%</span>
                                </div>

                            `


                            html += `

                                <tr>
                                    <td>${++no}</td>
                                    <td width="300">${v.item_name}</td>
                                    <td width="80">${v.item_qty} ${v.item_unit}</td>
                                    <td>${hargaPokokInput}</td>
                                    <td class="text-right" id="total-harga-pokok-${v.id_item}">${Rp(total_harga_pokok)}</td>
                                    <td class="border-0" style="background-color: transparent;"></td>
                                    <td>${hargaPokokJual}</td>
                                    <td class="text-right" id="total-harga-jual-${v.id_item}">${Rp(total_harga_jual)}</td>
                                    <td id="margin-${v.id_item}">${marginHTML}</td>
                                </tr>

                            `

                        })

                        tbody.html(html);
                        $('#modal-estimasi').modal('show');
                    
                        btn.html(btnInnerHTML);
                    });
                    
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


        $('.js-add-item').click(function(e){
            e.preventDefault();
            addHasilSurvey()

        });

        $(document).on('click', '.js-remove-item', function(e){

            let btn = $(this);
            let parent = btn.closest('tr');

            deleteHasilSurvey(btn.data('item'))
            .then(response => {

                Toast('success', 'Data berhasil dihapus');
                parent.remove();

            })



        });


        $(document).on('click', '.js-update-item', function(e){
            e.preventDefault();

            let parent = $(this).closest('tr');

            let idSurvey = $('#i-id_survey').val();
            let idSurveyItem = $(this).data('item');
            let inputs = parent.find('input')

            console.log({ 
                id_survey_item: idSurveyItem
            });

            let data = {
                id_survey_item: idSurveyItem,
                id_survey: idSurvey,
                survey_item_name: $(inputs[0]).val(),
                survey_item_qty: parseFloat($(inputs[1]).val()),
                survey_item_unit: $(inputs[2]).val(),
                survey_harga_pokok: parseFloat($(inputs[3]).val()),
                survey_harga_jual: parseFloat($(inputs[4]).val()),
                survey_divisi: $('#i-survey_divisi').val()
            }

            updateHasilSurvey(data);
        });

      

        function updateHasilSurvey(data) {
            
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/survey/item/update') ?>",
                data: data, 
                success: function(response) {

                    console.log('success response update item', response);
                    
                    switch(response.code) {

                        case 200: 

                            Toast('success', 'Berhasil memperbaharui data');

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

        function deleteHasilSurvey(id_survey_item) {
            return $.ajax({
                method: 'POST',
                url: "<?php echo base_url('api/survey/item/delete') ?>/" + id_survey_item
            })
        }


        // Load Hasil Survey
        function loadHasilSurvey( id_permintaan, divisi = 'teknik' ) {

            return $.ajax({
                url: "<?php echo base_url('/api/survey/item/load') ?>",
                data: {
                    
                    filters: [
                        { 
                            key: 'id_permintaan',
                            value: id_permintaan
                        },
                        {
                            key: 'survey_divisi',
                            value: divisi
                        } 
                    ]
                }
            })

        }


        $(document).on('change keyup', '.js-bind-harga-pokok', function(){

            let id          = $(this).data('id');
            let target      = $($(this).data('target'));
            let qty         = parseFloat($(this).data('qty'));
            let value       = parseFloat($(this).val());
            let hargaJual   = $('#js-bind-harga-jual-' + id).val()

            target.html(Rp(qty * value));

            console.log("margin", $('#margin-' + id));
            
            let marginHarga = InternalCalculation.getPersentaseMargin(value, hargaJual).toFixed(2)
            let selisihHarga = selisihHasil(value, hargaJual);

            let marginHTML = `
            
            <div class="d-flex justify-content-between">
                <span>${Rp(selisihHarga).toString()}</span>
                <span>${marginHarga.toString()}%</span>
            </div>

            `;

            $('#margin-' + id).html( marginHTML );


        })

        $(document).on('change keyup', '.js-bind-harga-jual', function(){

            let id          = $(this).data('id');
            let target      = $($(this).data('target'));
            let qty         = parseFloat($(this).data('qty'));
            let value       = parseFloat($(this).val());
            let hargaPokok  = $('#js-bind-harga-pokok-' + id).val()

            target.html(Rp(qty * value));

            $('#js-total-harga-nego').html(Rp(bindTotalNego()));

        })

        function bindTotalNego() {
            let currentTotal = $('#js-total-harga-nego').val();
            let inputs = $('.js-bind-harga-jual');

            let grandTotalNego = 0;
            inputs.map((i, v) => {
                let qty = $(v).data('qty');
                grandTotalNego += parseInt($(v).val() * qty);
            })

            return grandTotalNego;
        }


        function updateItem(data) {

            console.log('update item data', data)

            return $.ajax({
                method: 'POST',
                data: data,
                url: `${baseUrl}/api/negosiasi/harga`
            })
        }

        $('#js-save-estimasi').click(function(e){
            e.preventDefault();

            saveData();

            console.log('serialize', $('#form-estimasi').find('.js-bind-harga-jual'));

            let formEstimasi = $('#form-estimasi');
            let inputs = formEstimasi.find('.js-bind-harga-jual');

            let progress = 0;
            
            inputs.map((i, el) => {
                console.log(el);
                let id = $(el).data('id');
                let item_hj = $(el).val()

                updateItem({
                    id_item: id,
                    item_hj_nego: item_hj
                })
                .then((response) => {
                    console.log(response)
                    progress += 1;
                    console.log('progress', progress, inputs.length);
                    if(progress == inputs.length) {
                        Toast('success', (progress) + ' item telah disimpan');
                        loadData();
                    }
                })

                

            })



        })



        $('#i-id_permintaan').change(function(e){
            e.preventDefault();

            loadHasilPermintaan($(this).val())
            .then(response => {

                console.log('load items');
                let tbody = $('#modal-estimasi').find('tbody');
                let html = "";
                let no = 0;

                
                let grandtotal_harga_jual   = 0;
                let grandtotal_harga_nego   = 0;

                response.data.lists.map((v, i) => {

                    v.item_hp = parseFloat(v.item_hp);
                    v.item_hj = parseFloat(v.item_hj);
                    let total_harga_jual        = parseFloat(v.item_hj) * parseFloat(v.item_qty);     
                    let total_harga_nego        = parseFloat(v.item_hj_nego) * parseFloat(v.item_qty);     

                    grandtotal_harga_jual += total_harga_jual;
                    grandtotal_harga_nego += total_harga_nego

           

                    let hargaNegoInput = `

                        <input
                            name="item_hj[${v.id_item}]"
                            class="form-control js-bind-harga-jual"  
                            id="js-bind-harga-jual-${v.id_item}"
                            data-id="${v.id_item}"
                            data-target="#total-harga-jual-${v.id_item}" 
                            data-qty="${v.item_qty}" value="${v.item_hj_nego}"
                            data-margin="margin-${v.id_item}"
                            style="max-width: 150px">

                    `;


                    html += `

                        <tr>
                            <td class="text-center">${++no}</td>
                            <td width="300">${v.item_name}</td>
                            <td width="80">${v.item_qty} ${v.item_unit}</td>
                            <td class="text-right">${Rp(v.item_hj)}</td>
                            <td class="text-right" id="total-harga-pokok-${v.id_item}">${Rp(total_harga_jual)}</td>
                            <td class="border-0" style="background-color: transparent;"></td>
                            <td>${hargaNegoInput}</td>
                            <td class="text-right" id="total-harga-jual-${v.id_item}">${Rp(total_harga_nego)}</td>
                        </tr>

                    `

                })

                html += `

                    <tr>
                        <td colspan="4"></td>
                        <td class="text-right" id="js-total-harga-jual">${Rp(grandtotal_harga_jual)}</td>
                        <td class="border-0" style="background-color: transparent;"></td>
                        <td></td>
                        <td class="text-right" id="js-total-harga-nego">${Rp(grandtotal_harga_nego)}</td>
                    </tr>

                `

                tbody.html(html);
                $('#modal-estimasi').modal('show');
        
            });
        })



 
 

    })
</script>

<?php $this->endSection(); ?>   