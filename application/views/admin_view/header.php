<?php 
  $admin_id = $this->session->userdata('admin_id');
   if(empty($admin_id))
   {
     redirect('admin');
   }
   else{
     $login_user_info = $this->common_model->getSingleRecordById('users', array('id'=>$admin_id));
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Drift - A fully responsive, HTML5 based admin template">
<meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass"> -->
<!-- /meta tags -->
<title> Freedomcell - <?php echo $title; ?></title>

<!-- Site favicon -->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- /site favicon -->

<!-- Font Icon Styles -->
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/styles.css">
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/flag-icon.min.css">
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/styles_1.css">
<!-- /font icon Styles -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/'); ?>css/dataTables.bootstrap4.css" media="all">
<!-- Perfect Scrollbar stylesheet -->
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/perfect-scrollbar.css">
<!-- /perfect scrollbar stylesheet -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/'); ?>css/owl.carousel.min.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/'); ?>css/chartist.min.css" media="all">

<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/theme-semidark.min.css">

<!-- <script>
    var rtlEnable = '';
        var $mediaUrl = '../';
        var $baseUrl = '../';
    var current_path = window.location.href.split('/').pop();
    if (current_path == '') {
        current_path = 'index.html';
    }
</script> -->

<script src="<?php echo base_url('admin_assets/'); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url('admin_assets/'); ?>js/moment.min.js"></script>
<script src="<?php echo base_url('admin_assets/'); ?>js/bootstrap.bundle.min.js"></script>
<!-- Perfect Scrollbar jQuery -->
<script src="<?php echo base_url('admin_assets/'); ?>js/perfect-scrollbar.min.js"></script>
<!-- /perfect scrollbar jQuery -->

</head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
    <!-- Loader -->
<div class="dt-loader-container">
  <div class="dt-loader">
    <svg class="circular" viewbox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>
</div>
<!-- /loader -->
    <!-- Root -->
    <div class="dt-root">
        <div class="dt-root__inner">
            <!-- Header -->
