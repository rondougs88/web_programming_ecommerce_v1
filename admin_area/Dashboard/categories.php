<?php include "./admin_panel_header.php"; ?>

<?php
if (isset($_GET['del_cat_id'])) {
    $del_cat_id = $_GET['del_cat_id'];

    // Check first if products exist using this category.
    global $con, $siteroot;

    $get_prod = "SELECT * FROM products WHERE product_cat = '$del_cat_id'";

    $run_q = mysqli_query($con, $get_prod);

    if ($run_q->num_rows > 0) {
        echo "<script>alert('Unable to delete category. There are existing products using this.')</script>";
    } else {
        // Proceed deleting the entry.
        $del_cat = "DELETE FROM categories WHERE cat_id = '$del_cat_id'";
        $run_del_q = mysqli_query($con, $del_cat);
        if ($con->affected_rows > 0) {
            echo "<script>alert('Category successfully deleted.')</script>";
        }
    }
}

if (isset($_POST['create_cat_btn'])) {
    $new_cat = $_POST['new_cat'];
    if (!empty($new_cat)) {
        $insert_cat = "INSERT INTO categories (cat_title) VALUES ('$new_cat')";

        mysqli_query($con, $insert_cat);

        if ($con->affected_rows > 0) {
            echo "<script>alert('New category successfully created.')</script>";
        }
    } else {
        echo "<script>alert('Please provide a category name.')</script>";
    }
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h2>Product categories</h2>

    <form method="post" action="categories.php" style="width:50%">
        <div class="input-group mb-3 lg-6">
            <input type="text" class="form-control" name="new_cat" placeholder="Enter new cateory name">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" name="create_cat_btn" type="button">Create new category</button>
            </div>
        </div>
    </form>

    <div class="table-responsive" style="margin-top:20px; width: 85%">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th width="40%">Product Category</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php get_prod_categories(); ?>
            </tbody>
        </table>
</main>

<?php include "./admin_panel_footer.php"; ?>