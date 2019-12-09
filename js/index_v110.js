
/********************************************** INIT ***********************************************/

init_screen();

function init_screen() {

    // Display screen

    $("div#splashscreen").fadeIn(2000);
    $("a#imago_version").text("ImagoTV - v" + version)

    // listen mouse over, scroll and resize

    listen_splashscreen_image();
}


function listen_splashscreen_image() {

    // Listen mouse over

    $("img#splashscreen_image").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img#splashscreen_image").click(function() {
        go_to("/php/homepage.php");
    });      

}





