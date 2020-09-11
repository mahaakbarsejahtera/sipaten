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
                    <div id="gantt_timeline"  style='width: 100%; min-width:100%; min-height:100%; height: 100vh;'></div>
                </div>
            </div>    
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
 
 

<?php $this->endSection(); ?>

<?php $this->section('headerScript') ?>

    <link rel="stylesheet" href="<?php echo base_url("/assets/plugins/gantt/codebase/dhtmlxgantt.css") ?>">

<?php $this->endSection() ?>

<?php $this->section('footerScript') ?>
<script src="<?php echo base_url("/assets/plugins/gantt/codebase/dhtmlxgantt.js"); ?>"></script>
<script>
    
    gantt.init('gantt_timeline');

    $(function(){

        let truthAction = $('#i-truth_action');
        let tableData = $('#table-data');
        let form = $('#form');

        let currentDate = new Date();
        gantt.config.start_date = new Date();
        gantt.config.end_date = new Date(currentDate.getFullYear() + 100, currentDate.getMonth(), currentDate.getDay());
        console.log(gantt.config);

        let dp = gantt.createDataProcessor((entity, action, data, id) => {
            console.log(data);
            switch(action) {
                case 'create':
                    return gantt.ajax.post(`${baseUrl}/api/timeline/${entity}/add`, data).then( res => console.log('res', res));
                    break;
                case 'update':
                    return gantt.ajax.post(`${baseUrl}/api/timeline/${entity}/update/${id}`, data);
                    break;
            }
        });

        dp.mode = 'REST-JSON';




        loadData();
        function loadData(data = {}) {
            return $.ajax({
                url: "<?php echo base_url('/api/timeline') ?>",
                data: data,
                success: function(response) {
                    gantt.parse(response.data);
                }
            })

        }


    })
</script>

<?php $this->endSection(); ?>