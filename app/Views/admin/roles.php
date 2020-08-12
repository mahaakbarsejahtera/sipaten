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
                                <input type="number" class="form-control" placeholder="Search" min="1" max="99" id="filter-search">
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
                <!-- <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div> -->
                <div class="modal-body">
                    <form action="" id="form">

                        <input type="hidden" name="truth_action" id="i-truth_action" value="">
                        <input type="hidden" name="id_role" id="i-id_role">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <label for="i-role_name">Nama</label>
                            <input type="text" name="role_name" class="form-control" id="i-role_name">
                        </div>

                        <div class="form-group">
                            <label for="i-role_cap">Kapasitas</label>
                            <input type="text" name="role_cap" class="form-control" id="i-role_cap">
                        </div>

                        <div class="form-group">
                            <label for="i-role_desc">Deskripsi</label>
                            <textarea name="role_desc" id="i-role_desc" rows="10" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-primary" id="js-save">Simpan Role</button>

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

        let truthAction = $('#i-truth_acton');
        let tableData = $('#table-data');
        let form = $('#form');

        loadData();
        function loadData(data = {}) {
            tableData.find('tbody').html(`
                <tr>
                    <td colspan="4">Loading...</td>
                </tr>
            `);

            $.ajax({
                url: "<?php echo base_url('/api/roles') ?>",
                data: data,
                success: function(response) {

                    let html =  ``;

                    response.data.lists.map((v, i) => {
                        html += `
                        
                            <tr>
                                <td>${v.role_name}</td>
                                <td>${v.role_cap}</td>
                                <td>${v.role_desc}</td>
                                <td width="200">

                                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="table-action" data-action="edit" data-id="${v.id_role}">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="table-action"  data-action="delete" data-id="${v.id_role}">
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
                url: "<?php echo base_url('/api/roles') ?>",
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

        }
        
        function getData( id ) {
            
            return $.ajax({
                url: `<?php echo base_url('/api/roles/show') ?>/${id}`,
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
                url: `<?php echo base_url('/api/roles') ?>/${id}/delete`,
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

                    getData($(this).data('id'))
                    .then(() => btn.html(`<span class="fas fa-edit"></span>`));

                    break;

                case 'delete':

                    let tryToDelete = confirm('DELETE ???');

                    if(tryToDelete) {
                        deleteData($(this).data('id'))
                        .then(() => btn.html(`<span class="fas fa-trash"></span>`))
                        .catch(() => btn.html(`<span class="fas fa-trash"></span>`))
                    }

                    break;
            }
        })

    })
</script>

<?php $this->endSection(); ?>