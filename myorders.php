<?php include "./admin_area/includes/db.php"; ?>

<?php $pagetitle = "My Orders"; ?>
<?php include "header.php"; ?>

<?php include "navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row justify-content-center">
        <h2 style="margin-top:20px">My Orders</h2>
        <!-- <button class="btn btn-primary" id="admin_create_user">Create user</button> -->
        <div class="table-responsive" style="margin-top:20px">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Order no.</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php get_my_orders(); ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include "footer.php"; ?>

</html>