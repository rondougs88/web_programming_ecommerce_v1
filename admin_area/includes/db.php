<?php 
// After uploading to online server, change this connection accordingly

$con = mysqli_connect("localhost","root","","assignment2_v1");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


?>