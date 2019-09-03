
/************************************************ INIT **********************************************/

var pager_index = [1, 1, 1, 1, 1, 1, 1, 1];

init_screen();


function init_screen() {

    // Display screen

    screen_update();
    set_cookie("url_cookie", page_url, 1);

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    if (screen != "search" && screen != "friend")
        $("section#query").hide();

    $("input#query").focus();

    $('input#query').keypress(function(event){
        keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') 
            document.getElementById("form").submit();   
    });

    for (index = 1; index <= 8; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    }

    if (window.innerWidth > trigger_width) {
        $("div.info_panorama, div.info_portrait, div.info_squared, div.info_rounded").hide();
        $("div.series_info_panorama, div.series_info_squared").hide();
    }

    // listen mouse over, scroll and resize

    listen_buttons();

    listen_validation_button();

    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);
}


/********************************************* QUERY **********************************************/

function listen_validation_button() {

    // Listen mouse over

    $("a#validate_button").hover(function() {
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#validate_button").click(function() {
        document.getElementById("form").submit();      
    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width) {
        move_element("img#banner", 0.04, 0.5);   
    }
    else {
        move_element("img#banner", 0.15, 0.5);
    }
}
