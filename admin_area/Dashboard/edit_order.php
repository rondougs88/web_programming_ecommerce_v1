<?php include "./admin_panel_header.php"; ?>
<?php include "../includes/db.php";
if (isset($_POST['edit_order_btn'])) {
    $id = $_POST['order_id'];
    $order_status = $_POST['status'];
    $order_email = $_POST['email'];
    // $order_user = $_POST['username'];
    // $order_date = $_POST['created_on'];
    $order_phone = $_POST['phone'];

    //billing
    $order_bfname = $_POST['firstName'];
    $order_blname = $_POST['lastName'];
    $order_baddress1 = $_POST['address'];
    $order_baddress2 = $_POST['address2'];
    $order_bcountry = $_POST['country'];
    $order_bstate = mysqli_real_escape_string($con, $_POST['state']);
    $order_bzip = $_POST['zip'];

    //shipping
    $order_shfname = $_POST['sh_firstName'];
    $order_shlname = $_POST['sh_lastName'];
    $order_shaddress1 = $_POST['sh_address'];
    $order_shaddress2 = $_POST['sh_address2'];
    $order_shcountry = $_POST['sh_country'];
    $order_shstate = mysqli_real_escape_string($con, $_POST['sh_state']);
    $order_shzip = $_POST['sh_zip'];
    $update = "UPDATE order_header set status = '$order_status', email='$order_email', phone='$order_phone',
        fname='$order_bfname', lname='$order_blname', address1='$order_baddress1', address2='$order_baddress2', country='$order_bcountry', state_c='$order_bstate', zip='$order_bzip', 
        sh_fname='$order_shfname', sh_lname='$order_shlname', sh_address1='$order_shaddress1', sh_address2='$order_shaddress2', sh_country='$order_shcountry', sh_state_c='$order_shstate', sh_zip='$order_shzip' WHERE order_id='$id'";
    mysqli_query($con, $update);
    if (empty($con->error)) {
        // header("location:$siteroot/admin_area/Dashboard/edit_order.php?order=$id");
        echo "<script> alert('Order has been Updated.') </script>";
    }
}
?>
<?php
$id = "";
if (isset($_GET['order'])) {
    global $id, $con;
    $id = $_GET['order'];
    // $get_order = "SELECT * FROM order_header where order_id='$id'";
    $get_order = "SELECT order_items.*,
                                order_header.*,
                                products.*
                    FROM order_items
                            INNER JOIN order_header ON order_items.order_id = order_header.order_id
                            INNER JOIN products ON order_items.p_id = products.product_id WHERE order_header.order_id = '$id'";
    $res = mysqli_query($con, $get_order);
    while ($row_order = mysqli_fetch_array($res)) {
        $items[] = $row_order;
        $order_status = $row_order['status'];
        $order_email = $row_order['email'];
        $order_user = $row_order['username'];
        $order_date = $row_order['created_on'];
        $order_date_frmt = new DateTime($order_date);
        $order_phone = $row_order['phone'];

        //billing
        $order_bfname = $row_order['fname'];
        $order_blname = $row_order['lname'];
        $order_baddress1 = $row_order['address1'];
        $order_baddress2 = $row_order['address2'];
        $order_bcountry = $row_order['country'];
        $order_bstate = $row_order['state_c'];
        $order_bzip = $row_order['zip'];

        //shipping
        $order_shfname = $row_order['sh_fname'];
        $order_shlname = $row_order['sh_lname'];
        $order_shaddress1 = $row_order['sh_address1'];
        $order_shaddress2 = $row_order['sh_address2'];
        $order_shcountry = $row_order['sh_country'];
        $order_shstate = $row_order['sh_state_c'];
        $order_shzip = $row_order['sh_zip'];
    }
}
?>

