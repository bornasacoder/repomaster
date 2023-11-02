<!-- Site Content Wrapper -->
<div class="dt-content-wrapper">
  <!-- Site Content -->
  <div class="dt-content">
    <!-- Page Header -->
    <!-- Grid -->
    <div class="row">
      <!-- Grid Item -->
      <div class="col-xl-12">
        <!-- Entry Header -->
        <div class="dt-entry__header">
          <!-- Entry Heading -->
          <div class="dt-entry__heading">
            <h3 class="dt-page__title">Manage nsfw type</h3>
            
          </div>
              <button class="btn btn-primary" data-toggle="modal" data-target="#addModel"><i class="icon icon-plus"></i> Add more</button>
          <!-- /entry heading -->
        </div>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php elseif($this->session->flashdata('error')): ?>
        <div class="alert alert-error alert-dismissible" role="alert">
          <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        <!-- /entry header -->
        <!-- Tables -->
        <div class="table-responsive">
          <table id="data-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Sno.</th>
                <th>Name</th>
                <th>Create date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($data))
              {
              $i=1;
              foreach($data as $listData)
              {
              ?>
              <tr class="gradeX">
                <td><?php echo $i; ?></td>
               
                <td><?php echo $listData['nsfw']; ?></td>
                <td><?php echo date('d M, Y', strtotime($listData['datetime'])); ?></td>
                <td>
                  <button type="button" class="btn btn-info btn-sm edit_this" data-toggle="modal"
                        data-target="#editModel" value="<?php echo $listData['id']; ?>" onclick="get_nsfw_detail(this.value);"> Edit
                  </button>
                  <a href="<?php echo base_url('admin/delete_nsfw/'.base64_encode($listData['id'])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
              </tr>
              <?php $i++; } } ?>
              
            </tbody>
          </table>
        </div>
        <!-- /tables -->
      </div>
      <!-- /grid item -->
    </div>
    <!-- /grid -->
  </div>

  <div class="modal fade" id="addModel" tabindex="-1" role="dialog"
      aria-labelledby="model-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="model-3">Add nsfw type</h3>
            <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Type name</label>
                  <input type="text" class="form-control" name="nsfw" id="nsfw_type" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close
            </button>
            <button type="submit" name="adddata" id="adddata" class="btn btn-primary btn-sm">Add </button>
          </div>
          </form>
        </div>
      </div>
    </div>
 <!--    <script type="text/javascript">
      $('#adddata').click(function(){
        var nsfw = $('#nsfw_type').val();
        $.ajax({
            method:'POST',
            url:'<?= base_url("admin/nsfw_manage"); ?>',
            data:{
              adddata:'adddata',
              nsfw:nsfw,
            },
            beforeSend:function()
            {
              $('#adddata').html('Please wait...');
            },
            success:function(data)
            {
              $('#').html(data);
            }
          });
      });
    </script> -->
                <!-- Modal -->
    <div class="modal fade" id="editModel" tabindex="-1" role="dialog"
      aria-labelledby="model-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="model-3">Update</h3>
            <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
          <div class="modal-body" id="modal_body_content">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Type name</label>
                  <input type="text" class="form-control" name="nsfw">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm"
            data-dismiss="modal">Close
            </button>
            <button type="submit" name="update" class="btn btn-primary btn-sm">Update </button>
          </div>
          </form>
        </div>
      </div>
    </div>

  <script type="text/javascript">
  $(document).ready(function(){
  $('#nsfw_manage').addClass('selected');
  $('#nsfw_manage a').addClass('active');
  });
  </script>

    <script type="text/javascript">
      
    $('.edit_this').click(function()
    {
      get_nsfw_detail($(this).val());
    });

    function get_nsfw_detail(trx_id)
    {
      $.ajax({
        method:'POST',
        url:'<?= base_url("admin/get_nsfw_detail"); ?>',
        data:{
          get_nsfw_detail:'get_nsfw_detail',
          nsfw_id:trx_id,
        },
        beforeSend:function()
        {
          $('#modal_body_content').html('<center><h3>Please wait...</h3></center>');
        },
        success:function(data)
        {
          $('#modal_body_content').html(data);
        }
      });
    }
  </script>