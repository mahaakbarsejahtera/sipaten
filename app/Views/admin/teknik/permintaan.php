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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
    
                <div class="modal-body">
                    <form action="" id="form">

                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_permintaan" id="i-id_permintaan">
                        <input type="hidden" name="_method" value="POST">
    
                        <div class="form-group">
                            <label for="i-permintaan_supervisi">Sales</label>
                            <select name="permintaan_supervisi" id="i-permintaan_supervisi" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary js-save-penunjukan" data-status="Accept">Accept</button>
                            <button class="btn btn-warning js-save-penunjukan" data-status="Draft">Draft</button>
                        </div>

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
                        
                        let penunjukanHtml = "";
                        let statusPenunjukanSupervisiHTML = "";
                        
                        if(escStr(v.permintaan_supervisi) == '0') penunjukanHtml = `<a href="javascript:void(0)" class="js-penunjukan" data-permintaan="${v.id_permintaan}">Pilih</a>`;
                        else penunjukanHtml = `<a href="javascript:void(0)" class="js-penunjukan" data-permintaan="${v.id_permintaan}" data-supervisi="${v.permintaan_supervisi}">${v.nama_supervisi}</a>`

                        if(v.permintaan_supervisi_status == "Draft") statusPenunjukanSupervisiHTML = `<span class="badge badge-warning">${v.permintaan_supervisi_status}</span>`;
                        if(v.permintaan_supervisi_status == "Accept") statusPenunjukanSupervisiHTML = `<span class="badge badge-success">${v.permintaan_supervisi_status}</span>`;

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
                                <td>${penunjukanHtml}</td>
                                <td>${statusPenunjukanSupervisiHTML}</td>
           
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
                
                case 'loadPemasaranBoq':
                case 'loadTeknikBoq':

                    let divisi = "teknik";
                    if(action == 'loadPemasaranBoq') 
                    { 
                        divisi = "pemasaran";
                        $('#i-survey_divisi').val('pemasaran');
                    }

                    if(action == 'loadTeknikBoq') $('#i-survey_divisi').val('teknik');


                    $('#modal-boq').modal('show');
                   
                    $('#i-id_survey').val(btn.data('survey'));
                    $('#form-boq').find('tbody').html('');

                    loadHasilSurvey(btn.data('survey'), divisi)
                    .then(response => {


                        let html = '';

                        response.data.lists.map((v, i) => {
                            let getMarin = InternalCalculation.getPersentaseMargin(v.survey_harga_pokok, v.survey_harga_jual).toFixed(2);
                            let getMarginHTML = getMarin > 0 ? `<span class="text-success">${getMarin}%</span>` : `<span class="text-danger">${getMarin}%</span>`;
                            html += `
                                <tr>
                                    <td>
                                        <input name="items[name][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukann Nama item" value="${v.survey_item_name}">
                                    </td>
                                    <td width="100">
                                        <input name="items[qty][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukan Qty" value="${v.survey_item_qty}">
                                    </td>
                                    <td width="100">
                                        <input name="items[unit][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukan Unit" value="${v.survey_item_unit}">
                                    </td>
                                    <td>
                                        <input 
                                            name="items[harga_pokok][${v.id_survey_item}]"
                                            type="number" 
                                            class="form-control form-control-sm" 
                                            placeholder="Masukan Harga Pokok" 
                                            value="${v.survey_harga_pokok}"
                                            data-toggle="get-margin"  
                                            data-action="harga-pokok"
                                            data-bind="#js-harga-jual-${v.id_survey_item}"
                                            data-target="#js-margin-${v.id_survey_item}"
                                            id="js-harga-pokok-${v.id_survey_item}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input 
                                                name="item[harga_jual][${v.id_survey_item}]" 
                                                type="number" class="form-control form-control-sm" 
                                                placeholder="Masukan Harga Jual" 
                                                value="${v.survey_harga_jual}"
                                                data-toggle="get-margin" 
                                                data-action="harga-jual"
                                                data-bind="#js-harga-pokok-${v.id_survey_item}"
                                                data-target="#js-margin-${v.id_survey_item}"
                                                id="js-harga-jual-${v.id_survey_item}">
                                                                                        
                                        </div>
                                    </td>
                                    <td>${v.survey_item_qty * v.survey_harga_jual}</td>
                                    <td id="js-margin-${v.id_survey_item}">${getMarginHTML}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-item="${v.id_survey_item}" class="btn btn-danger js-remove-item"><span class="fas fa-minus"></span></a>
                                        <a href="javascript:void(0)" data-item="${v.id_survey_item}" class="btn btn-warning js-update-item"><span class="fas fa-pen"></span></a>
                                    </td>
                                </tr>
                            `;

                            
                        })

                        $('#form-boq').find('tbody').html(html);

                        btn.html((action == 'loadPemasaranBoq') ? "Pemasaran" : "Teknik")

                    })
                    break;

                
                    /**
                    $('#modal-boq').modal('show');
                    $('#i-survey_divisi').val('pemasaran');
                    $('#i-id_survey').val(btn.data('survey'));
                    $('#form-boq').find('tbody').html('');

                    loadHasilSurvey(btn.data('survey'), 'pemasaran')
                    .then(response => {

                        console.log('load pemasaran boq', response)

                        let html = '';

                        response.data.lists.map((v, i) => {

                            let getMarin = InternalCalculation.getPersentaseMargin(v.survey_harga_pokok, v.survey_harga_jual).toFixed(2);
                            let getMarginHTML = getMarin > 0 ? `<span class="text-success">${getMarin}%</span>` : `<span class="text-danger">${getMarin}%</span>`;

                            html += `
                                <tr>
                                    <th>
                                        <input name="items[name][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukann Nama item" value="${v.survey_item_name}">
                                    </th>
                                    <th width="100">
                                        <input name="items[qty][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukan Qty" value="${v.survey_item_qty}">
                                    </th>
                                    <th width="100">
                                        <input name="items[unit][${v.id_survey_item}]" type="text" class="form-control form-control-sm" placeholder="Masukan Unit" value="${v.survey_item_unit}">
                                    </th>
                                    <th>
                                        <input 
                                            name="items[harga_pokok][${v.id_survey_item}]"
                                            type="number" 
                                            class="form-control form-control-sm" 
                                            placeholder="Masukan Harga Pokok" 
                                            value="${v.survey_harga_pokok}"
                                            data-toggle="get-margin"  
                                            data-action="harga-pokok"
                                            data-bind="#js-harga-jual-${v.id_survey_item}"
                                            data-target="#js-margin-${v.id_survey_item}"
                                            id="js-harga-pokok-${v.id_survey_item}">
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <input 
                                                name="item[harga_jual][${v.id_survey_item}]" 
                                                type="number" class="form-control form-control-sm" 
                                                placeholder="Masukan Harga Jual" 
                                                value="${v.survey_harga_jual}"
                                                data-toggle="get-margin" 
                                                data-action="harga-jual"
                                                data-bind="#js-harga-pokok-${v.id_survey_item}"
                                                data-target="#js-margin-${v.id_survey_item}"
                                                id="js-harga-jual-${v.id_survey_item}">
                                                                                        
                                        </div>
                                    </th>
                                    <td>${v.survey_item_qty * v.survey_harga_jual}</td>
                                    <td id="js-margin-${v.id_survey_item}">${getMarginHTML}</td>
                                    <th>
                                        <a href="javascript:void(0)" data-item="${v.id_survey_item}" class="btn btn-danger js-remove-item"><span class="fas fa-minus"></span></a>
                                        <a href="javascript:void(0)" data-item="${v.id_survey_item}" class="btn btn-warning js-update-item"><span class="fas fa-pen"></span></a>
                                    </th>
                                </tr>
                            `;

                            
                        })

                        $('#form-boq').find('tbody').html(html);

                        btn.html('Pemasaran')

                    })
                    break;
                     */

                case 'create-timeline': 
                    
                    break;

                case 'create-budget':
                    $('#modal-anggaran').modal('show');
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

        function savePenunjukan(id_permintaan, permintaan_supervisi, permintaan_supervisi_status) {

        

            return $.ajax({
                method: 'POST',
                url: `<?php echo base_url('api/permintaan/penunjukan') ?>/${id_permintaan}`,
                data: {
                    permintaan_supervisi: permintaan_supervisi,
                    permintaan_supervisi_status: permintaan_supervisi_status
                }
            })
            
        }   

        $('.js-save-penunjukan').click(function(e){
            e.preventDefault();

            let status = $(this).data('status');
            let id_permintaan = $('#i-id_permintaan').val();
            let permintaan_supervisi = $('#i-permintaan_supervisi').val();

            savePenunjukan(id_permintaan, permintaan_supervisi, status)
            .then(response => {
                $('#form-modal').modal('hide');
                $('#form-modal').find('form')[0].reset();
                loadData();
            })

        })


    })
</script>

<?php $this->endSection(); ?>