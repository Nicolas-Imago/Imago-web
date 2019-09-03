
/********************************************** INIT ***********************************************/

if (page_id == "qui_sommes_nous")   var item = "1";
if (page_id == "manifeste")         var item = "2";
if (page_id == "media")             var item = "3";
if (page_id == "aidez_nous")        var item = "4";
if (page_id == "faq")               var item = "5";
if (page_id == "version")           var item = "6";

init_screen(); 

function init_screen() {

    // Display screen

    screen_update();
    set_cookie("url_cookie", page_url, 1);

    $("div#screen").show();
    $("div#footer").show();

    $("a#item_" + item).css("color", "white");

    // listen mouse over, scroll and resize

    listen_item();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);
}


/*********************************************** LISTEN *********************************************/

function listen_item() {

    // Listen mouse over

    $("a.item").hover(function() {
        $(this).css("cursor","pointer"); 
        $(this).css("color", "rgb(200, 200, 200)");
		$("a#item_" + item).css("color", "white");       
    }, function() {
        $(this).css("cursor","auto"); 
        $(this).css("color", "grey");
        $("a#item_" + item).css("color", "white");
    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

}

