<?php include "./admin_panel_header.php" ?>

<?php
if (!isLoggedIn() || !isAdmin()) {
    echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
    exit();
}
if (isset($_SESSION['success'])) {
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
    echo '<script type="text/javascript">alert("' . $msg . '");</script>';
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <h2>Products</h2>
    <!-- <button class="btn btn-primary" id="admin_create_user">Create user</button> -->
    <div class="table-responsive" style="margin-top:20px">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th style="width: 5%"></th>
                    <th>Product Title</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php get_products(); ?>
            </tbody>
        </table>
</main>

<?php include "./admin_panel_footer.php"; ?>