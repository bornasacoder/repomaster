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
            <h3 class="dt-page__title">Change Password</h3>
          </div>
          <!-- /entry heading -->
        </div>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php elseif($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
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
              <h3 class="dt-card__title">Change Password</h3>
            </div>
            <!-- /card heading -->
          </div>
          <!-- /card header -->
          <!-- Card Body -->
          <div class="dt-card__body">
            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">
              <!-- Form Group -->
              <div class="form-group">
                <label for="email-1">Current password</label>
                <input type="text" name="current_password" class="form-control" id="email-1"
                aria-describedby="emailHelp1" placeholder="Enter current password" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email-1">New password</label>
                <input type="text" name="new_password" class="form-control" id="email-1"
                aria-describedby="emailHelp1" placeholder="Enter new password" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email-1">Confirm password</label>
                <input type="text" name="confirm_password" class="form-control" id="email-1"
                aria-describedby="emailHelp1" placeholder="Enter confirm password" autocomplete="off">
              </div>
              
              <!-- Form Group -->
              <div class="form-group mb-0">
                <button type="submit" name="update" class="btn btn-primary text-uppercase">Update
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
  $('#change_password').addClass('selected');
  $('#change_password a').addClass('active');
  });
  </script>