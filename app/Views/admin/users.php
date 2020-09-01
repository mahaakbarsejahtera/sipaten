<?php $this->extend('admin/layouts') ?>

<?php $this->section('content') ?>

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

    
    <!-- Modal Form -->
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
                        <input type="hidden" name="id_user" id="i-id_user">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <label for="i-user_fullname">Nama Lengkap</label>
                            <input type="text" name="user_fullname" class="form-control" id="i-user_fullname">
                        </div>

                        <div class="form-group">
                            <label for="i-user_name">Username</label>
                            <input type="text" name="user_name" class="form-control" id="i-user_name">
                        </div>

                        <div class="form-group">
                            <label for="i-user_email">Email</label>
                            <input type="email" name="user_email" class="form-control" id="i-user_email">
                        </div>

                        <div class="form-group">
                            <label for="i-user_role">Role</label>
                            <select name="user_role" id="i-user_role" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="i-user_divisi">Divisi</label>
                            <select name="user_divisi" id="i-user_divisi" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div> -->

                        <div class="form-group">
                            <label for="i-user_status">Status</label>
                            <select name="user_status" id="i-user_status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Suspend">Suspend</option>
                                <option value="Active">Active</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="i-user_image">Image</label>
                            <input type="file" name="user_image" id="user_image" class="form-control">
                        </div>

                        <div id="preview-user_image" style="max-width: 100px" class="mt-2"></div>

                        <button class="btn btn-primary" id="js-save">Simpan Users</button>

                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Modal Form -->

    
    <!-- Modal Change Password -->
    <div class="modal fade" id="form-change-password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" name="change_password_id" id="i-change_password_id">
                        <div class="form-group">
                            <label for="i-user_pass">New password</label>
                            <input type="password" name="user_pass" id="i-user_pass" class="form-control">
                        </div>

                        <button class="btn btn-primary" id="js-change-password">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $this->endSection(); ?>


<?php $this->section('footerScript') ?>

<script>
    $(function(){
        //$('#form-modal').modal('show');

        let truthAction = $('#i-truth_action');
        let tableData = $('#table-data');
        let form = $('#form')[0];

        $('#form-modal').on('hidden.bs.modal', function (event) {
            clearForm();
        })

        loadData();
        function loadData(data = {}) {
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="4">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/users') ?>",
                data: data,
                success: function(response) {
                    console.log(response);
                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        html += `
                        
                            <tr>
                                <td>${v.user_fullname}</td>
                                <td>${v.user_email}</td>
                                <td>${v.role_name}</td>
                                <td>${v.user_status}</td>
                                <td width="200">

                                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="table-action" data-action="edit" data-id="${v.id_user}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="table-action"  data-action="delete" data-id="${v.id_user}">
                                        <span class="fas fa-trash"></span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="table-action"  data-action="change-password" data-id="${v.id_user}">
                                        <span class="fas fa-lock"></span>
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


        function getRoles() {

            return $.ajax({
                url: "<?php echo base_url("api/roles/?page_group1=-1") ?>",
                data: {
                    no_limit: true
                }
            })

        }

        getRoles()
        .then(response => {

            let html = `<option value="">Pilih</option>`;
            response.data.lists.map((v, i) => {
                html += `<option value="${v.id_role}">${v.role_name}</option>`;
            })

            $('#i-user_role').html(html);

        })


        function addData() {

            let data = new FormData(form);

            return $.ajax({
                method: 'POST',
                contentType: false,
                processData: false,
                url: "<?php echo base_url('/api/users') ?>",
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
                    console.log(response);
                    Toast('error', 'Something Wrong!!!');
                }
            })

        }

        function updateData() {
            
            let data = new FormData(form);

            return $.ajax({
                method: 'POST',
                contentType: false,
                processData: false,
                url: "<?php echo base_url('/api/users/update') ?>",
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
                url: `<?php echo base_url('/api/users/show') ?>/${id}`,
                success: function(response) {

                    truthAction.val('update');

                    for(data in response.data) {

                        switch(data) {
                            
                            case 'user_image':
                                $('#preview-user_image').html(`<img src="<?php echo base_url('uploads/users') ?>/${response.data['user_image']}" class="w-100">`)
                                break
                            
                            default:
                                $('#i-' + data).val(response.data[data]);
                                break;
                        }
                        
                    }
                    
                    $('#form-modal').modal('show');
                }
            })

        }

        function deleteData( id ) {
            return $.ajax({
                method: 'POST',
                url: `<?php echo base_url('/api/users') ?>/${id}/delete`,
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
            $('#i-id_user').val('');
            $('#preview-user_image').html('');
            truthAction.val('');
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

                case 'change-password':
                    
                    $('#i-change_password_id').val(btn.data('id'));
                    $('#form-change-password').modal('show');
                    btn.html(`<span class="fas fa-lock"></span>`);

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

        $('#js-change-password').click(function(e){
            e.preventDefault();

            $.ajax({
                method: 'POST',
                url: "<?php echo base_url('/api/users/change-password') ?>",
                data: {
                    id_user: $('#i-change_password_id').val(),
                    user_pass: $('#i-user_pass').val()
                },
                success: function(response) {
                    console.log(response);
                    if(response.code == 200) {
                        Toast('success', 'Berhasil memperbaharui password');
                        $('#form-change-password').find('form')[0].reset();
                    } 

                    if(response.code == 400) {
                        Toast('warning', response.message);
                    }

                },
                error: function(response) {
                    console.log(response);
                    Toast('error', 'Something Wrong!!');
                }
            })
        })

    })
</script>

<?php $this->endSection(); ?>