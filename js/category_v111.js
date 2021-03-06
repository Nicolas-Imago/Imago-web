
/************************************************ INIT **********************************************/

var pager_index = [1, 1, 1, 1, 1, 1, 1, 1];

init_screen(); 

function init_screen() {

    // Display screen

    set_cookie("url_cookie", page_url, 1);

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    title = $("h1.screen_title").text();
    $("h1.screen_title").text(title + "(" + total_item_number + ")");

    for (index = 1; index <= 8; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    }

    if (window.innerWidth > trigger_width) 
        $("div.info_panorama, div.info_portrait, div.info_squared").hide();

    // Switch Mosaic / Horizontal scroll
    
    if (type_id != "" && category_id != "") {
        $("a.title").hide();
        set_mosaic_mode();
    }

    // iPad management
    
    if (navigator.userAgent.match(/iPad/i) != null)
        $("div.list_container").addClass("ipad");


    // listen mouse over, scroll and resize

    listen_buttons();

    // listen_title();
    
    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail();

    listen_left_page_arrow();
    listen_right_page_arrow();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);
}


/*********************************************** LISTEN *********************************************/

function listen_title() {

    // Listen mouse over

    $("a.title").hover(function() {
        $(this).css("color", "white");
    },function() {
        $(this).css("color", "grey");
    });
}

/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();
}

