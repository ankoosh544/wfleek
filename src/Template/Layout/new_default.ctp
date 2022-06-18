<?php

use Cake\I18n\Number;
use Cake\I18n\Time;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>EPEBOOK</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="/assets/plugins/morris/morris.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="/assets/plugins/summernote/dist/summernote-bs4.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!--- <link rel="stylesheet" href="/assets/css/fullcalendar.min.css">--->
    <link href='/assets/fullcalendar/main.css' rel='stylesheet' />
    <!---jQuery ----
    <script src="/assets/js/jquery-3.5.1.min.js"></script>--->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>
    <script src="/js/notify.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header Menu -->
        <?= $this->element('header_menu') ?>
        <!-- /Header Menu -->



        <!-- Sidebar -->
        <?= $this->element('sidebar', [
            'authorizeduser' => $authorizeduser
        ]) ?>
        <!-- /Sidebar -->



        <?= $this->Flash->render() ?>
        <?= $this->fetch("content") ?>


    </div>



    <!-- Bootstrap Core JS -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="/assets/js/jquery.slimscroll.min.js"></script>
    <!-- Select2 JS ---->
    <script src="/assets/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!-- Datetimepicker JS -->
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Summernote JS -->
    <script src="/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
    <!-- Datatable JS ---->
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap4.min.js"></script>
    <!-- Custom JS ---->
    <script src="/assets/js/app.js"></script>
    <!-- Calendar JS --->
    <script src="/assets/fullcalendar/main.js"></script>
</body>

</html>
