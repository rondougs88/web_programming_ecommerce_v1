jQuery(document).ready(function () {

    $('.loading').hide();
    $('.json-overlay').hide();

    $(window).on("beforeunload", function () {
        $('.loading').show();
        $('.json-overlay').show();
    });

    $("a.nav-link").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    if(location.pathname.indexOf("users.php") != -1){
        $("#users").addClass('active').siblings().removeClass('active');
    }

}); // end of jQuery(document)