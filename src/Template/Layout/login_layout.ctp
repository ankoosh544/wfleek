<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $this->fetch('title') ?> - WFleek</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">




    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Bootstrap Core JS -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
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
    <script src="/js/notify.min.js"></script>
</head>

<body class="account-page">
    <?= $this->Flash->render() ?>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?= $this->fetch('content') ?>
    </div>
</body>

</html>
