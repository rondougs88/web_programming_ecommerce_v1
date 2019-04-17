<?php include "../includes/db.php"; ?>
<?php include_once "../../functions/functions.php"; ?>
<?php include "./admin_functions.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">
    <link href="../../css/admin_panel.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <!-- This is placed in the header so the js for navigation will work even if the page is skipped. -->
    <script src="<?= $siteroot ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $siteroot ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admin_panel.js"></script>
</head>

<body>
    <div class="json-overlay">
        <div class="spinner-border text-primary loading" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= $siteroot ?>">Geek Gadget</a>
        <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="<?= $siteroot ?>/index.php?logout='1'">Sign out</a>
            </li>
        </ul>
    </nav>

    <?php include "./sidebar.php" ?>