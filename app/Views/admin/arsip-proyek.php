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
                                <input type="text" class="form-control" placeholder="Search" id="filter-search" v-model="keyword">
                            </div>
                        </div>

                        
                    
                    </form>
                </div>

                <div class="col-12">
                    <div>
                        <?php echo $table; ?>
                    </div>
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
                        <input type="hidden" name="id_permintaan" id="i-id_permintaan">
                        <input type="hidden" name="_method" value="POST">
                        
                        <div class="form-group">
                            <label for="i-id_customer">Customer</label>
                            <select name="id_customer" id="i-id_customer" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-id_pic">Divisi</label>
                            <select name="id_pic" id="i-id_pic" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-permintaan_sales">Sales</label>
                            <select name="permintaan_sales" id="i-permintaan_sales" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-nama_pekerjaan">Nama pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" id="i-nama_pekerjaan">
                        </div>

                        

                        <div class="form-group">
                            <label for="i-permintaan_lokasi_survey">Lokasi Survey</label>
                            <input type="text" name="permintaan_lokasi_survey" class="form-control" id="i-permintaan_lokasi_survey">
                        </div>

                        <div class="form-group">
                            <label for="i-permintaan_jadwal_survey">Jadwal Survey</label>
                            <input type="date" name="permintaan_jadwal_survey" class="form-control" id="i-permintaan_jadwal_survey">
                        </div>

                        <div class="form-group">
                            <label for="i-permintaan_status">Status</label>
                            <select name="permintaan_status" id="i-permintaan_status" class="form-control">
                                <option value="Draft">Draft</option>
                                <option value="Negosiasi">Negosiasi</option>
                                <option value="Publish">Publish</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-keterangan_pekerjaan">Keterangan</label>
                            <textarea name="keterangan_pekerjaan" id="i-keterangan_pekerjaan" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="i-permintaan_nego">Negosiasi</label>
                                <select name="permintaan_nego" id="i-permintaan_nego" class="form-control">
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="i-permintaan_kontrak">Kontrak</label>
                                <select name="permintaan_kontrak" id="i-permintaan_kontrak" class="form-control">
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Permintaan</button>

                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- BOQ Modal -->
    <div class="modal fade" id="modal-boq" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">BOQ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    
                    <form action="" id="form-boq">

                        <!-- <input name="id_survey" type="hidden" id="i-id_survey">
                        <input name="survey_divisi" type="hidden" id="i-survey_divisi"> -->

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th width="80">Qty</th>
                                        <th width="80">Unit</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <input name="items[name]" type="text" class="form-control form-control-sm" placeholder="Masukann Nama item" value="" id="boq-item_name">
                                        </th>
                                        <th>
                                            <input name="items[qty]" type="text" class="form-control form-control-sm" placeholder="Masukan Qty" value="" id="boq-item_qty">
                                        </th>
                                        <th>
                                            <input name="items[unit]" type="text" class="form-control form-control-sm" placeholder="Masukan Unit" value="" id="boq-item_unit">
                                        </th>
                                       
                                        <th>
                                            <a href="javascript:void(0)" class="btn btn-primary" id="js-add-boq"><span class="fas fa-plus"></span></a>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <!-- /BOQ Modal -->

    <!-- BOQ Modal -->
    <div class="modal fade" id="modal-estimasi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estimasi Harga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    
                    <form action="" id="form-estimasi">
                        
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" valign="middle" class="text-center align-middle" width="80">
                                            <span>No</span>
                                        </th>
                                        <th rowspan="2" class="text-center align-middle">Item</th>
                                        <th rowspan="2" class="text-center align-middle">Qty</th>
                                        <th colspan="2" class="text-center">Harga Pokok</th>
                                        <th width="10" rowspan="2" class="border-top-0 border-right-0 border-bottom-0"></th>
                                        <th colspan="2" class="text-center">Harga Jual</th>
                                        <th rowspan="2" class="text-center align-middle" width="150">Margin</th>
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
                        <button class="btn btn-primary" id="js-save-estimasi">Simpan Estimasi</button>
                        
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <!-- /BOQ Modal -->
    
    <!-- Modal -->
    <div class="modal fade" id="modal-doc" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Dokumen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="form-doc" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Pilih Dokumen</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <button class="btn btn-primary" id="js-add-doc">Upload</button>
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
                    <td colspan="12">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/permintaan') ?>",
                data: data,
                success: function(response) {
                    console.log('load data', response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        
                        html += `
                        
                            <tr>
                                <td>
                                    <div>${v.nama_pekerjaan}</div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)"></a>
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    <a href="${baseUrl + '/dashboard/laporan/estimasi/?id_permintaan=' + v.id_permintaan}" download>${Rp(v.estimasi_harga_jual)}</a>
                                </td>
                                <td>

                                    <a href="${baseUrl}/dashboard/laporan/nego/?id_nego=${v.id_nego}" target="_blank">${Rp(v.estimasi_harga_nego)}
                                </td>
                                <td>${v.permintaan_jadwal_survey}</td>
                                <td>${v.keterangan_pekerjaan}</td>
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
                
                case 'hasil-survey':

                    let idPermintaan = $(this).data('permintaan');
                    $('#js-add-boq').data('permintaan', idPermintaan)
                    tbody = $('#form-boq').find('tbody');
                    tbody.html('');

                    hasNegosiasi(idPermintaan)
                    .then((result) => {

                        loadHasilPermintaan(idPermintaan)
                        .then(response => {
                            
                            

                            let html = "";
                            response.data.lists.map((v, i) => {
                                console.log(v);
        
                                
                                html += createRowBoq(v);

                            })
                            

                            tbody.html(html);
                            $('#modal-boq').modal('show');

                            if(result.data.lists.length > 0) {
                                console.log('load items hasil survey');
                                $('#form-boq').find('thead th:last-child').css({ display: 'none' })
                                $('#form-boq').find('tbody tr td:last-child').css({ display: 'none' })
                                $('#form-boq').find('tfoot th:last-child').css({ display: 'none' })
                            } else {
                                $('#form-boq').find('thead th:last-child').attr('style', '');
                                $('#form-boq').find('tbody tr td:last-child').attr('style', '');
                                $('#form-boq').find('tfoot th:last-child').attr('style', '');
                            }
                        
                            btn.html('BOQ');
                        });
                    })

                    

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

                case 'add-doc':

                    $('#modal-doc').modal('show');

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


        

    

    })

    let app = new Vue({
        el: '#app',
        data: {
            message: 'Print By Vue',
            permintaans: [],
            keyword: ''
        },
        methods: {

            getPenawaran: function( idPermintaan ) {
                

                
            },

            getPermintaan: function() {

            }

        }, 
        mounted() {
            axios.get('/api/permintaan').then(res => {

                

            });
        }
    })
</script>

<?php $this->endSection(); ?>