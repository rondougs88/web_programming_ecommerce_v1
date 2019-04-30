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
            $cat_id = $_GET['cat'];
            $get_pro = "SELECT * from categories INNER JOIN products ON products.product_cat = categories.cat_id WHERE cat_id = '$cat_id' ";
            $run_pro = mysqli_query($con, $get_pro);
            $get_cat_title = "SELECT * FROM categories WHERE cat_id = '$cat_id'";
            $run_cat_title = mysqli_query($con, $get_cat_title);
            while ($row_title = mysqli_fetch_array($run_cat_title)) {
                $cat_title = $row_title['cat_title'];
            }
            ?>
            <h1 style="margin-top:40px; padding-bottom:10px; text-align:center"><?= $cat_title ?></h1>
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