jQuery(document).ready(function () {

    var siteroot = "http://localhost/web_programming_ecommerce_v1";

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

    $('.loading').hide();
    $('.json-overlay').hide();

    $(window).on("beforeunload", function () {
        $('.loading').show();
        $('.json-overlay').show();
    });

    $("a.nav-link").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    $("#admin_create_user").click(function () {
        window.location.href = siteroot + '/admin_area/Dashboard/admin_create_user.php';
    });

    if (location.pathname.indexOf("users.php") != -1) {
        $("#users").addClass('active').siblings().removeClass('active');
        $("a.nav-link#viewusers").addClass('active').siblings().removeClass('active');
    }

    if (location.pathname.indexOf("admin_create_user.php") != -1) {
        $("#users").addClass('active').siblings().removeClass('active');
        $("#createuser").addClass('active').siblings().removeClass('active');
        $("a.nav-link#createuser").addClass('active').siblings().removeClass('active');
    }

    if (location.pathname.indexOf("insert_product.php") != -1) {
        $("#products").addClass('active').siblings().removeClass('active');
        $("#create_product").addClass('active').siblings().removeClass('active');
        $("a.nav-link#create_product").addClass('active').siblings().removeClass('active');
    }

    if (location.pathname.indexOf("categories.php") != -1) {
        $("#products").addClass('active').siblings().removeClass('active');
        // $("#create_product").addClass('active').siblings().removeClass('active');
        $("a.nav-link#manage_cat").addClass('active').siblings().removeClass('active');
    }

    if (location.pathname.indexOf("brands.php") != -1) {
        $("#products").addClass('active').siblings().removeClass('active');
        // $("#create_product").addClass('active').siblings().removeClass('active');
        $("a.nav-link#manage_brand").addClass('active').siblings().removeClass('active');
    }

    if ((location.pathname.indexOf("view_products.php") != -1) || (location.pathname.indexOf("edit_product.php") != -1)) {
        $("#products").addClass('active').siblings().removeClass('active');
        $("a.nav-link#view_products").addClass('active').siblings().removeClass('active');
    }

    if ($("#users").hasClass("active")) {
        $("#submenu1").collapse("show");
    }

    if ($("#products").hasClass("active")) {
        $("#submenu2").collapse("show");
    }

    $("#edit_user_btn").click(function () {

        $('.loading').show();
        $('.json-overlay').show();

        var fname, lname, email, user_type, id;
        var userid = getUrlParameter('userid');
        var username = $("#username").val();
        fname = $("#fname").val();
        lname = $("#lname").val();
        email = $("#email").val();
        user_type = $("#user_type option:selected").val();

        $.ajax({
            type: "POST",
            url: siteroot + "/admin_area/Dashboard/save_edited_user.php",
            async: true,
            data: { userid: userid, username: username, fname: fname, lname: lname, email: email, user_type: user_type },
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

    $("#admin_reset_pwd").click(function () {
        $('.loading').show();
        $('.json-overlay').show();
        var response = confirm("Are you sure you want to reset the password for this user?");
        if (response == true) {
            var userid = getUrlParameter('userid');
            $.ajax({
                type: "POST",
                url: siteroot + "/admin_area/Dashboard/admin_functions.php",
                async: true,
                data: { admin_reset_pwd: "", userid: userid },
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
        } else {
            console.log("You pressed Cancel!");
            $('.loading').hide();
            $('.json-overlay').hide();
        }
    });

    $("#del_user_btn").click(function () {
        $('.loading').show();
        $('.json-overlay').show();
        var response = confirm("Are you sure you want to delete this user?");
        if (response == true) {
            var userid = getUrlParameter('userid');
            $.ajax({
                type: "POST",
                url: siteroot + "/admin_area/Dashboard/admin_functions.php",
                async: true,
                data: { del_user_btn: "", userid: userid },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Success: " + result);
                    window.location.href = siteroot + '/admin_area/Dashboard/users.php';
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
        } else {
            console.log("You pressed Cancel!");
            $('.loading').hide();
            $('.json-overlay').hide();
        }
    });

    $("#cancel_order_btn").click(function () {
        location.reload(true);
        return false;
    });

    $("#del_order_btn").click(function () {
        $('.loading').show();
        $('.json-overlay').show();
        var response = confirm("Are you sure you want to delete order?");
        if (response == true) {
            var order_id = getUrlParameter('order');
            $.ajax({
                type: "POST",
                url: siteroot + "/admin_area/Dashboard/admin_functions.php",
                async: false,
                data: { del_order: "", order_id: order_id },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert(result);
                    window.location.href = siteroot + '/admin_area/Dashboard/order.php';
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
        } else {
            console.log("You pressed Cancel!");
            $('.loading').hide();
            $('.json-overlay').hide();
        }
        return false;
    });

    if ($("#side_menu").is(":visible")) {
        $("#toggle-sidebar-btn").css('visibility', 'hidden');
    }
    else {
        $("#toggle-sidebar-btn").css('visibility', 'visible');
    }

    $("#toggle-sidebar-btn").click(function (event) {
        event.preventDefault();
        if ($("#side_menu").is(":visible")) {
            $("#side_menu").addClass("d-none");
        }
        else {
            $("#side_menu").removeClass("d-none");
            $("#first-item").css("margin-top", "50px");
        }
        // return false;
    });

    window.onresize = function () {
        if ($("#side_menu").is(":visible")) {
            $("#toggle-sidebar-btn").css('visibility', 'hidden');
        }
        else {
            $("#toggle-sidebar-btn").css('visibility', 'visible');
        }

        $("#toggle-sidebar-btn").click(function (event) {
            event.preventDefault();
            if ($("#side_menu").is(":visible")) {
                $("#side_menu").addClass("d-none");
            }
            else {
                $("#side_menu").removeClass("d-none");
                $("#first-item").css("margin-top", "50px");
            }
        });
    }



}); // end of jQuery(document)
