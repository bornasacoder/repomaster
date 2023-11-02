<!-- Site Content Wrapper -->
<div class="dt-content-wrapper">
  <!-- Site Content -->
  <div class="dt-content">
    <!-- Page Header -->
    <div class="dt-page__header">
      <h1 class="dt-page__title">Dashboard </h1>
    </div>
    <!-- /page header -->
    <!-- Grid -->
    <div class="row">
      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6 col-12">
        <!-- Card -->
        <div class="dt-card">
          <!-- Card Body -->
          <div class="dt-card__body px-5 py-4">
            <h6 class="text-body text-uppercase mb-2">Total Users</h6>
            <div class="d-flex align-items-baseline mb-4">
              <span class="display-4 font-weight-500 text-dark mr-2"><?php echo $total_user; ?></span>
              <!-- <div class="d-flex align-items-center">
                <div class="trending-section font-weight-500 text-success mr-2">
                  <span class="value">03%</span>
                </div>
                <span class="f-12">This week</span>
              </div> -->
            </div>
            <div class="dt-indicator-item__info mb-2" data-fill="62" data-max="100">
              <div class="dt-indicator-item__bar">
                <div class="dt-indicator-item__fill fill-pointer bg-primary"></div>
              </div>
            </div>
          </div>
          <!-- /bard body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /grid item -->
      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6 col-12">
        <!-- Card -->
        <div class="dt-card">
          <!-- Card Body -->
          <div class="dt-card__body px-5 py-4">
            <h6 class="text-body text-uppercase mb-2">Total Post</h6>
            <div class="d-flex align-items-baseline mb-4">
              <span class="display-4 font-weight-500 text-dark mr-2"><?php echo $total_post; ?></span>
             
            </div>
            <div class="dt-indicator-item__info mb-2" data-fill="48" data-max="100">
              <div class="dt-indicator-item__bar">
                <div class="dt-indicator-item__fill fill-pointer bg-warning"></div>
              </div>
            </div>
          </div>
          <!-- /bard body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /grid item -->
      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6 col-12">
        <!-- Card -->
        <div class="dt-card">
          <!-- Card Body -->
          <div class="dt-card__body px-5 py-4">
            <h6 class="text-body text-uppercase mb-2">Total Support Request</h6>
            <div class="d-flex align-items-baseline mb-4">
              <span class="display-4 font-weight-500 text-dark mr-2"><?php echo $total_support_req; ?></span>
              
            </div>
            <div class="dt-indicator-item__info mb-2" data-fill="85" data-max="100">
              <div class="dt-indicator-item__bar">
                <div class="dt-indicator-item__fill fill-pointer bg-success"></div>
              </div>
            </div>
          </div>
          <!-- /bard body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /grid item -->
      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6 col-12">
        <!-- Card -->
        <div class="dt-card">
          <!-- Card Body -->
          <div class="dt-card__body px-5 py-4">
            <h6 class="text-body text-uppercase mb-2">Total Likes</h6>
            <div class="d-flex align-items-baseline mb-4">
              <span class="display-4 font-weight-500 text-dark mr-2"><?php echo $total_like; ?></span>
             
            </div>
            <div class="dt-indicator-item__info mb-2" data-fill="90" data-max="100">
              <div class="dt-indicator-item__bar">
                <div class="dt-indicator-item__fill fill-pointer bg-secondary"></div>
              </div>
            </div>
          </div>
          <!-- /bard body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /grid item -->
    </div>
    <!-- Grid Item -->
    <div class="col-xl-12 order-xl-4">
        <!-- Grid -->
        <div class="row">
          <h3>Recent Users</h3>
            <!-- Grid Item -->
            <div class="col-12">
                <div class="w-100 ps-custom-scrollbar mb-6">
                    <!-- List -->
                    <ul class="dt-list dt-list-xxl dt-list-bordered flex-nowrap">
                        <!-- List Item -->
                      <?php 
                        if(!empty($recent_user))
                        {
                          foreach($recent_user as $userList)
                          {
                      ?>
                        <li class="dt-list__item text-center col">
                            <div class="dt-avatar-wrapper flex-column">
                                <img src="<?php echo $userList['profile_pic']; ?>" alt="<?php echo $userList['full_name']; ?>"
                                     class="dt-avatar mb-4 size-80">
                                <div class="dt-avatar-info">
                                    <span class="dt-avatar-name mb-1 text-nowrap"><?php echo $userList['full_name']; ?></span>
                                    <!-- List -->
                                    <ul class="dt-list dt-list-bordered dt-list-cm-0 f-12 flex-nowrap">
                                        <!-- List Item -->
                                        <li class="dt-list__item">
                                            <div class="d-inline-flex align-items-center">
                                                <i class="icon icon-users mr-2 text-yellow"></i>
                                                <span><?php echo $userList['follower']; ?> Follower</span>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>
                      <?php } } ?>
                       
                    </ul>
                    <!-- /list -->
                </div>
            </div>
            <!-- /grid item -->
   </div>
  </div>

  <!-- Grid -->
<div class="row">

    <!-- Grid Item -->
    <div class="col-xl-12">


      <h3>Recent Post</h3>
    </div>
    <?php 
      if(!empty($userPost))
      {
        foreach($userPost as $postData)
        {
    ?>
    <div class="col-xl-12">
        <div class="dt-card">
            <div class="dt-card__body">
                <div class="d-sm-flex flex-sm-row">
                    <img class="dt-avatar size-60 mr-6 mb-6 mb-sm-0"
                         src="<?php echo $postData['profile_pic']; ?>" alt="User">
                    <div class="flex-1 overflow-hidden mb-6 mb-sm-0 pr-sm-3">
                        <div class="user-detail mb-3">
                            <span class="user-name"><?php echo $postData['full_name']; ?></span>
                            <span class="dt-separator-v">&nbsp;</span>
                            <span class="designation"><?php echo $postData['duration']; ?></span>
                        </div>
                        <p class="text-truncate"><?php echo $postData['message']; ?></p>
                        <div class="d-flex flex-sm-row flex-column">
                            <div class="mb-4 mb-sm-0">
                                <span class="mr-4 mr-md-6 text-nowrap"><span class="text-dark"><?php echo $postData['like_count']; ?></span> <i class="icon icon-thumbs-up"></i></span>
                                <span class="mr-4 mr-md-6 text-nowrap"><span class="text-dark"><?php echo $postData['dislike_count']; ?> </span> <i class="icon icon-thumbs-down"></i></span>
                            </div>
                        </div>
                    </div>
                    <?php  if(!empty($postData['file'])) { ?>
                    <div class="min-w-120">
                      <img src="<?php echo $postData['file']; ?>" alt="Property" style="width: 200px; height: 130px;">
                    </div>
                  <?php } ?>
                </div>
            </div>
        </div>
    </div>
  <?php } } ?>

</div>
<!-- /grid --> 


  
  <script type="text/javascript">
  $(document).ready(function(){
     $('#dashboardnav').addClass('selected');
    $('#dashboardnav a').addClass('active');
  });
</script>