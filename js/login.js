
/********************************************** INIT ***********************************************/

init_tvshow_screen();

function init_tvshow_screen() {

    // Display screen

    $("div#screen").fadeIn(2000);
    $("div#footer").show(); 

    // listen mouse over, scroll and resize

    listen_validate_login();
    addEventListener("resize", close_menu_and_user, false);
}


/*********************************************** LISTEN *********************************************/

function listen_validate_login() {

    // Listen mouse over

    $("a.action").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#validate").click(function() {
        document.getElementById("form").submit();
    });

    $("a#enter").click(function() {
        go_to("/php/homepage.php");
    });

    $("a#logout").click(function() {
        go_to("/php/homepage.php");
    });       

    $("a#subscribe").click(function() {
        go_to("/php/subscribe.php");
    });
}





