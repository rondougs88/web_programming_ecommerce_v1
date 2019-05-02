<br>
<h4 class="mb-3">Shipping address</h4>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="sh_firstName">First name</label>
            <input disabled type="text" class="form-control" name="sh_firstName" id="sh_firstName" placeholder="" value="<?=$sh_fname?>">
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="sh_lastName">Last name</label>
            <input disabled type="text" class="form-control" name="sh_lastName" id="sh_lastName" placeholder="" value="<?=$sh_lname?>">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="form-group">
        <label for="sh_address">Address</label>
        <input disabled type="text" class="form-control" name="sh_address" id="sh_address" value="<?=$sh_address1?>" placeholder="1234 Main St">
    </div>
</div>

<div class="mb-3">
    <label for="sh_address2">Address 2 <span class="text-muted">(Optional)</span></label>
    <input disabled type="text" class="form-control" name="sh_address2" id="sh_address2" value="<?=$sh_address2?>" placeholder="Apartment or suite">
</div>

<div class="row">
    <div class="col-md-5 mb-3">
        <div class="form-group">
            <label for="sh_country">Country</label>
            <input disabled type="text" class="form-control" name="sh_country" id="sh_country" value="<?=$sh_country?>">
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="sh_state">State</label>
            <input disabled type="text" class="form-control" name="sh_state" id="sh_state" value="<?=$sh_state_c?>">
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="form-group">
            <label for="sh_zip">Zip</label>
            <input disabled type="text" class="form-control" name="sh_zip" id="sh_zip" value="<?=$sh_zip?>" placeholder="">
        </div>
    </div>
</div>