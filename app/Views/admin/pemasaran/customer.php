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
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#form-modal" class="btn btn-primary mb-3">Tambah Data</a>
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
                        <input type="hidden" name="id_customer" id="i-id_customer">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <label for="i-kode_customer">Kode</label>
                            <input type="text" name="kode_customer" class="form-control" id="i-kode_customer">
                        </div>

                        <div class="form-group">
                            <label for="i-nama_customer">Nama </label>
                            <input type="text" name="nama_customer" class="form-control" id="i-nama_customer">
                        </div>

                        <!-- <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="i-pic_nama_customer">Nama PIC</label>
                                <input type="text" name="pic_nama_customer" class="form-control" id="i-pic_nama_customer">
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="i-pic_no_customer">Kontak PIC</label>
                                <input type="text" name="pic_no_customer" class="form-control" id="i-pic_no_customer">
                            </div>
                        </div> -->



                        <div class="form-group">
                            <label for="i-alamat_customer">Alamat</label>
                            <textarea name="alamat_customer" id="i-alamat_customer" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="responsive-table collapse" id="js-pic-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Jabatan</th>
                                        <th>Kontak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="js-pic-tbody"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <input type="text" class="form-control form-control-sm" id="i-nama_pic">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm" id="i-divisi_pic">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm" id="i-jabatan_pic">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm" id="i-kontak_pic">
                                        </th>
                                        <th>
                                            <a href="javascript:void(0)" class="btn btn-primary" id="js-add-pic">
                                                <span class="fas fa-plus"></span>
                                            </a>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Customer</button>

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

        $('#form-modal').on('hide.bs.modal', function () {
            $('#js-pic-table').collapse('hide');
            clearForm();
        })

        loadData();
        function loadData(data = {}) {
            
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="7">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/customer') ?>",
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    // `<td><a href="javascript:void(0)" data-toggle="table-action" data-action="create-timeline" data-id="${v.id_permintaan}">Buat Timeline</a></td><td><a href="">Berkas</a></td>`
                    response.data.lists.map((v, i) => {
                        
                        let picHTML = `<ul style="list-style: none; padding: 0; margin: 0;">`
                        let pics = v.pics.map((v,i) => {
                            picHTML += `<li>${v.nama_pic}/${v.kontak_pic}</li>`
                        })
                        picHTML += `</ul>`;


                        html += `
                        
                            <tr>
                                <td>
                                    <div>${v.nama_customer}</div>
                                </td>
                                <td>${picHTML}</td>
                                <td>${v.alamat_customer}</td>
                                <td>

                                    <a href="javascript:void(0)" class="btn btn-warning mb-2" title="Edit Permintaan" data-toggle="table-action" data-action="edit" data-id="${v.id_customer}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    
                                    <a href="javascript:void(0)" class="btn btn-danger mb-2" title="Hapus Permintaan" data-toggle="table-action"  data-action="delete" data-id="${v.id_customer}">
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
                url: "<?php echo base_url('/api/customer') ?>",
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
                url: "<?php echo base_url('/api/customer/update') ?>",
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
                url: `<?php echo base_url('/api/customer/show') ?>/${id}`,
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
                url: `<?php echo base_url('/api/customer') ?>/${id}/delete`,
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
                    let idCustomer = $(this).data('id');
                    getData(idCustomer)
                    .then(() => { 
                    
                        btn.html(`<span class="fas fa-edit"></span>`)
                    
                    })
                    .then(() => {
                        loadDataPic({
                            filters: [{
                                key: 'id_customer',
                                value: idCustomer
                            }]
                        })
                    })
                    .then(() => {
                    
                        $('#js-pic-table').collapse('show')
                    
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

        function createPicRow(data)
        {

            let html = `
                <tr class="" id="tr-${data.id_pic}">
                    <td>
                        <input type="text" class="form-control" id="i-nama_pic-${data.id_pic}" value="${data.nama_pic}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="i-divisi_pic-${data.id_pic}" value="${data.divisi_pic}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="i-jabatan_pic-${data.id_pic}" value="${data.jabatan_pic}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="i-kontak_pic-${data.id_pic}" value="${data.kontak_pic}">
                    </td>
                    <td width="150">
                        <a href="javascript:void(0)" class="btn btn-warning js-update-pic" data-id="${data.id_pic}">
                            <span class="fas fa-edit"></span>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger js-delete-pic" data-id="${data.id_pic}">
                            <span class="fas fa-trash"></span>
                        </a>
                    </td>
                </tr>
            `;

            return html;
        }

        function addPic() {

            let data = {
                id_customer: $('#i-id_customer').val(),
                nama_pic: $('#i-nama_pic').val(),
                divisi_pic: $('#i-divisi_pic').val(),
                jabatan_pic: $('#i-jabatan_pic').val(),
                kontak_pic: $('#i-kontak_pic').val()
            }

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/pic`,
                data: data, 
                success: function(response) {
                    console.log('success response add', response);
                    switch(response.code) {

                        case 200: 
                            Toast('success', 'Berhasil menambahkan PIC');
                            $('#js-pic-tbody').append(createPicRow(response.data))
                            $('#i-nama_pic').val(''),
                            $('#i-divisi_pic').val(''),
                            $('#i-jabatan_pic').val(''),
                            $('#i-kontak_pic').val('')

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

        function updatePic(data) {

            return $.ajax({
                method: 'POST',
                url: `${baseUrl}/api/customer/update`,
                data: data, 
                success: function(response) {
                    console.log('success response add', response);

                    switch(response.code) {

                        case 200: 
                            Toast('success', 'berhasil memperbaharui PIC');
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

        function deletePic( id ) {
            return $.ajax({
                method: 'POST',
                url: `<?php echo base_url('/api/pic') ?>/${id}/delete`,
                success: function(response) {
                    switch(response.code) {
                        case 200:
                            Toast('success', 'PIC berhasil dihapus');
                            
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

        function loadDataPic(data = {}) {
            
            $('#js-pic-tbody').html(`
                <tr>
                    <td colspan="4">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/pic') ?>",
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    // `<td><a href="javascript:void(0)" data-toggle="table-action" data-action="create-timeline" data-id="${v.id_permintaan}">Buat Timeline</a></td><td><a href="">Berkas</a></td>`
                    response.data.lists.map((v, i) => {
                        html += createPicRow(v);
                    })

                    $('#js-pic-tbody').html(html);
                }
            })

        }


        $('#js-add-pic').click(function(e){
            e.preventDefault();
            console.log('add pic');
            addPic();
        })


        $(document).on('click', '.js-update-pic', function(e){
            e.preventDefault();

            let id = $(this).data('id');
            let idCustomer = $('#i-id_customer').val();
            let namaPic = $('#i-nama_pic-' + id).val();
            let divisiPic = $('#i-divisi_pic-' + id).val();
            let jabatanPic = $('#i-jabatan_pic-' + id).val();
            let kontakPic = $('#i-kontak_pic-' + id).val();

            let data = {
                id_customer: idCustomer,
                nama_pic: namaPic,
                divisi_pic: divisiPic,
                jabatan_pic: jabatanPic,
                kontak_pic: kontakPic
            };

            updatePic(data)

        });

        $(document).on('click', '.js-delete-pic', function(e){

            let btn = $(this);
            deletePic($(this).data('id'))
            .then(() => {
                btn
                .parent()
                .parent()
                .remove();
            });
        });
    })
</script>

<?php $this->endSection(); ?>