<header class="dt-header">

  <!-- Header container -->
  <div class="dt-header__container">

    <!-- Brand -->
    <div class="dt-brand">

      <!-- Brand tool -->
     <!--  <div class="dt-brand__tool" data-toggle="main-sidebar">
        <div class="hamburger-inner"></div>
      </div> -->
      <!-- /brand tool -->

      <!-- Brand logo -->
      <span class="dt-brand__logo">
        <a class="dt-brand__logo-link" href="index.html">
          <img class="dt-brand__logo-img d-none d-sm-inline-block" src="<?php echo base_url('admin_assets/'); ?>logo_freedom_white.png" style="width: 130px!important;" alt="Drift">
          <img class="dt-brand__logo-symbol d-sm-none" src="<?php echo base_url('admin_assets/'); ?>logo_freedom_white.png" alt="Drift">
        </a>
      </span>
      <!-- /brand logo -->

    </div>
    <!-- /brand -->

    <!-- Header toolbar-->
    <div class="dt-header__toolbar">


      <!-- Header Menu Wrapper -->
      <div class="dt-nav-wrapper">


        <!-- Header Menu -->
        <ul class="dt-nav">
          <li class="dt-nav__item dt-notification dropdown">

            <!-- Dropdown Link -->
            <a href="#" class="dt-nav__link dropdown-toggle no-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon icon-notification2 icon-fw dt-icon-alert"></i>
            </a>
            <!-- /dropdown link -->

            <!-- Dropdown Option -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
              <!-- Dropdown Menu Header -->
              <div class="dropdown-menu-header">
                <h4 class="title">Notifications (9)</h4>

                <div class="ml-auto action-area">
                  <a href="javascript:void(0)">Mark All Read</a> <a class="ml-2" href="javascript:void(0)">
                    <i class="icon icon-settings icon-lg text-light-gray"></i> </a>
                </div>
              </div>
              <!-- /dropdown menu header -->

              <!-- Dropdown Menu Body -->
              <div class="dropdown-menu-body ps-custom-scrollbar">

                <div class="h-auto">
                  <!-- Media -->
                  <a href="javascript:void(0)" class="media">

                    <!-- Avatar -->
                    <img class="dt-avatar mr-3" src="<?php echo base_url('admin_assets/'); ?>images/stella-johnson.jpg" alt="User">

                    <!-- avatar -->

                    <!-- Media Body -->
                    <span class="media-body">
                    <span class="message">
                      <span class="user-name">Stella Johnson</span> and <span class="user-name">Chris Harris</span>
                      have birthdays today. Help them celebrate!
                    </span>
                    <span class="meta-date">8 hours ago</span>
                  </span>
                    <!-- /media body -->

                  </a>
                  <!-- /media -->

                  <!-- Media -->
                  <a href="javascript:void(0)" class="media">

                    <!-- Avatar -->
                    <img class="dt-avatar mr-3" src="<?php echo base_url('admin_assets/'); ?>images/jeson-born.jpg" alt="User">
                    <!-- avatar -->

                    <!-- Media Body -->
                    <span class="media-body">
                    <span class="message">
                      <span class="user-name">Jonathan Madano</span> commented on your post.
                    </span>
                    <span class="meta-date">9 hours ago</span>
                  </span>
                    <!-- /media body -->

                  </a>
                  <!-- /media -->

                  <!-- Media -->
                  <a href="javascript:void(0)" class="media">

                    <!-- Avatar -->
                    <img class="dt-avatar mr-3" src="<?php echo base_url('admin_assets/'); ?>images/selena.jpg" alt="User">
                    <!-- avatar -->

                    <!-- Media Body -->
                    <span class="media-body">
                    <span class="message">
                      <span class="user-name">Chelsea Brown</span> sent a video recomendation.
                    </span>
                    <span class="meta-date">
                      <i class="icon icon-play-circle text-primary icon-fw mr-1"></i>
                      13 hours ago
                    </span>
                  </span>
                    <!-- /media body -->

                  </a>
                  <!-- /media -->

                  <!-- Media -->
                  <a href="javascript:void(0)" class="media">

                    <!-- Avatar -->
                    <img class="dt-avatar mr-3" src="<?php echo base_url('admin_assets/'); ?>images/alex-dolgove.jpg" alt="User">
                    <!-- avatar -->

                    <!-- Media Body -->
                    <span class="media-body">
                    <span class="message">
                      <span class="user-name">Alex Dolgove</span> and <span class="user-name">Chris Harris</span>
                      like your post.
                    </span>
                    <span class="meta-date">
                      <i class="icon icon-like text-light-blue icon-fw mr-1"></i>
                      yesterday at 9:30
                    </span>
                  </span>
                    <!-- /media body -->

                  </a>
                  <!-- /media -->
                </div>

              </div>
              <!-- /dropdown menu body -->

              <!-- Dropdown Menu Footer -->
              <div class="dropdown-menu-footer">
                <a href="javascript:void(0)" class="card-link"> See All <i class="icon icon-arrow-right icon-fw"></i>
                </a>
              </div>
              <!-- /dropdown menu footer -->
            </div>
            <!-- /dropdown option -->

          </li>


        </ul>
        <!-- /header menu -->

        <!-- Header Menu -->
        <ul class="dt-nav">
          <li class="dt-nav__item dropdown">

            <!-- Dropdown Link -->
            <a href="#" class="dt-nav__link dropdown-toggle no-arrow dt-avatar-wrapper" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="dt-avatar size-30" src="<?php echo base_url('uploads/users_profile/'.$login_user_info['profile_pic']); ?>" alt="Image">
              <span class="dt-avatar-info d-none d-sm-block">
                <span class="dt-avatar-name"><?php echo $login_user_info['full_name']; ?></span>
              </span> </a>
            <!-- /dropdown link -->

            <!-- Dropdown Option -->
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dt-avatar-wrapper flex-nowrap p-6 mt-n2 bg-gradient-purple text-white rounded-top">
                <img class="dt-avatar" src="<?php echo base_url('uploads/users_profile/'.$login_user_info['profile_pic']); ?>" alt="Image">
                <span class="dt-avatar-info">
                  <span class="dt-avatar-name"><?php echo $login_user_info['full_name']; ?></span>
                  <span class="f-12">Administrator</span>
                </span>
              </div>
              <a class="dropdown-item" href="<?php echo base_url('admin/profile'); ?>"> <i class="icon icon-user icon-fw mr-2 mr-sm-1"></i>Profile
              </a> <a class="dropdown-item" href="<?php echo base_url('admin/setting'); ?>">
                <i class="icon icon-settings icon-fw mr-2 mr-sm-1"></i>Setting </a>
              <a class="dropdown-item" href="<?php echo base_url('admin/logout'); ?>"> <i class="icon icon-editors icon-fw mr-2 mr-sm-1"></i>Logout
              </a>
            </div>
            <!-- /dropdown option -->

          </li>
        </ul>
        <!-- /header menu -->
      </div>
      <!-- Header Menu Wrapper -->

    </div>
    <!-- /header toolbar -->

  </div>
  <!-- /header container -->

