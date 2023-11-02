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
            <h3 class="dt-page__title">Profile</h3>
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
              <h3 class="dt-card__title">Update your profile</h3>
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
                <label for="email-1">Name</label>
                <input type="text" name="full_name" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $login_user_info['full_name']; ?>" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="email-1">Email address</label>
                <input type="email" class="form-control" name="email" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $login_user_info['email'];?>" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="email-1">Mobile</label>
                <input type="number" name="mobile" class="form-control" id="email-1"
                aria-describedby="emailHelp1" value="<?php echo $login_user_info['mobile'];?>" placeholder="Enter email">
              </div>

              <div class="form-group">
                <label for="email-1">Profile</label>
                <input type="file" class="form-control" name="profile_pic" aria-describedby="emailHelp1">
                <?php if(!empty($login_user_info['profile_pic'])){ ?>
                <img src="<?php echo base_url('uploads/users_profile/'.$login_user_info['profile_pic']); ?>" width="100px">
              <?php }else{ ?>
                <img src="<?php echo base_url('uploads/users_profile/avatar.jpg'); ?>" width="100px">
              <?php } ?>
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
  $('#profile').addClass('selected');
  $('#profile a').addClass('active');
  });
  </script>