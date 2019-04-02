<!DOCTYPE html>
<html lang="en">

<?php 
include "./admin_area/includes/db.php"; 
include "./functions/functions.php"; 
?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Details</title>

    <?php include "styles.php"; ?>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="./css/product_detail.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
    <?php include "navigation.php"; ?>
    <?php getPro(); ?>

</body>

</html> 