<?php include "../includes/db.php"; 
if(isset($_POST['edit_order_btn'])){
        $id=$_POST['order_id'];
        $order_status = $_POST['status'];
        $order_email = $_POST['email'];
        // $order_user = $_POST['username'];
        // $order_date = $_POST['created_on'];
        $order_phone= $_POST['phone'];

        //billing
        $order_bfname = $_POST['firstName'];
        $order_blname = $_POST['lastName'];
        $order_baddress1 = $_POST['address'];
        $order_baddress2 = $_POST['address2'];
        $order_bcountry = $_POST['country'];
        $order_bstate = $_POST['state'];
        $order_bzip = $_POST['zip'];

        //shipping
        $order_shfname = $_POST['sh_firstName'];
        $order_shlname = $_POST['sh_lastName'];
        $order_shaddress1 = $_POST['sh_address'];
        $order_shaddress2 = $_POST['sh_address2'];
        $order_shcountry = $_POST['sh_country'];
        $order_shstate = $_POST['sh_state'];
        $order_shzip = $_POST['sh_zip'];
        $update="UPDATE order_header set status = '$order_status', email='$order_email', phone='$order_phone',
        fname='$order_bfname', lname='$order_blname', address1='$order_baddress1', address2='$order_baddress2', country='$order_bcountry', state_c='$order_bstate', zip='$order_bzip', 
        sh_fname='$order_shfname', sh_lname='$order_shlname', sh_address1='$order_shaddress1', sh_address2='$order_shaddress2', sh_country='$order_shcountry', sh_state_c='order_shstate', sh_zip='$order_shzip' WHERE order_id='$id'";
            mysqli_query($con, $update);
            if(empty($con->error)){
                // header("location:$siteroot/admin_area/Dashboard/edit_order.php?order=$id");
                echo "<script> alert('Order has been Updated.') </script>";
                

            }
}
?>