<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= urldecode($settings['website_name']) ?></title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="<?= base_url('backend/css/lib/font-awesome.min.css') ?>" rel="stylesheet">

    <link href="<?= base_url('backend/css/lib/themify-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/owl.carousel.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/owl.theme.default.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/weather-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/mmc-chat.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/sidebar.css') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="<?= base_url('backend/css/lib/unix.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/data-table/buttons.bootstrap.min.css') ?>" rel="stylesheet">
    <link href="//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= base_url('backend/css/lib/sweetalert/sweetalert.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <?php if ($session->lang_short == "ar") { ?>
        <link href="<?= base_url('backend/css/arabic.css') ?>" rel="stylesheet">

    <?php  } ?>
    <script src="<?= base_url('backend/js/jquery-3.3.1.min.js') ?>"></script>
 
    <style>
        form .error {
            color: #FA001A;
        }

        .radio-custom label {
            position: absolute;
            top: 23px;
            left: 15px;
        }

        .date-custom label {
            width: 100%;
            position: absolute;
            top: 43px;
            left: 0;
        }

        .image-custom label {
            position: absolute;
            top: 32px;
            float: left;
            left: -550px;
            font-size: 14px;
            font-weight: 400;
            font-family: 'Montserrat', sans-serif;
        }

        .fileuploadvalid {
            display: none
        }
    </style>
</head>

<body>