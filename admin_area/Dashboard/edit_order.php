<?php include "./admin_panel_header.php"; ?>
<?php
$id="";
if (isset($_GET['order']))
{
    global $id;
    $id =$_GET['order'];
    $res=mysql_query("SELECT * FROM order_header");
    $row=mysql_fetch_array($res);
}
?>

<main role="main" class="col-md-5 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="row justify-content-left">
        <div class="card col-md-2" style="margin-bottom:20px;  background-color:burlywood">
            <h4 style="padding-top:20px">Order <?php global $id; echo $id; ?> </h4>
        </div>
    </div>  
</main>
















<?php include "./admin_panel_footer.php"; ?>
