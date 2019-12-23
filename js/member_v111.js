
/********************************************** INIT ***********************************************/

init_member_screen(); 

function init_member_screen() {

    // Display screen

    $("div#screen").fadeIn(2000);
    $("div#footer").show();

    // listen mouse over, scroll and resize

    listen_button_member();
    addEventListener("resize", close_menu_and_user, false);
}


/********************************************* ACTION **********************************************/

function listen_button_member() {

    // Listen mouse over

    $("a#member_update_button").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#member_update_button").click(function() {
        document.getElementById("form").submit();      
    });
}
