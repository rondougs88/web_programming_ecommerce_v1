<?php include "./admin_panel_header.php"; ?>
<?php
 $id="";
if (isset($_GET['order']))
{
     global $id, $con;
     $id = $_GET['order'];
     $get_order= "SELECT * FROM order_header where id='$id'";
     $res= mysqli_query($con, $get_order);
     while ($row_order = mysqli_fetch_array($res)) {
        $order_status = $row_order['status'];
        $order_email = $row_order['email'];
        $order_user = $row_order['username'];
        $order_date = $row_order['created_on'];

         //billing
         $order_bfname = $row_order['fname'];
         $order_blname = $row_order['lname'];         
         $order_baddress1 = $row_order['address1'];
         $order_bcountry = $row_order['country'];
         $order_bstate = $row_order['state_c'];
         $order_bzip = $row_order['zip'];

        //shipping
         $order_shfname = $row_order['sh_fname'];
         $order_shlname = $row_order['sh_lname'];         
         $order_shaddress1 = $row_order['sh_address1'];
         $order_shcountry = $row_order['sh_country'];
         $order_shstate = $row_order['sh_state_c'];
         $order_shzip = $row_order['sh_zip'];
        
     }
}
?>

<main role="main" class="col-md-5 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="row justify-content-left">
        <div class="card col-md-3" style="margin-bottom:20px;  background-color:burlywood">
            <h4 style="padding-top:20px">Order <?php echo $id; ?> Details </h4>
        </div>
        <h5 style="padding-top:20px">General<br> <?php echo $order_date; ?> </h5>

    </div>  
</main>
















<?php include "./admin_panel_footer.php"; ?>
