<?php include $include_root . "/functions/functions.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $pagetitle ?></title>

    <!-- Font awesome include -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="<?= $siteroot; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Common styles for this website -->
    <link href="<?= $siteroot; ?>/css/shop-homepage.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <!-- This is placed in the header so the js for navigation will work even if the page is skipped. -->
    <script src="<?= $siteroot ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $siteroot ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- This js plugin needs to be loaded for validation. -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?= $siteroot ?>/js/myscripts.js"></script>

    <!-- Pass variable to js for the items count for the cart. -->
    <script type="text/javascript">
        var cart_count = "<?= $cart_count ?>";
        var siteroot = "<?= $siteroot ?>";
    </script>
