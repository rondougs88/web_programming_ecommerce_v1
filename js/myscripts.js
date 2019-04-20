jQuery(document).ready(function () {

    $('.loading').hide();
    $('.json-overlay').hide();

    $(window).on("beforeunload", function () {
        $('.loading').show();
        $('.json-overlay').show();
    });

    $(".list-group a").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    // $("#my-cart-badge").text(cart_count);
    $(".my-cart-badge").html(cart_count);

    // Call this only after creating an order or adding to cart.
    // update_cart_count();

    // This part is for handling the shopping cart amount events.
    var array_update_cart = [];
    $(".cartqty").change(function () {
        var prod_id = $(this).attr("data-id");
        var newVal = $(this).val();
        // if it already exists, just update qty
        var exists = false;
        exists = array_update_cart.find(x => x.prod_id === prod_id);
        if (exists) {
            exists['qty'] = newVal;
        }
        else {
            array_update_cart.push({ 'prod_id': prod_id, 'qty': newVal, 'delete': false });
        }
    });

    // Update remote db via ajax php call for qty change - cart events.
    // $('#updatecart').click(function () {
    $('#updatecart').one('click', function () {
        $('.loading').show();           // show loading spinner
        $('.json-overlay').show();      // disable screen
        var filtered_array = array_update_cart.filter(function (v) { return v !== '' });
        if (filtered_array.length > 0) {

            $.ajax({
                type: "POST",
                url: siteroot + "/updatecart.php",
                async: false,
                data: { update_cart: filtered_array },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Success: " + result);
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Error: " + status + errorThrown);
                }
                // ,
                // complete: function () {
                //     $('.loading').hide();
                //     $('.json-overlay').hide();
                // }
            })
            // .done(function (msg) {
            //     alert("Data Saved: " + msg);
            // })
            // .success(function (result) {
            //     // Do stuff
            //     console.log("Update Cart Ajax Success: ", result);
            // }).error(function (request, status, errorThrown) {
            //         // There's been an error, do something with it!
            //         // Only use status and errorThrown.
            //         // Chances are request will not have anything in it.
            //         console.log("Update Cart Ajax Error: ", status, errorThrown);
            // });
        }
        else {
            alert("Nothing to update in this cart.");
            exit
        }
        array_update_cart = [];
    });

    // Update remote db via ajax php call for deleting items - cart events.
    $(".delcartitem").click(function () {
        var prod_id = $(this).attr("data-id");
        // var prod_id = $(this).val();
        var idname = "#cart_" + prod_id;
        $(idname).empty();  // This will remove the item row from the cart.

        array_update_cart.push({ 'prod_id': prod_id, 'qty': '0', 'delete': true });
    });

    // Validate the checkout form
    //     $.validator.addMethod("phoneNZ", function(phone_number, element) {
    //         // phone_number = phone_number.replace(/\s+/g, ""); 
    //         return this.optional(element) || phone_number.length > 9 &&
    // phone_number.match(/^(0|(\+64(\s|-)?)){1}\d{1}(\s|-)?\d{3}(\s|-)?\d{4}$/);
    //     }, "Please specify a valid phone number");
    jQuery.validator.addMethod('mobileNZ', function (phone_number, element) {
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^(0|(\+64(\s|-)?)){1}(21|22|27){1}(\s|-)?\d{3}(\s|-)?\d{4}$/);
    }, 'Please specify a valid mobile number');
    $('#checkout-form').validate({
        rules: {
            firstName: {
                minlength: 2,
                required: true
            },
            lastName: {
                minlength: 2,
                required: true
            },
            // username: {
            //     required: true,
            //     username: true
            // },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                mobileNZ: true,
                // regex: "[0-9\-\(\)\s]+",  // <-- no such method called "matches"!
                // minlength: 10,
                // maxlength: 10
            },
            address: {
                required: true,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            zip: {
                required: true,
            },
            sh_firstName: {
                minlength: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                }
            },
            sh_lastName: {
                minlength: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                }
            },
            sh_email: {
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
                email: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                }
            },
            sh_address: {
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
            },
            sh_country: {
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
            },
            sh_state: {
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
            },
            sh_zip: {
                required: {
                    depends: function () {
                        return !$('#my_select_checkbox').is(':checked')
                    }
                },
            },
        },
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                // .siblings('input')
                .removeClass('alert alert-success')
                .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
                // .text('Ok!')
                // .removeClass('error')
                // .addClass('alert alert-success')
                .closest('.form-group')
                // .siblings('input')
                .removeClass('alert alert-danger text-danger')
                .addClass('alert alert-success');
        }
    });

    // Toggle div for shipping address
    var same_address = $("#same-address").is(':checked');
    if (same_address) {
        $(".shipping-address").hide();
    }
    else {
        $(".shipping-address").show();
    }
    $("#same-address").change(function () {
        var ischecked = $(this).is(':checked');
        if (ischecked) {
            $(".shipping-address").hide();
        }
        else {
            $(".shipping-address").show();
        }
    });
    // Validate the shipping address if it is visible.
    if ($('.shipping-address').is(':visible')) {

    }

    $("#edit_user_btn").click(function () {

        $('.loading').show();
        $('.json-overlay').show();

        var username, fname, lname, email, user_type, id;
        // var userid = getUrlParameter('userid');
        username = $("#username").val();
        fname = $("#fname").val();
        lname = $("#lname").val();
        email = $("#email").val();
        user_type = $("#user_type option:selected").val();

        $.ajax({
            type: "POST",
            url: siteroot + "/admin_area/Dashboard/save_edited_user.php",
            async: true,
            data: { username: username, fname: fname, lname: lname, email: email, user_type: user_type },
            success: function (result) {
                // Do stuff
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Cart Ajax Success: " + result);
            },
            error: function (request, status, errorThrown) {
                // There's been an error, do something with it!
                // Only use status and errorThrown.
                // Chances are request will not have anything in it.
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Cart Ajax Error: " + status + errorThrown);
            }
        });
    });
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    $("#admin_reset_pwd").click(function () {
        window.location = siteroot + "/change_password.php";
    });

    $("#change_pwd_btn").click(function () {
        var username = $("#username").val();
        var curr_pwd = $("#curr_pwd").val();
        var new_pwd = $("#new_pwd").val();
        var new_pwd2 = $("#new_pwd2").val();
        if (new_pwd != new_pwd2) {
            alert("The two passwords do not match.");
        }
        else if (curr_pwd == "" || new_pwd == "") {
            alert("Please fill in all parameters.");
        }
        else {
            $('.loading').show();
            $('.json-overlay').show();
            $.ajax({
                type: "POST",
                url: siteroot + "/submit_password.php",
                async: true,
                data: { username: username, curr_pwd: curr_pwd, new_pwd: new_pwd },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result == "Password has been updated.") {
                        window.location = siteroot + "/admin_area/logout.php";
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Error: " + status + errorThrown);
                }
            });
        }
    });

    $("#reset_pwd_btn").click(function () {
        // window.location = siteroot + "/admin_area/logout.php";
        // return false;
        // window.location = "localhost";
        var email = $("#rst_email").val();
        if (email) {
            var result = confirm("Are you sure you want to reset password?");
            if (result) {
                //Call ajax
                $('.loading').show();
                $('.json-overlay').show();
                // var userid = getUrlParameter('userid');

                $.ajax({
                    type: "POST",
                    url: siteroot + "/admin_area/Dashboard/admin_functions.php",
                    async: false,
                    data: { user_reset_pwd: "", email: email },
                    success: function (result) {
                        // Do stuff
                        $('.loading').hide();
                        $('.json-overlay').hide();
                        alert(result);
                        if (result.includes("new password has been sent")) {
                            window.location = siteroot + "/admin_area/logout.php";
                            // window.location.assign(siteroot + "/admin_area/logout.php");
                            return false; // To open in new window
                        }
                    },
                    // done: function (result) {
                    //     // Do stuff
                    //     $('.loading').hide();
                    //     $('.json-overlay').hide();
                    //     alert(result);
                    //     if (result == "A new password has been sent to the email you provided.") {
                    //         window.location = siteroot + "/admin_area/logout.php";
                    //     }
                    // },
                    error: function (request, status, errorThrown) {
                        // There's been an error, do something with it!
                        // Only use status and errorThrown.
                        // Chances are request will not have anything in it.
                        $('.loading').hide();
                        $('.json-overlay').hide();
                        alert("Update Error: " + status + errorThrown);
                    }
                })
                // .done(function (result) {
                //     // Do stuff
                //     $('.loading').hide();
                //     $('.json-overlay').hide();
                //     alert(result);
                //     if (result.includes("new password has been sent")) {
                //         // window.location = siteroot + "/admin_area/logout.php";
                //         // window.location.href = "./logout.php";
                //         // window.location.assign(siteroot + "/admin_area/logout.php");
                //     }
                // });
                // if (gotourl) {

                // }

            }
            else {
                // Do nothing
                console.log("Password reset cancelled.");
            }
        }
        else {
            alert("Email is required.");
        }
        return false;
    });

});

