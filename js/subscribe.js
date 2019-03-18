
/********************************************** INIT ***********************************************/

init_subscribe_screen(); 

function init_subscribe_screen() {

    // Display screen

    $("div#screen").fadeIn(2000);
    $("div#footer").show();

    // listen mouse over, scroll and resize

    listen_subscribe_button();
    listen_enter_button();

    addEventListener("resize", close_menu_and_user, false);
}


/*********************************************** LISTEN *********************************************/

function listen_enter_button() {

    // Listen mouse over

    $("a#enter").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#enter").click(function() {
        go_to("/php/homepage.php");
    });
}

function listen_subscribe_button() {

    // Listen mouse over

    $("a#subscribe_update_button").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#subscribe_update_button").click(function() {
        document.getElementById("form").submit();      
    });
}