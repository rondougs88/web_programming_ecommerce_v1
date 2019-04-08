<?php 
// After uploading to online server, change this connection accordingly

$siteroot = "http://localhost/web_programming_ecommerce_v1";
$include_root = $_SERVER['DOCUMENT_ROOT'] . "/web_programming_ecommerce_v1";

// $con = mysqli_connect("localhost","root","","assignment2_v1");
$con = mysqli_connect("db4free.net","eitwebprog2019","Webprog2019","eitwebprog2019");
// $con = mysqli_connect("root","eitwebprog2019","Webprog2019","eitwebprog2019");

if (mysqli_connect_errno())
  {
  echo "Check internet connection / Remote database is down: " . mysqli_connect_error();
  }


?>