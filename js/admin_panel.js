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
        window.location.href = siteroot + '/admin_area/create_user.php';
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

    if ($("#users").hasClass("active")) {
        $("#submenu1").collapse("show");
    }

    $("#edit_user_btn").click(function () {

        $('.loading').show();
        $('.json-overlay').show();

        var fname, lname, email, user_type, id;
        var userid = getUrlParameter('userid');
        fname = $("#fname").val();
        lname = $("#lname").val();
        email = $("#email").val();
        user_type = $("#user_type option:selected").val();

        $.ajax({
            type: "POST",
            url: siteroot + "/admin_area/Dashboard/save_edited_user.php",
            async: false,
            data: { userid: userid, fname: fname, lname: lname, email: email, user_type: user_type },
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

}); // end of jQuery(document)
