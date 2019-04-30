<?php include "./admin_area/includes/db.php"; ?>
<?php $pagetitle = "Geek Gadget"; ?>
<?php include "header.php"; ?>

<?php include "navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include "./shop_sidebar.php"; ?>

        <div class="col-lg-9">
            <?php
            $get_pro = "SELECT * from products";
            $run_pro = mysqli_query($con, $get_pro);
            ?>
            <h1 style="margin-top:40px; padding-bottom:10px; text-align:center">All Products</h1>
            <div class="row">
                <?php
                while ($row_pro = mysqli_fetch_array($run_pro)) {

                    $pro_id = $row_pro['product_id'];
                    $pro_cat = $row_pro['product_cat'];
                    $pro_brand = $row_pro['product_brand'];
                    $pro_title = $row_pro['product_title'];
                    $pro_price = $row_pro['product_price'];
                    $pro_image = $row_pro['product_image'];
                    $pro_desc = $row_pro['product_desc'];

                    echo "
                      <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='card h-100'>
                          <a href='product_detail.php?pro_id=$pro_id''><img class='card-img-top' 
                          src='./admin_area/uploads/product_images/$pro_image' alt=''></a>
                          <div class='card-body'>
                            <h4 class='card-title'>
                              <a href='product_detail.php?pro_id=$pro_id'>$pro_title</a>
                            </h4>
                            <p class='card-text'>$pro_desc</p>
                          </div>
                          <div class='card-footer'>
                          <h5>$$pro_price</h5>
                          </div>
                        </div>
                      </div>
                      ";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</html>