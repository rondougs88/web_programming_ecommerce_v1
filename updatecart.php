<?php
include "./admin_area/includes/db.php";
include "./functions/functions.php";

if (isset($_POST['update_cart'])) {
    global $con, $siteroot;
    $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();
    foreach ($_POST['update_cart'] as $item) {
        $qty = $item["qty"];
        $prod_id = $item["prod_id"];
        $delete = $item["delete"];
        if ($delete === "false") {
            $set_upd = "UPDATE cart SET qty = '$qty' WHERE username = '$uname' AND p_id = '$prod_id'";
        } else {
            $set_upd = "DELETE FROM cart WHERE username = '$uname' AND p_id = '$prod_id'";
        }
        $run_q = mysqli_query($con, $set_upd);
    }
    echo "Your cart has been updated.";
}
