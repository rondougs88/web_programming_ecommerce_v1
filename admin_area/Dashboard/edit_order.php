<?php include "./admin_panel_header.php"; ?>
<?php
$id = "";
if (isset($_GET['order'])) {
    global $id, $con;
    $id = $_GET['order'];
    $get_order = "SELECT * FROM order_header where order_id='$id'";
    $res = mysqli_query($con, $get_order);
    while ($row_order = mysqli_fetch_array($res)) {
        $order_status = $row_order['status'];
        $order_email = $row_order['email'];
        $order_user = $row_order['username'];
        $order_date = $row_order['created_on'];
        $order_phone= $row_order['phone'];

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

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="py-5 text-center">
        <!-- <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
        <h2>Edit order form of Order <?php echo $id ?></h2>
        <p class="lead">Please fill out the details below to edit order..</p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill"><?= cart_items_count() ?></span>
            </h4>
            <ul class="list-group mb-3">
                <!-- Display the cart items in this page. -->
                <?= display_checkout_cart_items() ?>
                <!-- <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li> -->
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

            <!-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> -->
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" method="post" id="edit_order-form" action="./create_order.php" novalidate>
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
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?php echo $order_blname;?>">
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
                                <option value=" <?php if ($order_bcountry['country']) {
                                                                if ($order_bcountry['country'] === 'New Zealand') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>">New Zealand</option>

                            </select>
                            <!-- <div class="invalid-feedback">
                                Please select a valid country.
                            </div> -->
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="custom-select d-block w-100" name="state" value="<?php echo $order_bstate['state_c'] ?>" id="state">
                                <option value="">Choose...</option>
                                <option value="Northland" <?php if ($order_bstate['state_c']) {
                                                                if ($order_bstate['state_c'] === 'Northland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Northland</option>
                                <option value="Auckland" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Auckland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Auckland</option>
                                <option value="Waikato" <?php if ($order_bstate['state']) {
                                                            if ($order_bstate['state'] === 'Waikato') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Waikato</option>
                                <option value="Bay of Plenty" <?php if ($order_bstate['state']) {
                                                                    if ($order_bstate['state'] === 'Bay of Plenty') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Bay of Plenty</option>
                                <option value="Gisborne" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Gisborne') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Gisborne</option>
                                <option value="Hawke's Bay" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Hawke\'s Bay') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Hawke's Bay</option>
                                <option value="Auckland" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Auckland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Auckland</option>
                                <option value="Taranaki" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Taranaki') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Taranaki</option>
                                <option value="Manawatu-Wanganui" <?php if ($order_bstate['state']) {
                                                                        if ($order_bstate['state'] === 'Manawatu-Wanganui') {
                                                                            echo 'selected';
                                                                        }
                                                                    }  ?>>Manawatu-Wanganui</option>
                                <option value="Wellington" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Wellington') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Wellington</option>
                                <option value="Tasman" <?php if ($order_bstate['state']) {
                                                            if ($order_bstate['state'] === 'Tasman') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Tasman</option>
                                <option value="Nelson" <?php if ($order_bstate['state']) {
                                                            if ($order_bstate['state'] === 'Nelson') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Nelson</option>
                                <option value="Marlborough" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Marlborough') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Marlborough</option>
                                <option value="West Coast" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'West Coast') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>West Coast</option>
                                <option value="Canterbury" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Canterbury') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Canterbury</option>
                                <option value="Otago" <?php if ($order_bstate['state']) {
                                                            if ($order_bstate['state'] === 'Otago') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Otago</option>
                                <option value="Southland" <?php if ($order_bstate['state']) {
                                                                if ($order_bstate['state'] === 'Southland') {
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
            </form>
        </div>
    </div>

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Shipping address</h4>
            <form class="needs-validation" method="post" id="edit_order-form" action="./create_order.php" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?php echo $order_shfname; ?>">
                            <!-- <div class="invalid-feedback">
                                    Valid first name is required.
                                </div> -->
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?php echo $order_shlname;?>">
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
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $order_shaddress1; ?>" placeholder="1234 Main St">
                        <!-- <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div> -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" name="address2" id="address2" value="<?php echo $order_shaddress2; ?>" placeholder="Apartment or suite">
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="custom-select d-block w-100" name="country" id="country">
                                <option value="">Choose...</option>
                                <option value=" <?php if ($order_shcountry['sh_country']) {
                                                                if ($order_shcountry['sh_country'] === 'New Zealand') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>">New Zealand</option>

                            </select>
                            <!-- <div class="invalid-feedback">
                                Please select a valid country.
                            </div> -->
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="custom-select d-block w-100" name="state" value="<?php echo $order_shstate['sh_state_c'] ?>" id="state">
                                <option value="">Choose...</option>
                                <option value="Northland" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Northland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Northland</option>
                                <option value="Auckland" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Auckland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Auckland</option>
                                <option value="Waikato" <?php if ($order_shstate['sh_state_c']) {
                                                            if ($order_shstate['sh_state_c'] === 'Waikato') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Waikato</option>
                                <option value="Bay of Plenty" <?php if ($order_shstate['sh_state_c']) {
                                                                    if ($order_shstate['sh_state_c'] === 'Bay of Plenty') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Bay of Plenty</option>
                                <option value="Gisborne" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Gisborne') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Gisborne</option>
                                <option value="Hawke's Bay" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Hawke\'s Bay') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Hawke's Bay</option>
                                <option value="Auckland" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Auckland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Auckland</option>
                                <option value="Taranaki" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Taranaki') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Taranaki</option>
                                <option value="Manawatu-Wanganui" <?php if ($order_shstate['sh_state_c']) {
                                                                        if ($order_shstate['sh_state_c'] === 'Manawatu-Wanganui') {
                                                                            echo 'selected';
                                                                        }
                                                                    }  ?>>Manawatu-Wanganui</option>
                                <option value="Wellington" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Wellington') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Wellington</option>
                                <option value="Tasman" <?php if ($order_shstate['sh_state_c']) {
                                                            if ($order_shstate['sh_state_c'] === 'Tasman') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Tasman</option>
                                <option value="Nelson" <?php if ($order_shstate['sh_state_c']) {
                                                            if ($order_shstate['state'] === 'Nelson') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Nelson</option>
                                <option value="Marlborough" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_bstate['state'] === 'Marlborough') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Marlborough</option>
                                <option value="West Coast" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['state'] === 'West Coast') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>West Coast</option>
                                <option value="Canterbury" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['state'] === 'Canterbury') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Canterbury</option>
                                <option value="Otago" <?php if ($order_shstate['sh_state_c']) {
                                                            if ($order_shstate['sh_state_c'] === 'Otago') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Otago</option>
                                <option value="Southland" <?php if ($order_shstate['sh_state_c']) {
                                                                if ($order_shstate['sh_state_c'] === 'Southland') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Southland</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" id="zip"  value="<?php echo $order_shzip ?>" placeholder="">
                            <!-- <div class="invalid-feedback">
                                Zip code required.
                            </div> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>





<?php include "./admin_panel_footer.php"; ?>