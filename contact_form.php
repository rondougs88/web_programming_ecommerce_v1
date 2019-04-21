<?php include "./admin_area/includes/db.php"; ?>
<?php $pagetitle = "Geek Gadget"; ?>
<?php include "header.php"; ?>

<?php include "navigation.php"; ?>

<div class="container">
<form id="contact-form" method="post" action="" role="form" style="margin-top:40px">
<h1>Contact Us</h1>
    <div class="messages"></div>

    <div class="controls">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="con_fname">Firstname *</label>
                    <input id="con_fname" type="text" name="con_fname" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="con_lname">Lastname *</label>
                    <input id="con_lname" type="text" name="con_lname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="con_email">Email *</label>
                    <input id="con_email" type="email" name="con_email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label for="form_need">Please specify your need *</label>
                    <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                        <option value=""></option>
                        <option value="Request quotation">Request quotation</option>
                        <option value="Request order status">Request order status</option>
                        <option value="Request copy of an invoice">Request copy of an invoice</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="con_message">Message *</label>
                    <textarea id="con_message" name="con_message" class="form-control" placeholder="Message for me *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-success btn-send" id="contact-us-btn" value="Send message">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="text-muted">
                    <strong>*</strong> These fields are required.</p>
            </div>
        </div>
    </div>

</form>
</div>

<?php include "footer.php"; ?>

</html>