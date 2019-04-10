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
                <option value="United States" <?php if (isset($_SESSION['country'])) {
                                                    if ($_SESSION['country'] === 'United States') {
                                                        echo 'selected';
                                                    }
                                                }  ?>>United States</option>
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
                <option value="California" <?php if (isset($_SESSION['state'])) {
                                                if ($_SESSION['state'] === 'California') {
                                                    echo 'selected';
                                                }
                                            }  ?>>California</option>
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