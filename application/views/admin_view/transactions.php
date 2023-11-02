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
            <h3 class="dt-page__title">Users Wallet</h3>
          </div>
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
                <th class="hidden">Sno.</th>
                <th>Transaction no.</th>
                <th>User name</th>
                <th>Type</th>
                <th>Amount</th>
                <!-- <th>From Address</th> -->
                <!-- <th>To Address</th> -->
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($transaction_list))
              {
              $i=1;
              foreach($transaction_list as $listData)
              {
              ?>
              <tr class="gradeX">
                <td class="hidden"><?php echo $i; ?></td>
                <td><a class="trx_no" data-value="<?php echo $listData['id']; ?>" href="javascript:void(0);" data-toggle="modal" data-target="#defaul-modal"><?php echo $listData['trx_number']; ?></a></td>
                <td><?php echo $listData['full_name']; ?></td>
                <td><?php echo $listData['trx_type']; ?></td>
                <td><?php echo $listData['trx_amount']; ?></td>
                <!-- <td><?php echo $listData['from_wallet']; ?></td> -->
                <!-- <td><?php echo $listData['to_wallet']; ?></td> -->
                <td><?php echo date('d M, Y', strtotime($listData['trx_date'])); ?></td>
                <td>
                   <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#defaul-modal" value="<?php echo $listData['id']; ?>" onclick="get_transaction_detail(this.value);">
                    View
                </button>
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

  <script type="text/javascript">
      
    $('.trx_no').click(function()
    {
      get_transaction_detail($(this).attr('data-value'));
    });

    function get_transaction_detail(trx_id)
    {
      $.ajax({
        method:'POST',
        url:'<?= base_url("admin/get_transaction_detail"); ?>',
        data:{
          get_transaction_detail:'get_transaction_detail',
          trx_id:trx_id,
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
                <!-- Modal -->
    <div class="modal fade" id="defaul-modal" tabindex="-1" role="dialog"
      aria-labelledby="model-4" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="model-3">Transaction detail</h3>
            <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal_body_content">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm"
            data-dismiss="modal">Close
            </button>
            <!-- <button type="button" class="btn btn-primary btn-sm"data-dismiss="modal">Save changes </button> -->
          </div>
        </div>
      </div>
    </div>

  <script type="text/javascript">
  $(document).ready(function(){
  $('#transactions').addClass('selected');
  $('#transactions a').addClass('active');
  });
  </script>