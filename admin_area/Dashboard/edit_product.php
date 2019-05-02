<?php include "./admin_panel_header.php"; ?>
<!-- Custom styles for this template -->
<link href="../../css/insert_product.css" rel="stylesheet">

<!-- Script for Text area input -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>

<?php
if (!isLoggedIn() || !isAdmin()) {
    echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
    exit();
}
?>

<?php
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} elseif (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
}
// Get all product details
global $con;

$get_product = "SELECT products.*, products_inventory.*, products_inventory.qty as available_qty from products INNER JOIN categories ON categories.cat_id = products.product_cat INNER JOIN brands ON brands.brand_id = products.product_brand INNER JOIN products_inventory ON products_inventory.product_id = products.product_id WHERE products.product_id = '$product_id'";

$run_q = mysqli_query($con, $get_product);

while ($row_prod = mysqli_fetch_array($run_q)) {

    $product_title = $row_prod['product_title'];
    $product_cat = $row_prod['product_cat'];
    $product_brand = $row_prod['product_brand'];
    $product_price = $row_prod['product_price'];
    $product_desc = $row_prod['product_desc'];
    $product_image = $row_prod['product_image'];
    $available_qty = $row_prod['available_qty'];
    $product_keywords = $row_prod['product_keywords'];
}

// Get product images
$get_product_img = "SELECT * from product_images WHERE product_id = '$product_id'";

