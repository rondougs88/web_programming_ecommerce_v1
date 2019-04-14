<br>
<h4 class="mb-3">Shipping address</h4>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="sh_firstName">First name</label>
            <input type="text" class="form-control" name="sh_firstName" id="sh_firstName" placeholder="" value="<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : '' ?>">
            <!-- <div class="invalid-feedback">
                                    Valid first name is required.
                                </div> -->
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="sh_lastName">Last name</label>
            <input type="text" class="form-control" name="sh_lastName" id="sh_lastName" placeholder="" value="<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : '' ?>">
            <!-- <div class="invalid-feedback">
                                Valid last name is required.
                            </div> -->
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="form-group">
        <label for="sh_address">Address</label>
        <input type="text" class="form-control" name="sh_address" id="sh_address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>" placeholder="1234 Main St">
        <!-- <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div> -->
    </div>
</div>

<div class="mb-3">
    <label for="sh_address2">Address 2 <span class="text-muted">(Optional)</span></label>
    <input type="text" class="form-control" name="sh_address2" id="sh_address2" placeholder="Apartment or suite">
</div>

<div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group">
            <label for="sh_country">Country</label>
            <select class="custom-select d-block w-100" name="sh_country" id="sh_country">
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
            <label for="sh_state">State</label>
            <select class="custom-select d-block w-100" name="sh_state" id="sh_state" value="<?php echo isset($_SESSION['state']) ? $_SESSION['state'] : '' ?>" id="state">
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
            <!-- <div class="invalid-feedback">
                                Please provide a valid state.
                            </div> -->
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="form-group">
            <label for="sh_zip">Zip</label>
            <input type="text" class="form-control" name="sh_zip" id="sh_zip" value="<?php echo isset($_SESSION['zip']) ? $_SESSION['zip'] : '' ?>" placeholder="">
            <!-- <div class="invalid-feedback">
                                Zip code required.
                            </div> -->
        </div>
    </div>
</div>