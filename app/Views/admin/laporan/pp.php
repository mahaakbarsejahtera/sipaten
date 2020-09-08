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
        <div class="modal-dialog" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Laporan Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
           
                    <div id="js-laporan-pp-item">



                        <form action="" method="POST">
                            <input type="hidden" name="id_pengajuan_proyek" id="i-id_pengajuan_proyek" value="">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-3">
                                    <label for="i-status_laporan_pengajuan_proyek">Status Laporan</label>
                                    <select name="status_laporan_pengajuan_proyek" id="i-status_laporan_pengajuan_proyek" class="form-control">

                                        <?php 
                                        
                                        $statuses = [
                                            'Draft',
                                            'Accepted',
                                            'Revisi',
                                            'Pending',
                                            'Reject'
                                        ]; 
                                        
                                        ?>

                                        <?php foreach($statuses as $status) : ?>
                                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="200" class="text-center align-middle">Nama</th>
                                                <th width="20" class="text-center align-middle">Qty</th>
                                                <th width="100" class="text-center align-middle">Harga</th>
                                                <th width="100" class="text-center">Total</th>
                                                <th></th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <button class="btn btn-primary" id="js-simpan-laporan">Simpan  Laporan</button>
                        </form>
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
                url: `${baseUrl}/api/laporan/pengajuan-proyek`,
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
                                <td>${v.no_surat_pengajuan_proyek}</td>
                                <td>${v.tanggal_pengajuan_proyek}</td>
                                <td>${v.due_date_pengajuan_proyek}</td>
                                <td>${Rp(v.nilai_pengajuan)}</td>
                                  
                                <td>
                                    <div>${v.pengaju.user_fullname}</div>
                                </td>
                                <td>

                                    <div>
                                        <a 
                                            href="javascript:void(0)"  
                                            data-toggle="table-action"  
                                            data-action="lihat-laporan" 
                                            data-id="${v.id_pengajuan_proyek}">
                                                <span>Lihat Laporan</span>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="${baseUrl}/dashboard/laporan/pengajuan-proyek?id_pp=${v.id_pengajuan_proyek}">Download</a>
                                    </div>
                  
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
      
        function clearForm() {
            $('#form-pengajuan')[0].reset();
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

                    let idPengajuanProyek = btn.data('id');

                    $('#i-id_pengajuan_proyek').val(idPengajuanProyek);

                    LaporanPengajuanProyek.items({ 
                        no_limit: true,
                        filters: [
                            { key: 'id_pengajuan_proyek', value: idPengajuanProyek }
                        ]
                    })
                    .then( response => {
                        
                        console.log('response', response);

                        let tbody       = $('#js-laporan-pp-item').find('tbody');
                        let total       = 0;
                        let totalActual = 0;
                        tbody.html('');
                        response.data.lists.map((v, i) => {

                            let subtotal = parseFloat(v.pengajuan_proyek_qty) * parseFloat(v.pengajuan_proyek_price);
                            let subtotalActual = parseFloat(v.pengajuan_proyek_actual_qty) * parseFloat(v.pengajuan_proyek_actual_price);
                            total += subtotal;
                            totalActual += subtotalActual;


                            tbody.append(`

                                <tr class="row-input" data-id="${v.id_pengajuan_proyek_item}" data-anggaran="${v.id_anggaran_item}">

                                    <td width="300px">${v.anggaran_item}</td>
                                    <td width="80px" class="text-center">${v.pengajuan_proyek_qty} ${v.anggaran_unit}</td>
                                    <td class="text-right" width="150px">${Rp(v.pengajuan_proyek_price)}</td>
                                    <td class="text-right" width="150px">${Rp(subtotal)}</td>
                                    <td width="50px">&nbsp;</td>
                                    <td width="150px">

                                        <input class="form-control form-bind form-qty" 
                                            data-target="#subtotal-${v.id_anggaran_item}"
                                            data-id_anggaran_item="${v.id_anggaran_item}"
                                            id="qty-${v.id_anggaran_item}" value="${v.pengajuan_proyek_actual_qty}">

                                    </td>
                                    <td width="200px">
                                        <input class="form-control form-bind form-price" 
                                            data-target="#subtotal-${v.id_anggaran_item}"
                                            data-id_anggaran_item="${v.id_anggaran_item}"
                                            id="price-${v.id_anggaran_item}" value="${v.pengajuan_proyek_actual_price}">
                                    </td>
                                    <td id="subtotal-${v.id_anggaran_item}" class="text-right" width="150px">${Rp(parseFloat(v.pengajuan_proyek_actual_price * v.pengajuan_proyek_actual_qty))}</td>
                                    <td>

                                        <textarea class="form-control" id="actual-keterangan-${v.id_anggaran_item}">${v.pengajuan_proyek_actual_keterangan}</textarea>
                                    
                                    </td>

                                </tr>

                            `)

                            
                        })

                        tbody.append(`

                            <tr>

                                <th class="text-center" colspan="3">Grand Total</th>
                                <th class="text-right">${Rp(total)}</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th id="grandtotal-actual" class="text-right">${Rp(totalActual)}</th>
                                <td></td>
                            </tr>

                        `)
                        
                        

                    })
                    

                    $('#modal-pengajuan').modal('show');

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


        $(document).on('keydown keyup change keypress', '.form-bind', function(e){


            let target = $($(this).data('target'));
            let idAnggaranItem = $(this).data('id_anggaran_item');

            let price   = parseFloat($('#price-' + idAnggaranItem).val());
            let qty     = parseFloat($('#qty-' + idAnggaranItem).val());
            let total   = (price * qty);

            if(isNaN(total)) total = 0;

            target.html(Rp(total));

            $('#grandtotal-actual').html(Rp(bindTotal()));

        });

        function bindTotal() {
            let formPrice = $('.form-price');
            let formQty = $('.form-qty');
            let length = formPrice.length;

            let total = 0;

            for(let i = 0; i < length; i ++) 
            { 
                
                let price = parseFloat($(formPrice[i]).val())
                let qty = parseFloat($(formQty[i]).val())
                let subtotal = price * qty;

                if(isNaN(subtotal)) total += 0;
                else total += subtotal;
                
            }

            //if(isNaN(total)) return 0;

            return total;

        }

        $('#js-simpan-laporan').click(function(e){
            e.preventDefault();

            let data = {
                id_pengajuan_proyek: $('#i-id_pengajuan_proyek').val(),
                status_laporan_pengajuan_proyek: $('#i-status_laporan_pengajuan_proyek').val()
            }

            LaporanPengajuanProyek
                .update(data)
                .then( afterUpdate => {

                    console.log('afterUpdate', afterUpdate);
                    let tbody = $('#js-laporan-pp-item').find('tbody');
                    let trs = tbody.find('.row-input');

                    for(let i=0; i < trs.length; i++) {

                        console.log(trs[i]);
                        let tr          = $(trs[i]);
                        let id          = tr.data('id');
                        let anggaran    = tr.data('anggaran');


                        let qty         = tr.find('#qty-' + anggaran).val();
                        let price       = tr.find('#price-' + anggaran).val();
                        let keterangan  = tr.find('#actual-keterangan-' + anggaran).val();

                        data = {
                            id_pengajuan_proyek_item: id,
                            pengajuan_proyek_actual_qty: qty,
                            pengajuan_proyek_actual_price: price,
                            pengajuan_proyek_actual_keterangan: keterangan
                        }

                        console.log('update item', data);

                        LaporanPengajuanProyek
                            .updateItem(data)
                            .then( response => {

                                console.log('update item', response)

                            })
                            .catch( err => console.log('err item', err));

                    }

                    
                    Toast('success', 'Berhasil Disimpan');

                });

        })
       
    })
</script>

<?php $this->endSection(); ?>   