$run_q_img = mysqli_query($con, $get_product_img);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <form action="./edit_product.php?product_id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
        <h2 style="text-align:center">Edit Product</h2>

        <table class="table" align="center" width="795">
            <tr>
                <td align="right"><b>Product id:</b></td>
                <td>
                    <input type="text" name="product_id" id="product_id" style="width: 100px;" class="form-control" disabled value="<?= $product_id ?>">
                </td>
            </tr>
            <tr>
                <td align="right"><b>Product Title:</b></td>
                <td>
                    <input type="text" name="product_title" id="protitle" size="60" class="form-control" value="<?= $product_title ?>" required>
                </td>
            </tr>
            <tr>
                <td align="right"><b>Product Category:</b></td>
                <td>
                    <select name="product_cat">
                        <option>Select a Category</option>
                        <?php
                        $get_cats = "select * from categories";

                        $run_cats = mysqli_query($con, $get_cats);

                        while ($row_cats = mysqli_fetch_array($run_cats)) {

                            $cat_id = $row_cats['cat_id'];
                            $cat_title = $row_cats['cat_title'];

                            if ($product_cat == $cat_id) {
                                echo "<option selected value='$cat_id'>$cat_title</option>";
                            } else {
                                echo "<option value='$cat_id'>$cat_title</option>";
                            }
                        }

                        ?>
                    </select>


                </td>
            </tr>

            <tr>
                <td align="right"><b>Product Brand:</b></td>
                <td>
                    <select name="product_brand">
                        <option>Select a Brand</option>
                        <?php
                        $get_brands = "select * from brands";

                        $run_brands = mysqli_query($con, $get_brands);

                        while ($row_brands = mysqli_fetch_array($run_brands)) {

                            $brand_id = $row_brands['brand_id'];
                            $brand_title = $row_brands['brand_title'];
                            if ($product_brand == $brand_id) {
                                echo "<option selected value='$brand_id'>$brand_title</option>";
                            } else {
                                echo "<option value='$brand_id'>$brand_title</option>";
                            }
                        }

                        ?>
                    </select>


                </td>
            </tr>

            <tr>
                <td align="right"><b>Primary Product Image:</b></td>
                <td align="left"><img src='<?= $siteroot ?>/admin_area/uploads/product_images/<?= $product_image ?>' border=3 width=100></img></td>
            </tr>

            <tr>
                <td align="right"><b>Change Primary Product Image:</b></td>
                <td><input type="file" name="product_image"></td>
            </tr>

            <tr>
                <td align="right"><b>Product Images:</b></td>
                <td align='left'>
                    <?php while ($row_prod_img = mysqli_fetch_array($run_q_img)) {
                        $img = $row_prod_img['image_name'];
                        echo "<img src='$siteroot/admin_area/uploads/product_images/$img' border=3 width=100></img>";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td align="right"><b> Change Product Images:</b></td>
                <td><input type="file" name="product_images[]" multiple></td>
            </tr>

            <tr>
                <td align="right"><b>Product Price:</b></td>
                <td><input type="number" name="product_price" value="<?= $product_price ?>" required /></td>
            </tr>

            <tr>
                <td align="right"><b>Available Quantity:</b></td>
                <td><input type="number" name="product_qty" value="<?= $available_qty ?>" required /></td>
            </tr>

            <tr>
                <td align="right"><b>Product Description:</b></td>
                <td><textarea name="product_desc" cols="20" rows="10"><?= $product_desc ?></textarea></td>
            </tr>

            <tr>
                <td align="right"><b>Product Keywords:</b></td>
                <td><input type="text" value="<?= $product_keywords ?>" name="product_keywords" size="50" required /></td>
            </tr>

            <tr>
                <td align="center" colspan="7">
                    <button type="submit" class="btn btn-primary" id="edit_prod_btn" name="edit_prod_btn">Save changes</button>
                    <span class="float-right">
                        <button type="float-right" class="btn btn-danger" id="del_prod_btn" name="del_prod_btn">Delete product</button>
                    </span>
                </td>
            </tr>

        </table>


    </form>
</main>


<?php include "./admin_panel_footer.php"; ?>

<?php
if (isset($_POST['edit_prod_btn'])) {

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $targetDir = "../uploads/product_images/";

    //getting the text data from the fields
    $product_id = $_GET['product_id'];
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_brand = $_POST['product_brand'];
    $product_price = $_POST['product_price'];
    $product_qty = $_POST['product_qty'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];
    $product_keywords = $_POST['product_keywords'];
    // $inserted_on = date("Y-m-d H:i:s");
    $last_id = '';

    // Get the highest id number from products table
    $get_last_id = "SELECT product_id FROM products ORDER BY product_id DESC LIMIT 0, 1";
    $run_q = mysqli_query($con, $get_last_id);
    if (mysqli_num_rows($run_q) > 0) {
        while ($row_pro = mysqli_fetch_array($run_q)) {
            $last_id = number_format($row_pro['product_id']) + 1;
        }
    }
    if (empty($last_id)) {
        $last_id = 1;
    }

    //getting the image from the field
    if (isset($_FILES['product_image']['tmp_name'])) {
        $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $product_image = "image_" . $last_id . '.' . $ext;
        $product_image_tmp = $_FILES['product_image']['tmp_name'];

        move_uploaded_file($product_image_tmp, $targetDir . $product_image);
        $update_product = "UPDATE products SET product_image='$product_image'"
            . "WHERE product_id = '$product_id'";

        mysqli_query($con, $update_product);
    }

    $update_product = "UPDATE products SET product_cat = '$product_cat', product_brand = '$product_brand',product_title = '$product_title',product_price = '$product_price',product_desc='$product_desc',product_keywords='$product_keywords'"
        . " WHERE product_id = '$product_id'";

    $update_pro = mysqli_query($con, $update_product);

    // $prod_id = $con->insert_id;

    // Update product inventory
    $update_product_qty = "UPDATE products_inventory SET qty = '$product_qty' WHERE product_id = '$product_id'";

    mysqli_query($con, $update_product_qty);

    // Process the product images being uploaded
    if (!empty(array_filter($_FILES['product_images']['name']))) {
        // Delete images
        $del_img = "DELETE FROM product_images WHERE product_id = '$product_id'";
        mysqli_query($con, $del_img);

        foreach ($_FILES['product_images']['name'] as $key => $val) {
            // File upload path
            // $fileName = basename($_FILES['product_images']['name'][$key]);
            // $targetFilePath = $targetDir . $fileName;

            $ext = pathinfo($_FILES['product_images']['name'][$key], PATHINFO_EXTENSION);
            $fileName = "image" . $key . "_" . $last_id . '.' . $ext;

            // Check whether file type is valid
            // $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($ext, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["product_images"]["tmp_name"][$key], $targetDir . $fileName)) {
                    // Image db insert sql
                    // $insertValuesSQL .= "('" . $fileName . "', NOW()),";
                    $insert_images = "INSERT into product_images (product_id, image_name) values ('$product_id', '$fileName')";
                    mysqli_query($con, $insert_images);
                } else {
                    $errorUpload .= $_FILES['product_images']['name'][$key] . ', ';
                }
            } else {
                $errorUploadType .= $_FILES['product_images']['name'][$key] . ', ';
            }
        }
    }

    echo "<script>alert('Product has been updated!')</script>";
    echo "<script>window.open('edit_product.php?product_id=$product_id','_self')</script>";
} elseif (isset($_POST['del_prod_btn'])) { 
    // Update product inventory
    $del_product = "DELETE FROM products WHERE product_id = '$product_id'";
    mysqli_query($con, $del_product);
    echo "<script>alert('Product has been deleted!')</script>";
    echo "<script>window.open('view_products.php','_self')</script>";
}
?>