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
                        
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                                <img src="<?=base_url('backend/images/super-admin.png')?>" height="700px" alt="Login V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Welcome to Dietaholics! 👋</h2>
                                <form class="auth-login-form mt-2" accept-charset="utf-8" method="post" action="<?= base_url('driver/login') ?>" id="LoginForm">
                                    <div class="mb-1">
                                        <label class="form-label" for="login-email"><?= lang('Admin.email_id') ?></label>
                                        <input class="form-control" name="useremail" id="useremail" type="text" name="login-email" placeholder="<?= lang('Admin.enter_email_id') ?>" value="<?= set_value('useremail') ?>" aria-describedby="login-email" autofocus="" tabindex="1" required />
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password"><?= lang('Admin.password') ?></label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" name="password" id="password" placeholder="<?= lang('Admin.enter_password') ?>" value="<?= set_value('password') ?>" type="password" aria-describedby="login-password" tabindex="2" required /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        
                                        <div class="d-flex justify-content-between">
                                            <a class="login-anchor" href="<?= base_url('admin/forgot-password') ?>"><small><?= lang('Admin.forget_password') ?>?</small></a>
                                        </div>   
                                        
                                    </div>
                                    <button class="btn btn-primary w-100" tabindex="4"><?= lang('Admin.login') ?></button>
                                </form>
                                
                        </div>
                        <!-- /Login-->
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
    <script src="<?=base_url('backend/js/design/auth-login.js')?>"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>