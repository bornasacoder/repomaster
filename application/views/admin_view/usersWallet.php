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
                <th>Sno.</th>
                <th>User name</th>
                <th>Public Key</th>
                <th>Balance</th>
                <th>Private Key</th>
                <th>Create Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($usersWallet))
              {
              $i=1;
              foreach($usersWallet as $listData)
              {
              ?>
              <tr class="gradeX">
                <td><?php echo $i; ?></td>
                <td><?php echo $listData['full_name']; ?></td>
                <td><?php echo $listData['public_key']; ?></td>
                <td><?php echo $listData['balance']; ?></td>
                <td><?php echo $listData['private_key']; ?></td>
                <td><?php echo date('d M, Y', strtotime($listData['create_date'])); ?></td>
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
  $(document).ready(function(){
  $('#usersWallet').addClass('selected');
  $('#usersWallet a').addClass('active');
  });
  </script>