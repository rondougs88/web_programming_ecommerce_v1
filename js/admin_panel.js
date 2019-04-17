jQuery(document).ready(function () {

    var siteroot = "http://localhost/web_programming_ecommerce_v1";

    $('.loading').hide();
    $('.json-overlay').hide();

    $(window).on("beforeunload", function () {
        $('.loading').show();
        $('.json-overlay').show();
    });

    $("a.nav-link").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    $("#admin_create_user").click(function() {
        window.location.href = siteroot + '/admin_area/create_user.php' ;
    });

    if(location.pathname.indexOf("users.php") != -1){
        $("#users").addClass('active').siblings().removeClass('active');
        $("a.nav-link#viewusers").addClass('active').siblings().removeClass('active');
    }

    if(location.pathname.indexOf("admin_create_user.php") != -1){
        $("#users").addClass('active').siblings().removeClass('active');
        $("#createuser").addClass('active').siblings().removeClass('active');
        $("a.nav-link#createuser").addClass('active').siblings().removeClass('active');
    }    

    // $("a.nav-link.sub-item").click(function() {
    //     $(this).addClass('active').siblings().removeClass('active');
    // });

    if ($("#users").hasClass("active")) {
        $("#submenu1").collapse("show");
    }

}); // end of jQuery(document)