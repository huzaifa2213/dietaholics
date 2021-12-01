<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Dietaholics</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/bootstrap.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/bootstrap-extended.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/colors.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/components.css')?>">
    
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/form-validation.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/css/design/authentication.css')?>">
    <!-- END: Page CSS-->

   
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

 <!-- BEGIN: Content-->
 <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                            <img src="<?=base_url('backend/images/super-admin.png')?>" height="700px" alt="Forgot password V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Forgot password-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1"><?= lang('Admin.forget_password') ?> 🔒</h2>
                                <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>
                                <form class="auth-forgot-password-form mt-2" accept-charset="utf-8" method="post" action="<?= base_url('admin/forgot-password'); ?>">
                                    <div class="mb-1">
                                        <label class="form-label" for="forgot-password-email"><?= lang('Admin.email_id') ?></label>
                                        <input class="form-control" id="forgot-password-email" type="text" name="email" placeholder="<?= lang('Admin.enter_email_id') ?>" value="<?= set_value('email') ?>" aria-describedby="forgot-password-email" autofocus="" tabindex="1" required />
                                    </div>
                                    <button class="btn btn-primary w-100" tabindex="2"><?= lang('Admin.send') ?></button>
                                </form>
                                <p class="text-center mt-2"><a class="login-anchor" href="<?=base_url('admin/login')?>"><i data-feather="chevron-left"></i> <?= lang('Admin.back_to_login') ?>?</a></p>
                            </div>
                        </div>
                        <!-- /Forgot password-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

     <!-- BEGIN: Vendor JS-->
     <script src="<?=base_url('backend/js/design/vendors.min.js')?>"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=base_url('backend/js/design/jquery.validate.min.js')?>"></script>
    <!-- END: Page Vendor JS-->

    <script src="<?=base_url('backend/js/design/app.js')?>"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=base_url('backend/js/design/auth-forgot-password.js')?>"></script>
    <!-- END: Page JS-->

</body>

</html>