
/********************************************** INIT ***********************************************/

init_screen();

function init_screen() {

    // Display header

    $("a#title_text_1").hide();
    $("a#title_text_2").hide();
    $("a#title_text_3").hide();

    // Display screen

    screen_update();

    $("div#screen").fadeIn(1000);
    $("div#footer").show();  

    // listen mouse over, scroll and resize

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width) { $("img#imago_logo").css("width", "14vw") }
    if (window.innerWidth < trigger_width) { $("img#imago_logo").css("width", "40vw") }

    if (window.innerWidth > trigger_width) {
        image_position = 0.4 * window.innerWidth;
        $("img#background").css("left", image_position);
    }
    if (window.innerWidth < trigger_width) { $("img#background").css("left", "0") }

    screen_scroll();
};


/********************************************** SCROLL *********************************************/

function screen_scroll() {

    if (window.innerWidth > trigger_width) { var header_height = 4 * window.innerWidth / 100 }
    if (window.innerWidth < trigger_width) { var header_height = 15 * window.innerWidth / 100 }

    current_scroll = window.scrollY;

    image_opacity = Math.max(0, (Math.min(1, 1 - (current_scroll) / 400)));
    image_top = header_height + 0.2 * (current_scroll); 

    $("img#background").css("opacity", image_opacity);
    $("img#background").css("top", image_top);  
}



