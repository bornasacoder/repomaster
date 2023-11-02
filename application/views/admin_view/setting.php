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
            <h3 class="dt-page__title">Setting</h3>
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
        <!-- Card -->
        <div class="dt-card">
          <!-- Card Header -->
          <div class="dt-card__header">
            <!-- Card Heading -->
            <div class="dt-card__heading">
              <h3 class="dt-card__title">Update Setting</h3>
            </div>
            <!-- /card heading -->
          </div>
          <!-- /card header -->
          <!-- Card Body -->
          <div class="dt-card__body">
            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">
              <!-- Form Group -->
              <input type="hidden" value="<?php echo $setting_data['id']; ?>" name="requestId">
              <div class="form-group">
                <label for="email-1">Freedomcell usd price</label>
                <input type="text" name="fcell_usd_price" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['fcell_usd_price']; ?>" placeholder="Enter freedomcell usd price" autocomplete="off">
              </div>
               <div class="form-group">
                <label for="email-1">ETH public key</label>
                <input type="text" name="eth_public_key" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['eth_public_key']; ?>" placeholder="Enter ETH public key" autocomplete="off">
              </div>
               <div class="form-group">
                <label for="email-1">ETH private key</label>
                <input type="text" name="eth_private_key" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['eth_private_key']; ?>" placeholder="Enter ETH private key" autocomplete="off">
              </div>
               <div class="form-group">
                <label for="email-1">Freedomcell contract address</label>
                <input type="text" name="fcell_contract_address" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['fcell_contract_address']; ?>" placeholder="Enter freedomcell contract address" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email-1">BTC public key</label>
                <input type="text" name="btc_private_key" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['btc_private_key']; ?>" placeholder="Enter BTC public key" autocomplete="off">
              </div>
               <div class="form-group">
                <label for="email-1">BTC private key</label>
                <input type="text" name="btc_public_key" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $setting_data['btc_public_key']; ?>" placeholder="Enter BTC private key" autocomplete="off">
              </div>

              <!-- Form Group -->
              <div class="form-group mb-0">
                <button type="submit" onclick="return confirm('Are you sure?');" name="update" class="btn btn-primary text-uppercase">Update
                </button>
              </div>
              <!-- /form group -->
            </form>
            <!-- /form -->
          </div>
          <!-- /card body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /grid item -->
    </div>
    <!-- /grid -->
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
  $('#setting').addClass('selected');
  $('#setting a').addClass('active');
  });
  </script>