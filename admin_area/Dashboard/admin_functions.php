<?php

$eu_username = "";
$eu_fname = "";
$eu_lname = "";
$eu_usertype = "";
$eu_email = "";

function get_users() 
{
   
    global $con;

        $get_users = "SELECT * from users";

        $run_q = mysqli_query($con, $get_users);

        while ($row_user = mysqli_fetch_array($run_q)) {

            $userid = $row_user['id'];
            $username = $row_user['username'];
            $email = $row_user['email'];
            $user_type = $row_user['user_type'];
            $fname = $row_user['fname'];
            $lname = $row_user['lname'];

            echo "
                <tr>
                    <td>$username</td>
                    <td>$fname $lname</td>
                    <td>$email</td>
                    <td>$user_type</td>
                    
                    <td><a href='./edit_user.php?userid=$userid'>Edit</a></td>
                </tr>
            ";
        }

}

function set_user_details($userid) {

    global $con, $eu_username,  $eu_email, $eu_user_type, $eu_fname, $eu_lname;

        $get_user = "SELECT * from users WHERE id = '$userid'";

        $run_q = mysqli_query($con, $get_user);

        while ($row_user = mysqli_fetch_array($run_q)) {

            // $userid = $row_user['id'];
            $eu_username = $row_user['username'];
            $eu_email = $row_user['email'];
            $eu_user_type = $row_user['user_type'];
            $eu_fname = $row_user['fname'];
            $eu_lname = $row_user['lname'];

        }
}

function get_orders()
{
    global $con;

    $get_orders = "SELECT from  order_items.*,
                                order_header.*,
                                products.*,
                    FROM order_items
                            INNER JOIN order_header ON order_items.order_id = order_header.order_id,
                            INNER JOIN products ON order_items.p_id = products.product_id";

    $run_query = mysqli_query($con, $get_orders);

    while ($row_order = mysqli_fetch_array($run_query)) {
        $order = $row_order['order_id'];
        $date = $row_order['inserted_on'];
        $status = $row_order['status'];
        $total= $row_order['product_price'];

    echo "
                <tr>
                    <td>$order</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$total</td>
                </tr>
        ";
    }

}