</header>
<!-- /header -->
            <!-- Site Main -->
            <main class="dt-main">
                <!-- Sidebar -->
<aside id="main-sidebar" class="dt-sidebar">
  <div class="dt-sidebar__container">
    <!-- Sidebar Navigation -->
    <ul class="dt-side-nav">
      <!-- Menu Header -->
        <!-- <span class="dt-side-nav__text">Users</span> -->
     <!--  <li class="dt-side-nav__item dt-side-nav__header">
       <center> <img class="dt-avatar" src="<?php echo base_url('admin_assets/'); ?>images/domnic-harris.jpg" alt="Domnic Harris"><br><br>
        Welcome : <?php echo $login_user_info['full_name']; ?>
      </center>
      </li> -->
      <!-- /menu header -->
      <!-- Menu Item -->
 
          <li id="dashboardnav" class="dt-side-nav__item">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="dt-side-nav__link">
              <i class="icon icon-layout icon-fw icon-lg"></i>
              <span class="dt-side-nav__text">Dashboard</span>
            </a>
          </li>
          <li id="userList" class="dt-side-nav__item">
            <a href="<?php echo base_url('admin/userList'); ?>" class="dt-side-nav__link">
              <i class="icon icon-contacts-app icon-fw icon-lg"></i>
              <span class="dt-side-nav__text">All Users</span>
            </a>
          </li>
           <li id="usersWallet" class="dt-side-nav__item">
            <a href="<?php echo base_url('admin/usersWallet'); ?>" class="dt-side-nav__link">
              <i class="icon icon-revenue-new icon-fw icon-lg"></i>
              <span class="dt-side-nav__text"> Users Wallet </span>
            </a>
          </li>
      <!-- <li id="recent_post" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/dashboard'); ?>" class="dt-side-nav__link">
          <i class="icon icon-metrics icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Recent Post</span>
        </a>
      </li> -->
      <li id="support_request" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/support'); ?>" class="dt-side-nav__link" >
          <i class="icon icon-chat-app2 icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Support Request</span>
        </a>
      </li>
      <li id="transactions" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/transactions'); ?>" class="dt-side-nav__link" >
          <i class="icon icon-revenue-new icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Transactions</span>
        </a>
      </li>
      <li id="nsfw_manage" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/nsfw_manage'); ?>" class="dt-side-nav__link" >
          <i class="icon icon-revenue-new icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">NSFW Manage</span>
        </a>
      </li>
      <li id="project_list" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/project_list'); ?>" class="dt-side-nav__link" >
          <i class="icon icon-list icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Project List</span>
        </a>
      </li>

      <li id="group_list" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/group_list'); ?>" class="dt-side-nav__link" >
          <i class="icon icon-list icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Group List</span>
        </a>
      </li>
      <!-- /menu item -->
      <!-- Menu Header -->
      <li class="dt-side-nav__item dt-side-nav__header">
        <span class="dt-side-nav__text">Settings & Other</span>
      </li>
      <!-- /menu header -->
      <!-- Menu Item -->
      <li id="setting" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/setting'); ?>" class="dt-side-nav__link">
          <i class="icon icon-settings icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Setting</span>
        </a>
      </li>
      <li id="profile" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/profile'); ?>" class="dt-side-nav__link">
          <i class="icon icon-user icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Profile</span>
        </a>
      </li>
       <li id="change_password" class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/change_password'); ?>" class="dt-side-nav__link">
          <i class="icon icon-forgot-pass icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Change Password</span>
        </a>
      </li>
       <li class="dt-side-nav__item">
        <a href="<?php echo base_url('admin/logout'); ?>" class="dt-side-nav__link">
          <i class="icon icon-arrow-right icon-fw icon-lg"></i>
          <span class="dt-side-nav__text">Logout</span>
        </a>
      </li>
        </ul>
        <!-- /sidebar navigation -->
      </div>
    </aside>
<!-- /sidebar -->