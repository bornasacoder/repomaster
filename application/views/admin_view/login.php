<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Drift - A fully responsive, HTML5 based admin template">
<meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
<!-- /meta tags -->
<title> Freedomcell - Admin</title>

<!-- Site favicon -->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- /site favicon -->

<!-- Font Icon Styles -->
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/styles.css">
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/flag-icon.min.css">
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/styles_1.css">
<!-- /font icon Styles -->

<!-- Perfect Scrollbar stylesheet -->
<link rel="stylesheet" href="<?php echo base_url('admin_assets/'); ?>css/perfect-scrollbar.css">
<!-- /perfect scrollbar stylesheet -->


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
<body background="<?php echo base_url('admin_assets/bg_banner_img.png'); ?>">
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
            <div class="dt-login--container">

    <!-- Login Content -->
    <div class="dt-login__content-wrapper">

        <!-- Login Background Section -->
        <div class="dt-login__bg-section">

            <div class="dt-login__bg-content">
                <!-- Login Title -->
                <h1 class="dt-login__title">Login</h1>
                <!-- /login title -->

                <p class="f-16">Sign in to start your session.</p>
            </div>


            <!-- Brand logo -->
            <div class="dt-login__logo">
                <a class="dt-brand__logo-link" href="<?php echo base_url('admin'); ?>">
                    <img class="dt-brand__logo-img" src="<?php echo base_url('admin_assets/'); ?>logo_freedom_white.png" alt="Drift" style="width: 200px;">
                </a>
            </div>
            <!-- /brand logo -->

        </div>
        <!-- /login background section -->

        <!-- Login Content Section -->
        <div class="dt-login__content">
            
            <!-- Login Content Inner -->
            <div class="dt-login__content-inner">
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php elseif($this->session->flashdata('error')): ?>
<div class="alert alert-error alert-dismissible" role="alert">
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>
                <!-- Form -->
                <form action="" method="POST">

                    <!-- Form Group -->
                    <div class="form-group">
                        <label class="sr-only" for="email-1">Email address</label>
                        <input type="email" class="form-control" id="email-1" aria-describedby="email-1" placeholder="Enter email" autocomplete="off" name="email" required="">
                    </div>
                    <!-- /form group -->

                    <!-- Form Group -->
                    <div class="form-group">
                        <label class="sr-only" for="password-1">Password</label>
                        <input type="password" class="form-control" id="password-1" placeholder="Password" name="password" autocomplete="off" required="">
                    </div>
                    <!-- /form group -->

                    <!-- Form Group -->
                    <!-- <div class="dt-checkbox d-block mb-6">
                        <input type="checkbox" id="checkbox-1">
                        <label class="dt-checkbox-content" for="checkbox-1">
                            Keep me login on this device
                        </label>
                    </div> -->
                    <!-- /form group -->

                    <!-- Form Group -->
                    <div class="form-group">
                        <button type="submit" name="login_now" class="btn btn-primary text-uppercase">Login</button>
                        <!-- <span class="d-inline-block ml-4">
                            <a class="d-inline-block font-weight-500 ml-3" href="page-signup.html">Forgot Password</a>
                        </span> -->
                    </div>
                    <!-- /form group -->

                    <!-- Form Group -->

        <!--             <div class="d-flex flex-wrap align-items-center">
                        <span class="d-inline-block mr-2">Or connect with</span>

                        <ul class="dt-list dt-list-sm dt-list-cm-0 ml-auto">
                            <li class="dt-list__item">
                                <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                    <i class="icon icon-facebook icon-xl"></i>
                                </a>
                            </li>

                            <li class="dt-list__item">
                                <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                    <i class="icon icon-google-plus icon-xl"></i>
                                </a>
                            </li>

                            <li class="dt-list__item">
                                <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                    <i class="icon icon-github icon-xl"></i>
                                </a>
                            </li>

                            <li class="dt-list__item">
                                <a href="javascript:void(0)" class="btn btn-outline-primary dt-fab-btn size-30">
                                    <i class="icon icon-twitter icon-xl"></i>
                                </a>
                            </li>
                        </ul>
                    </div> -->

                    <!-- /form group -->


                </form>
                <!-- /form -->

            </div>
            <!-- /login content inner -->

            <!-- Login Content Footer -->
            <div class="dt-login__content-footer">
                <a href="<?php echo base_url('admin/forgot_password'); ?>">Forgot Password ?</a>
            </div>
            <!-- /login content footer -->

        </div>
        <!-- /login content section -->

    </div>
    <!-- /login content -->

</div>        </div>        
    </div>
    <!-- /root -->

    <!-- masonry script -->
<script src="<?php echo base_url('admin_assets/'); ?>js/masonry.pkgd.min.js"></script>
<script src="<?php echo base_url('admin_assets/'); ?>js/sweetalert2.js"></script>
<script src="<?php echo base_url('admin_assets/'); ?>js/functions.js"></script>
<script src="<?php echo base_url('admin_assets/'); ?>js/customizer.js"></script>

<script src="<?php echo base_url('admin_assets/'); ?>js/script.js"></script>
</body>
</html>