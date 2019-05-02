<?php include "./admin_panel_header.php"; ?>

<?php
if (isset($_GET['del_brand_id'])) {
    $del_brand_id = $_GET['del_brand_id'];

    // Check first if products exist using this brand.
    global $con, $siteroot;

    $get_prod = "SELECT * FROM products WHERE product_brand = '$del_brand_id'";

    $run_q = mysqli_query($con, $get_prod);

    if ($run_q->num_rows > 0) {
        echo "<script>alert('Unable to delete brand. There are existing products using this.')</script>";
    } else {
        // Proceed deleting the entry.
        $del_brand = "DELETE FROM brands WHERE brand_id = '$del_brand_id'";
        $run_del_q = mysqli_query($con, $del_brand);
        if ($con->affected_rows > 0) {
            echo "<script>alert('Brand successfully deleted.')</script>";
        }
    }
}

if (isset($_POST['create_brand_btn'])) {
    $new_brand = $_POST['new_brand'];
    if (!empty($new_brand)) {
        $insert_brand = "INSERT INTO brands (brand_title) VALUES ('$new_brand')";

        mysqli_query($con, $insert_brand);

        if ($con->affected_rows > 0) {
            echo "<script>alert('New brand successfully created.')</script>";
        }
    } else {
        echo "<script>alert('Please provide a brand name.')</script>";
    }
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h2>Product brands</h2>

    <form method="post" action="brands.php" style="width:50%">
        <div class="input-group mb-3 lg-6">
            <input type="text" class="form-control" name="new_brand" placeholder="Enter new brand name">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" name="create_brand_btn" type="button">Create new brand</button>
            </div>
        </div>
    </form>

    <div class="table-responsive" style="margin-top:20px; width: 85%">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th width="40%">Product Brand</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php get_prod_brands(); ?>
            </tbody>
        </table>
</main>

<?php include "./admin_panel_footer.php"; ?>