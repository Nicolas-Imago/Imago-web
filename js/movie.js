
/******************************************* INIT SCREEN ********************************************/

var note_value = new Array();
note_value[1] = note_1;
note_value[2] = note_2;
note_value[3] = note_3;

init_screen();

function init_screen() {

    // Display screen

    screen_update();

    $("div#screen").fadeIn(1000);
    $("div#footer").show(); 

    if (type_id == "shortfilm") {
        $("section#link").hide()
        if (window.innerWidth < trigger_width) {
            $("section#information").css("margin-top", "70vw")
        }
    } 

    // listen mouse over, scroll and resize

    //listen_name();
    listen_author();
    listen_social_network();
    // listen_note();
    // listen_note_setting();
    listen_thumbnails("movie");

    listen_producer();
    listen_vod_icon();
    listen_dvd_icon();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    console.log(video_id);
 
    if (video_id != "") {launch_video_player(hosting, video_id)}

 }


/*********************************************** LISTEN *********************************************/

function listen_producer() {

    // Listen mouse over

    $("a.info").hover(function() {
        $(this).css("color", "white");
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("color", "grey");
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("a.info").click(function() {
        go_to("/php/creator.php?type_id=producer&creator_id=" + producer_id);
    });
}

function listen_vod_icon() {

    // Listen mouse over

    $("img#vod_image").hover(function() {
        if (vod == true) {
            $(this).attr("src", "../img/documentary/icons/vod_logo_white.png");
            $(this).css("cursor","pointer");
        }
    },function() {
        if (vod == true) {
            $(this).attr("src", "../img/documentary/icons/vod_logo_grey.png"); 
            $(this).css("cursor","auto");
        }
    });
}

function listen_dvd_icon() {

    $("img#dvd_image").hover(function() {
        if (dvd == true) {
            $(this).attr("src", "../img/documentary/icons/dvd_logo_white.png");
            $(this).css("cursor","pointer");
        }
    },function() {
        if (dvd == true) {
            $(this).attr("src", "../img/documentary/icons/dvd_logo_grey.png"); 
            $(this).css("cursor","auto");
        }
    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    current_scroll = window.scrollY;

    if (window.innerWidth > trigger_width) {
        $("img.cover_image").css("top", "6vw");
        $("img.cover_image").css("opacity", "1");
        $("img#close_player").css("left", "74vw");
    }
    else {
        header_height = 0.15 * window.innerWidth;
        image_top = header_height + 0.4 * (current_scroll);
        $("img.cover_image").css("top", image_top);
        $("img#close_player").css("left", "");
    }

    screen_scroll();
};


/********************************************** SCROLL *********************************************/

function screen_scroll() {

    // console.log(current_scroll);

    if (window.innerWidth > trigger_width) {

        // Opacity management

        // trigger_1 = 0;                           speed_1 = 0.30 * window.innerWidth;
        trigger_2 = 0;                              speed_2 = 0.03 * window.innerWidth;
        trigger_3 = 0.06 * window.innerWidth;       speed_3 = 0.04 * window.innerWidth;
        trigger_4 = 0.12 * window.innerWidth;       speed_4 = 0.06 * window.innerWidth;
        trigger_5 = 0.20 * window.innerWidth;       speed_5 = 0.06 * window.innerWidth;  

        // image_opacity_1 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_1) / speed_1)));
        image_opacity_2 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_2) / speed_2)));
        image_opacity_3 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_3) / speed_3)));
        image_opacity_4 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_4) / speed_4)));
        image_opacity_5 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_5) / speed_5)));

        // $("img.background_image").css("opacity", image_opacity_1);
        $("div#note_1, div#note_2, div#note_3").css("opacity", image_opacity_2);
        $("div.date, div.duration, div.category, div.info").css("opacity", image_opacity_3);
        $("div.description").css("opacity", image_opacity_4);        
        $("a.author, a.name, img.author_image").css("opacity", image_opacity_5);

        header_height = 0.04 * window.innerWidth;
        image_top = header_height + 0.8 * (current_scroll);

        $("img.background_image").css("top", image_top);

    }
}