<?php if (isset($_GET['order'])) : ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="py-5 text-center">
            <!-- <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
            <h2>Order GG-<?php echo $id ?></h2>
            <h4> Created on: <?php echo $order_date_frmt->format('Y-m-d') ?></h4>
            <!-- <p class="lead">Please fill out the details below to edit order..</p> -->
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill"><?= cart_items_count() ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <!-- Display the cart items in this page. -->
                    <?php
                    global $total_price;
                    for ($i = 0; $i < count($items); $i++) {
                        $pro_title = $items[$i]['product_title'];
                        $pro_price = $items[$i]['product_price'];
                        $pro_qty = $items[$i]['qty'];
                        $sub_total = $pro_qty * $pro_price;
                        $total_price += $pro_price * $pro_qty;
                        $pro_price = number_format($pro_price, 2); // Format this to have 2 decimal places.
                        $sub_total = number_format($sub_total, 2); // Format this to have 2 decimal places.
                        echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>
                            <div>
                                <h6 class='my-0'>$pro_title</h6>
                                <small class='text-muted'>$pro_qty x $$pro_price</small>
                            </div>
                            <span class='text-muted'>$$sub_total</span>
                            </li>";
                    }
                    ?>
                    <li class='list-group-item d-flex justify-content-between lh-condensed'>
                        <div>
                            <h6 class='my-0'>Shipping</h6>
                            <small class='text-muted'>Free Shipping</small>
                        </div>
                        <span class='text-muted'>$0.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>$<?= get_cart_total_price() ?></strong>
                    </li>
                </ul>


            </div>
            <div class="col-md-8 order-md-1">

                <form class="needs-validation" method="post" id="edit_order-form" action="./edit_order.php?order=<?= $id ?>" novalidate>
                    <h4 class="mb-3">Order Status</h4>
                    <div class="form-group">
                        <!-- <label for="country">Order Status</label> -->
                        <select class="custom-select d-block w-100" name="status" id="status">
                            <option value="">Choose...</option>
                            <option value="Processing" <?php if ($order_status) {
                                                            if ($order_status === 'Processing') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>> Processing</option>
                            <option value="Order Shipped" <?php if ($order_status) {
                                                                if ($order_status === 'Order Shipped') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>> Order Shipped</option>
                            <option value="Cancelled" <?php if ($order_status) {
                                                            if ($order_status === 'Cancelled') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>> Cancelled</option>

                        </select>
                    </div>
                    <h4 class="mb-3">Billing address</h4>
                    <input name="order_id" id="order_id" value="<?php echo $id ?>" style="display:none">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?php echo $order_bfname; ?>">
                                <!-- <div class="invalid-feedback">
                                                        Valid first name is required.
                                                    </div> -->
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?php echo $order_blname; ?>">
                                <!-- <div class="invalid-feedback">
                                                    Valid last name is required.
                                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- <div class="mb-3">
                                            <div class="form-group">
                                                <label for="username">Username</label>

                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">

                                            </div>
                                        </div> -->

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $order_email; ?>" placeholder="you@example.com">
                            <!-- <div class="invalid-feedback">
                                                Please enter a valid email address for shipping updates.
                                            </div> -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="phone">Mobile number</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $order_phone; ?>" placeholder="021 123 4567">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $order_baddress1; ?>" placeholder="1234 Main St">
                            <!-- <div class="invalid-feedback">
                                                Please enter your shipping address.
                                            </div> -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" name="address2" id="address2" value="<?php echo $order_baddress1; ?>" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select class="custom-select d-block w-100" name="country" id="country">
                                    <option value="">Choose...</option>
                                    <option value="New Zealand" <?php if ($order_bcountry) {
                                                                    if ($order_bcountry === 'New Zealand') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>> New Zealand</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="custom-select d-block w-100" name="state" value="<?php echo $order_bstate ?>" id="state">
                                    <option value="">Choose...</option>
                                    <option value="Northland" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Northland') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Northland</option>
                                    <option value="Auckland" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Auckland') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Auckland</option>
                                    <option value="Waikato" <?php if ($order_bstate) {
                                                                if ($order_bstate === 'Waikato') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Waikato</option>
                                    <option value="Bay of Plenty" <?php if ($order_bstate) {
                                                                        if ($order_bstate === 'Bay of Plenty') {
                                                                            echo 'selected';
                                                                        }
                                                                    }  ?>>Bay of Plenty</option>
                                    <option value="Gisborne" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Gisborne') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Gisborne</option>
                                    <option value="Hawke's Bay" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Hawke\'s Bay') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Hawke's Bay</option>
                                    <option value="Auckland" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Auckland') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Auckland</option>
                                    <option value="Taranaki" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Taranaki') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Taranaki</option>
                                    <option value="Manawatu-Wanganui" <?php if ($order_bstate) {
                                                                            if ($order_bstate === 'Manawatu-Wanganui') {
                                                                                echo 'selected';
                                                                            }
                                                                        }  ?>>Manawatu-Wanganui</option>
                                    <option value="Wellington" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Wellington') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Wellington</option>
                                    <option value="Tasman" <?php if ($order_bstate) {
                                                                if ($order_bstate === 'Tasman') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Tasman</option>
                                    <option value="Nelson" <?php if ($order_bstate) {
                                                                if ($order_bstate === 'Nelson') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Nelson</option>
                                    <option value="Marlborough" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Marlborough') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Marlborough</option>
                                    <option value="West Coast" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'West Coast') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>West Coast</option>
                                    <option value="Canterbury" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Canterbury') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Canterbury</option>
                                    <option value="Otago" <?php if ($order_bstate) {
                                                                if ($order_bstate === 'Otago') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Otago</option>
                                    <option value="Southland" <?php if ($order_bstate) {
                                                                    if ($order_bstate === 'Southland') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Southland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" name="zip" id="zip" value="<?php echo $order_bzip ?>" placeholder="">
                                <!-- <div class="invalid-feedback">
                                                    Zip code required.
                                                </div> -->
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Shipping address</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" name="sh_firstName" id="firstName" placeholder="" value="<?php echo $order_shfname; ?>">
                        <!-- <div class="invalid-feedback">
                                                        Valid first name is required.
                                                    </div> -->
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" name="sh_lastName" id="lastName" placeholder="" value="<?php echo $order_shlname; ?>">
                        <!-- <div class="invalid-feedback">
                                                    Valid last name is required.
                                                </div> -->
                    </div>
                </div>
            </div>

            <!-- <div class="mb-3">
                                            <div class="form-group">
                                                <label for="username">Username</label>

                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">

                                            </div>
                                        </div> -->

            <div class="mb-3">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="sh_email" id="email" value="<?php echo $order_email; ?>" placeholder="you@example.com">
                    <!-- <div class="invalid-feedback">
                                                Please enter a valid email address for shipping updates.
                                            </div> -->
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="phone">Mobile number</label>
                    <input type="tel" class="form-control" name="sh_phone" id="phone" value="<?php echo $order_phone; ?>" placeholder="021 123 4567">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="sh_address" id="address" value="<?php echo $order_shaddress1; ?>" placeholder="1234 Main St">
                    <!-- <div class="invalid-feedback">
                                                Please enter your shipping address.
                                            </div> -->
                </div>
            </div>

            <div class="mb-3">
                <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" name="sh_address2" id="address2" value="<?php echo $order_shaddress2; ?>" placeholder="Apartment or suite">
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100" name="sh_country" id="country">
                            <option value="">Choose...</option>
                            <option value="New Zealand" <?php if ($order_shcountry) {
                                                            if ($order_shcountry === 'New Zealand') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>New Zealand</option>

                        </select>
                        <!-- <div class="invalid-feedback">
                                                    Please select a valid country.
                                                </div> -->
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select class="custom-select d-block w-100" name="sh_state" value="<?php echo $order_shstate ?>" id="state">
                            <option value="">Choose...</option>
                            <option value="Northland" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Northland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Northland</option>
                            <option value="Auckland" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Auckland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Auckland</option>
                            <option value="Waikato" <?php if ($order_shstate) {
                                                        if ($order_shstate === 'Waikato') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Waikato</option>
                            <option value="Bay of Plenty" <?php if ($order_shstate) {
                                                                if ($order_shstate === 'Bay of Plenty') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Bay of Plenty</option>
                            <option value="Gisborne" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Gisborne') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Gisborne</option>
                            <option value="Hawke's Bay" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Hawke\'s Bay') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Hawke's Bay</option>
                            <option value="Auckland" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Auckland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Auckland</option>
                            <option value="Taranaki" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Taranaki') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Taranaki</option>
                            <option value="Manawatu-Wanganui" <?php if ($order_shstate) {
                                                                    if ($order_shstate === 'Manawatu-Wanganui') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Manawatu-Wanganui</option>
                            <option value="Wellington" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Wellington') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Wellington</option>
                            <option value="Tasman" <?php if ($order_shstate) {
                                                        if ($order_shstate === 'Tasman') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Tasman</option>
                            <option value="Nelson" <?php if ($order_shstate) {
                                                        if ($order_shstate === 'Nelson') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Nelson</option>
                            <option value="Marlborough" <?php if ($order_shstate) {
                                                            if ($order_bstate === 'Marlborough') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Marlborough</option>
                            <option value="West Coast" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'West Coast') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>West Coast</option>
                            <option value="Canterbury" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Canterbury') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Canterbury</option>
                            <option value="Otago" <?php if ($order_shstate) {
                                                        if ($order_shstate === 'Otago') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Otago</option>
                            <option value="Southland" <?php if ($order_shstate) {
                                                            if ($order_shstate === 'Southland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Southland</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" name="sh_zip" id="zip" value="<?php echo $order_shzip ?>" placeholder="">
                        <!-- <div class="invalid-feedback">
                                                    Zip code required.
                                                </div> -->
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="edit_order_btn" name="edit_order_btn">Save changes</button>
                <button type="button" class="btn btn-secondary" id="cancel_order_btn" name="cancel_order_btn">Cancel changes</button>
                <div class="float-right">
                    <button type="button" class="btn btn-danger" id="del_order_btn" name="del_order_btn">Delete order</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </main>
<?php endif; ?>




<?php include "./admin_panel_footer.php"; ?>