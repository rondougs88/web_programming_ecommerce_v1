<div class="py-5 text-center">
    <!-- <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
    <h2>Checkout form</h2>
    <p class="lead">Please fill out the details below to successfully place your order.</p>
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
        <form class="needs-validation" method="post" id="checkout-form" action="./create_order.php" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : '' ?>">
                        <!-- <div class="invalid-feedback">
                                    Valid first name is required.
                                </div> -->
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : '' ?>">
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
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" placeholder="you@example.com">
                    <!-- <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div> -->
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="phone">Mobile number</label>
                    <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : '' ?>" placeholder="021 123 4567">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>" placeholder="1234 Main St">
                    <!-- <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div> -->
                </div>
            </div>

            <div class="mb-3">
                <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" name="address2" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100" name="country" id="country">
                            <option value="">Choose...</option>
                            <option value="New Zealand" <?php if (isset($_SESSION['country'])) {
                                                            if ($_SESSION['country'] === 'New Zealand') {
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
                        <select class="custom-select d-block w-100" name="state" value="<?php echo isset($_SESSION['state']) ? $_SESSION['state'] : '' ?>" id="state">
                            <option value="">Choose...</option>
                            <option value="Northland" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Northland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Northland</option>
                            <option value="Auckland" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Auckland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Auckland</option>
                            <option value="Waikato" <?php if (isset($_SESSION['state'])) {
                                                        if ($_SESSION['state'] === 'Waikato') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Waikato</option>
                            <option value="Bay of Plenty" <?php if (isset($_SESSION['state'])) {
                                                                if ($_SESSION['state'] === 'Bay of Plenty') {
                                                                    echo 'selected';
                                                                }
                                                            }  ?>>Bay of Plenty</option>
                            <option value="Gisborne" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Gisborne') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Gisborne</option>
                            <option value="Hawke's Bay" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Hawke\'s Bay') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Hawke's Bay</option>
                            <option value="Auckland" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Auckland') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Auckland</option>
                            <option value="Taranaki" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Taranaki') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Taranaki</option>
                            <option value="Manawatu-Wanganui" <?php if (isset($_SESSION['state'])) {
                                                                    if ($_SESSION['state'] === 'Manawatu-Wanganui') {
                                                                        echo 'selected';
                                                                    }
                                                                }  ?>>Manawatu-Wanganui</option>
                            <option value="Wellington" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Wellington') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Wellington</option>
                            <option value="Tasman" <?php if (isset($_SESSION['state'])) {
                                                        if ($_SESSION['state'] === 'Tasman') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Tasman</option>
                            <option value="Nelson" <?php if (isset($_SESSION['state'])) {
                                                        if ($_SESSION['state'] === 'Nelson') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Nelson</option>
                            <option value="Marlborough" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Marlborough') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Marlborough</option>
                            <option value="West Coast" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'West Coast') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>West Coast</option>
                            <option value="Canterbury" <?php if (isset($_SESSION['state'])) {
                                                            if ($_SESSION['state'] === 'Canterbury') {
                                                                echo 'selected';
                                                            }
                                                        }  ?>>Canterbury</option>
                            <option value="Otago" <?php if (isset($_SESSION['state'])) {
                                                        if ($_SESSION['state'] === 'Otago') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Otago</option>
                            <option value="Southland" <?php if (isset($_SESSION['state'])) {
                                                        if ($_SESSION['state'] === 'Southland') {
                                                            echo 'selected';
                                                        }
                                                    }  ?>>Southland</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" name="zip" id="zip" value="<?php echo isset($_SESSION['zip']) ? $_SESSION['zip'] : '' ?>" placeholder="">
                        <!-- <div class="invalid-feedback">
                                Zip code required.
                            </div> -->
                    </div>
                </div>
            </div>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="same-address" name="same-address" value="same_address" checked>
                <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <!-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div> -->
            <div class="shipping-address">
                <?php include "./includes/shipping_address.php" ?>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Shipping</h4>
            <div class="d-block my-3">
                <div class="custom-control custom-radio">
                    <input id="freeshipping" name="shipping" type="radio" class="custom-control-input" value="freeshipping" checked>
                    <label class="custom-control-label" for="freeshipping">Free Shipping (NZ$ 0.00)</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 mb-3">
                    <p>All local orders are shipped free using a standard service.</p>
                </div>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>
            <div class="d-block my-3">
                <div class="custom-control custom-radio">
                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" value="creditcard" checked>
                    <label class="custom-control-label" for="credit">Credit/Debit card (via Stripe Payment Gateway)</label>
                </div>
                <!-- <div class="custom-control custom-radio">
                    <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" value="debitcard">
                    <label class="custom-control-label" for="debit">Debit card</label>
                </div> -->
                <div class="custom-control custom-radio">
                    <input id="cod" name="paymentMethod" type="radio" class="custom-control-input" value="cod">
                    <label class="custom-control-label" for="cod">Cash on Delivery</label>
                </div>
            </div>

            <?php include "./payment_options/payment_options.php" ?>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block place-order" name="create-order" type="submit">Place my order</button>
        </form>
    </div>
</div>