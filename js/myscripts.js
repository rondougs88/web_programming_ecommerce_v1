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
                    error: function (request, status, errorThrown) {
                        // There's been an error, do something with it!
                        // Only use status and errorThrown.
                        // Chances are request will not have anything in it.
                        $('.loading').hide();
                        $('.json-overlay').hide();
                        alert("Update Error: " + status + errorThrown);
                    }
                })

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

    $("#contact-us-btn").click(function () {
        if ($('#contact-form').valid()) {
            //Call ajax
            $('.loading').show();
            $('.json-overlay').show();
            var fname = $("#con_fname").val();
            var lname = $("#con_lname").val();
            var email = $("#con_email").val();
            var message = $("#con_message").val();
            // var userid = getUrlParameter('userid');

            $.ajax({
                type: "POST",
                url: siteroot + "/admin_area/Dashboard/admin_functions.php",
                async: false,
                data: { contact_us: "", fname: fname, lname: lname, email: email, message: message },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result.includes("message has been sent")) {
                        window.location = siteroot + "/index.php";
                        // window.location.assign(siteroot + "/admin_area/logout.php");
                        // return false; // To open in new window
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })
            return false;
        }
    });

    $('#contact-form').validate({
        rules: {
            con_fname: {
                minlength: 2,
                required: true
            },
            con_lname: {
                minlength: 2,
                required: true
            },
            con_email: {
                required: true,
                email: true
            },
            con_message: {
                minlength: 5,
                required: true
            },
        },
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                .removeClass('alert alert-success')
                .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
                .closest('.form-group')
                .removeClass('alert alert-danger text-danger')
                .addClass('alert alert-success');
        }
    });

    $("#submit-post").click(function () {
        if ($("#new-post-form").valid()) {
            //Call ajax
            $('.loading').show();
            $('.json-overlay').show();
            var topic = $("#topic option:selected").val();
            var subject = $("#subject").val();
            var message = $("#message").val();
            // var lname = $("#con_lname").val();
            // var email = $("#con_email").val();
            // var message = $("#con_message").val();
            // var userid = getUrlParameter('userid');

            $.ajax({
                type: "POST",
                url: siteroot + "/message_board/post_message.php",
                async: true,
                data: { new_post: "", topic: topic, subject: subject, message: message, userid: userid },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result.includes("has been posted")) {
                        window.location = siteroot + "/message_board/topics.php";
                        // window.location.assign(siteroot + "/admin_area/logout.php");
                        // return false; // To open in new window
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })
            return false;
        }
    });

    $("#new-post-form").validate({
        rules: {
            topic: {
                required: true
            },
            subject: {
                required: true
            },
            message: {
                required: true,
            },
        },
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                .removeClass('alert alert-success')
                .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
                .closest('.form-group')
                .removeClass('alert alert-danger text-danger')
                .addClass('alert alert-success');
        }
    });

    $("#post_reply_btn").click(function () {
        var message = $("#post_msg").val();

        if (!message) {
            alert("Message cannot be empty.");
        }
        else {
            //Call ajax
            $('.loading').show();
            $('.json-overlay').show();

            $.ajax({
                type: "POST",
                url: siteroot + "/message_board/post_message.php",
                async: false,
                data: { post_reply: "", subject_id: subject_id, message: message, userid: userid }, // Subject id is passed from messages.php
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result.includes("successfully")) {
                        window.location = siteroot + "/message_board/messages.php?topic_id=" + topic_id + "&subject_id=" + subject_id;
                        // window.location.assign(siteroot + "/admin_area/logout.php");
                        // return false; // To open in new window
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })
        }
        return false;
    });

    $(".create_post_btn").click(function () {
        if (!isLoggedIn) {
            alert("You must be logged in to create a new post.");
        }
        else {
            window.location = siteroot + "/message_board/create_post.php?topic_id=" + topic_id;
        }
    });

    $(".del_post_btn").click(function () {
        // var del_post_id = $("#del_post_id_").val();
        var del_post_id = $(this).attr("id");
        //Call ajax
        $('.loading').show();
        $('.json-overlay').show();
        $.ajax({
            type: "POST",
            url: siteroot + "/message_board/post_message.php",
            async: false,
            data: { del_post: "", post_id: del_post_id }, // Subject id is passed from messages.php
            success: function (result) {
                // Do stuff
                $('.loading').hide();
                $('.json-overlay').hide();
                alert(result);
                if (result.includes("Successfully")) {
                    location.reload();
                }
            },
            error: function (request, status, errorThrown) {
                // There's been an error, do something with it!
                // Only use status and errorThrown.
                // Chances are request will not have anything in it.
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Error: " + status + errorThrown);
            }
        })
    });

    $(".del_subj_btn").click(function () {
        // var del_post_id = $("#del_post_id_").val();
        var del_subj_id = $(this).attr("id");
        //Call ajax
        $('.loading').show();
        $('.json-overlay').show();
        $.ajax({
            type: "POST",
            url: siteroot + "/message_board/post_message.php",
            async: false,
            data: { del_subj: "", subj_id: del_subj_id }, // Subject id is passed from messages.php
            success: function (result) {
                // Do stuff
                $('.loading').hide();
                $('.json-overlay').hide();
                alert(result);
                if (result.includes("Successfully")) {
                    location.reload();
                }
            },
            error: function (request, status, errorThrown) {
                // There's been an error, do something with it!
                // Only use status and errorThrown.
                // Chances are request will not have anything in it.
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Error: " + status + errorThrown);
            }
        })
    });

    $("#new_topic_btn").click(function () {
        var topic_name = $("#new_topic").val();
        var topic_desc = $("#topic_desc").val();
        if ($("#new_topic_form").valid()) {
            $('.loading').show();
            $('.json-overlay').show();
            $.ajax({
                type: "POST",
                url: siteroot + "/message_board/post_message.php",
                async: false,
                data: { new_topic: "", topic_name: topic_name, topic_desc: topic_desc }, // Subject id is passed from messages.php
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result.includes("has been posted")) {
                        location.reload();
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })
            return false;
        }
    });

    $("#ch_topic_btn").click(function () {
        var topic_name = $("#ch_topic_name").val();
        var topic_desc = $("#ch_topic_desc").val();
        var topic_id = $("#existing_topic option:selected").val();
        if ($("#edit_topic_form").valid()) {
            $('.loading').show();
            $('.json-overlay').show();
            $.ajax({
                type: "POST",
                url: siteroot + "/message_board/post_message.php",
                async: false,
                data: { ch_topic: "", topic_name: topic_name, topic_desc: topic_desc, topic_id: topic_id }, // Subject id is passed from messages.php
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    if (result.includes("has been updated")) {
                        location.reload();
                    }
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })
            return false;
        }
    });

    $("#new_topic_form").validate({
        rules: {
            new_topic: {
                required: true
            },
            topic_desc: {
                required: true
            },
        },
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                .removeClass('alert alert-success')
                .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
                .closest('.form-group')
                .removeClass('alert alert-danger text-danger')
                .addClass('alert alert-success');
        }
    });

    $("#edit_topic_form").validate({
        rules: {
            ch_topic_name: {
                required: true
            },
            ch_topic_desc: {
                required: true
            },
        },
        highlight: function (element) {
            $(element)
                .closest('.form-group')
                .removeClass('alert alert-success')
                .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
                .closest('.form-group')
                .removeClass('alert alert-danger text-danger')
                .addClass('alert alert-success');
        }
    });

    $("#existing_topic").change(function () {
        if ($(this).val()) {
            $('.loading').show();
            $('.json-overlay').show();
            $.ajax({
                type: "POST",
                url: siteroot + "/message_board/post_message.php",
                async: false,
                data: { get_topic_det: "", topic_id: $(this).val() }, // Subject id is passed from messages.php
                success: function (result) {
                    // Do stuff
                    var topic = $.parseJSON(result);
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    $("#ch_topic_name").val(topic['cat_name']);
                    $("#ch_topic_desc").val(topic['cat_description']);
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Error: " + status + errorThrown);
                }
            })

        }
    });
});

