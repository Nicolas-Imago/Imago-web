
/******************************************* INIT SCREEN ********************************************/

var format = get_cookie("display_mode");
if (format != "grid" && format != "list") format = "grid";

var pager_index = [1, 1, 1, 1, 1, 1];

var timecode = 0;

var note_value = new Array();
note_value[1] = note_1;
note_value[2] = note_2;
note_value[3] = note_3;

init_screen();

function init_screen() {

    // Display screen

    screen_update();
    set_cookie("url_cookie", page_url, 1);

    $("div#screen").fadeIn(1000);
    $("div#footer").show(); 

    $("a#season_" + current_season).css("color", "white");
    $("div.video_thumbnail_season").hide();
    $("div#video_thumbnail_season_" + current_season).show();
    // display_season(); Fonction remplacé par la ligne au dessus

    // Specific cases

    if (fact_check_url != "") $("img#fact_check").show();
    if (crowdfunding_url != "") $("img#crowdfunding").show();

    $("img.my_content").show();

    if (is_favorite == "1") {
        $("img#favorite").css("opacity", "0.2");
        $("img#heart").show();
    }

    if (watch_later == "1") {
        $("img#watch_later").css("opacity", "0.2");
        $("img#time").show();
    }

    if (has_comment == "1") {
        $("img#comment").css("opacity", "0.2");
        $("img#lines").show();
    }

    if (video_id != "") {
        $("div#button_header, img.sharing").addClass("player");
    }

    if (type_id == "music") {
        $("img#crowdfunding").attr("src", "../img/icons/button/buy.png");
    }

    if (window.innerWidth < trigger_width) {
        $("a#season_" + current_season).css("color", "white");
    }

    for (index = 1; index <= 6; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    }

    $("img.arrow_page").hide();

    change_display_mode(format);

    $("img.donate").jrumble({x:0, y:0, rotation:10});

    // listen mouse over, scroll and resize

    if (env != "prod" && status == "admin") listen_name();

    listen_author();
    listen_category();

    listen_my_contents();
    listen_buttons(content_id, episod_id, user_id);
    // listen_note();
    // listen_note_setting();

    listen_seasons_buttons();
    listen_display_mode(format);

    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail(comment_list);  

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (video_id != "" && type_id != "podcast") launch_video_player(hosting, video_id);
    if (video_id != "" && type_id == "podcast") launch_audio_player(hosting, episod_id, video_id, timecode);
}


/********************************************** FUNCTIONS *******************************************/

// function display_season() {

//     $("div#video_thumbnail_season_" + current_season).show();

//     element_id = $("a#season_" + current_season).attr("id");
//     element = document.getElementById(element_id);
//     var selector_position = element.getBoundingClientRect().left;
//     $("img#season_selector").css("left", selector_position);

//     width = $("a#season_" + current_season).css("width")
//     $("img#season_selector").css("width", width);
//     $("img#season_selector, img#icons_selector").fadeIn(1000);

// }


/*********************************************** LISTEN *********************************************/

function listen_seasons_buttons() {

    // Listen mouse over

     $("a.season").hover(function() {
        season_id = $(this).attr("id")
        season_id = season_id.replace("season_","")

        if (season_id != current_season) $(this).css("color", "rgb(200, 200, 200)"); // gris clair remplace le blanc
        $(this).css("cursor","pointer");

        // if (season_id == current_season) {$("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_white.png")};

    },function() {
        // if (window.innerWidth < trigger_width && season_id != current_season) {
        if (season_id != current_season) $(this).css("color", "grey");   // à présent fonctionnel aussi en mode pc
        // else if (window.innerWidth > trigger_width) {

        $(this).css("cursor","auto");
        // if (season_id == current_season) {$("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_grey.png")};
    });

    // Listen click on

    $("a.season").click(function() {

        var new_season = $(this).attr("id");
        new_season = new_season.replace("season_", "");

        // element = document.getElementById(this.id);
        // selector_position = element.getBoundingClientRect().left;

        // width = $(this).css("width")

        // $("img#season_selector").animate({left : selector_position}, 500);
        // $("img#season_selector").css("width", width);

        // if (window.innerWidth < trigger_width) {
            $("a#season_" + current_season).css("color", "grey");
            $("a#season_" + new_season).css("color","white");
        // }

        $("div#video_thumbnail_season_" + current_season).fadeOut(250, function(){
            $("div#video_thumbnail_season_" + new_season).fadeIn(250);
        });

        current_season =  new_season; 

        // $("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_white.png")
    });
}

function listen_display_mode(format) {

     $("img#grid").hover(function() {
        $(this).css("cursor","pointer");
        if (format == "grid") $(this).attr("src","../img/icons/tvshow/mosaic_icon_white.png");
        if (format == "list") $(this).attr("src","../img/icons/tvshow/mosaic_icon_grey.png");
    },function() {
        $(this).css("cursor","auto");
        if (format == "grid") $(this).attr("src","../img/icons/tvshow/mosaic_icon_white.png");
        if (format == "list") $(this).attr("src","../img/icons/tvshow/mosaic_icon_dark_grey.png");
    });

     $("img#list").hover(function() {
        $(this).css("cursor","pointer");
        if (format == "grid") $(this).attr("src","../img/icons/tvshow/list_icon_grey.png");
        if (format == "list") $(this).attr("src","../img/icons/tvshow/list_icon_white.png");
    },function() {
        $(this).css("cursor","auto");
        if (format == "grid") $(this).attr("src","../img/icons/tvshow/list_icon_dark_grey.png");
        if (format == "list") $(this).attr("src","../img/icons/tvshow/list_icon_white.png");
    });

    // Listen click on

    $("img#grid").click(function() {
        format = "grid";
        change_display_mode(format);
        listen_content_thumbnail(comment_list, format);
    });

    $("img#list").click(function() {
        format = "list";
        change_display_mode(format);
        listen_content_thumbnail(comment_list, format);
    });

}

function change_display_mode(format) {

    if (format == "list") {

        $("div#video_thumbnail_season_" + current_season).hide();

        $("div.video_thumbnail_season, div.series_thumbnail_info").addClass("list");
        $("div.series_panorama, img.series_panorama, img.series_play_panorama, div.series_info_panorama").addClass("list");
        $("div.series_squared, img.series_squared, img.series_play_squared, div.series_info_squared").addClass("list");
        $("a.series_line_1, a.series_line_2, a.series_line_3, a.series_line_4").addClass("list");

        $("img#list").attr("src", "../img/icons/tvshow/list_icon_white.png");
        $("img#grid").attr("src", "../img/icons/tvshow/mosaic_icon_dark_grey.png");

        if (window.innerWidth > trigger_width)
            $("div.series_info_panorama, div.series_info_portrait, div.series_info_squared").show();

        set_cookie("display_mode", format, 1);

        $("div#video_thumbnail_season_" + current_season).fadeIn(1000);
    }

    if (format == "grid") {

        $("div#video_thumbnail_season_" + current_season).hide();

        $("div.video_thumbnail_season, div.series_thumbnail_info").removeClass("list");
        $("div.series_panorama, img.series_panorama, img.series_play_panorama, div.series_info_panorama").removeClass("list");
        $("div.series_squared, img.series_squared, img.series_play_squared, div.series_info_squared").removeClass("list");
        $("a.series_line_1, a.series_line_2, a.series_line_3, a.series_line_4").removeClass("list");

        $("img#list").attr("src", "../img/icons/tvshow/list_icon_dark_grey.png");
        $("img#grid").attr("src", "../img/icons/tvshow/mosaic_icon_white.png");

        if (window.innerWidth > trigger_width)
            $("div.series_info_panorama, div.series_info_portrait, div.series_info_squared").hide();

        set_cookie("display_mode", format, 1);

        $("div#video_thumbnail_season_" + current_season).fadeIn(1000);
    }

}

/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width) {
        move_element("img.background_image", 0.04, 0.5);
        move_element("div.background_shadow", 0.04, 0.5);

        if (type_id != "podcast" && video_id != "")  $("img#close_player").css("left", "74vw");     
        if (type_id == "podcast" && video_id != "")  $("img#close_player").css("left", "64vw");

        screen_scroll();
    }
    else {
        move_element("img.background_image", 0.15, 0.5);
        $("img#close_player").css("left", "");
    }
}


/********************************************** SCROLL *********************************************/

function screen_scroll() {

        // Opacity management

        trigger_1 = 0;                              speed_1 = 0.25 * window.innerWidth;
        trigger_2 = 0;                              speed_2 = 0.03 * window.innerWidth;
        trigger_3 = 0.06 * window.innerWidth;       speed_3 = 0.04 * window.innerWidth;
        trigger_4 = 0.12 * window.innerWidth;       speed_4 = 0.04 * window.innerWidth;
        trigger_5 = 0.22 * window.innerWidth;       speed_5 = 0.04 * window.innerWidth;  

        image_opacity_1 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_1) / speed_1)));
        image_opacity_2 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_2) / speed_2)));
        image_opacity_3 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_3) / speed_3)));
        image_opacity_4 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_4) / speed_4)));
        image_opacity_5 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_5) / speed_5)));

        $("img.background_image").css("opacity", image_opacity_1);
        $("div#note_1, div#note_2, div#note_3").css("opacity", image_opacity_2);
        $("div.number, div.duration, div.category, div.info").css("opacity", image_opacity_3);
        $("div.description").css("opacity", image_opacity_4);
        // $("a.author, img.author_image").css("opacity", image_opacity_5);  
        $("a.author, img.author_image, a.name, img.logo_image, img.sharing, img.my_content").css("opacity", image_opacity_5);  

        if (window.scrollY >= trigger_3) {$("div#note_1, div#note_2, div#note_3").hide()}
        else if (window.scrollY < trigger_3) {$("div#note_1, div#note_2, div#note_3").show()}

        if (window.scrollY >= trigger_4) {$("div.number, div.duration, div.category, div.info").hide()}
        else if (window.scrollY < trigger_4) {$("div.number, div.duration, div.category, div.info").show()}

        if (window.scrollY >= trigger_5) {$("div.description").hide()}
        else if (window.scrollY < trigger_5) {$("div.description").show()}


        // Scroll management

        // trigger_fixed = 0.27 * window.innerWidth;

        // if (window.scrollY >= trigger_fixed) {
        //     $("div#season_list").addClass("fixed");
        //     $("#video_thumbnail").addClass("fixed");
        //     $("div#shadow_info").show();
        // }
        // else {
        //     $("div#season_list").removeClass("fixed");           
        //     $("#video_thumbnail").removeClass("fixed");          // NE SERT A RIEN ?!?  //
        //     $("div#shadow_info").hide();
        // }
}

