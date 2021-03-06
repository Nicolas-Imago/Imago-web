
var format = get_cookie("display_mode");
if (format != "grid" && format != "list") format = "list";

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

    $("a#link").removeAttr("href");

    // Seasons

    $("a#season_" + current_season).css("color", "white");
    $("div.video_thumbnail_season").hide();
    $("div#video_thumbnail_season_" + current_season).show();

    if (window.innerWidth < trigger_width)
        $("a#season_" + current_season).css("color", "white");

    // Buttons

    $("img.donation").jrumble({x:0, y:0, rotation:10});

    if (crowdfunding_url != "") {  
        $("img#crowdfunding").show();
        $("a#crowdfunding").attr("href", crowdfunding_url);
    }

    if (content_id == "tuto_anti_creatif")
        $("img#crowdfunding").attr("src", "/img/icons/button/utip.png");

    if (content_id == "kalune_aimer")     
        $("img#crowdfunding").attr("src", "/img/icons/button/buy.png");


    $("img#content_favorite, img#content_reco, img#content_later").show();

    if (is_content_favorite == "1") {
        $("img#content_favorite").css("opacity", "0.2");
        if (window.innerWidth < trigger_width)      $("img#heart_mobile").show();
        if (window.innerWidth > trigger_width)      $("img#heart_pc").show();
    }

    if (is_content_later == "1") {
        $("img#content_later").css("opacity", "0.2");
        if (window.innerWidth < trigger_width)      $("img#time_mobile").show();
        if (window.innerWidth > trigger_width)      $("img#time_pc").show();    
    }

    if (is_content_reco == "1") {
        $("img#content_reco").css("opacity", "0.2");
        if (window.innerWidth < trigger_width)      $("img#medal_mobile").show();
        if (window.innerWidth > trigger_width)      $("img#medal_pc").show();    
    }

    // Thumbnails

    if (window.innerWidth > trigger_width)
        $("div.info_panorama, div.info_portrait, div.info_squared").hide();

    if (type_id == "tvshow")    $("div.resume_bar_13").hide();
    if (type_id == "podcast")   $("div.resume_bar_21").hide();


    change_display_mode(format);
    set_mosaic_mode();

    // listen mouse over, scroll and resize

    listen_author();
    listen_category();
    // listen_producer();
    listen_my_contents();
    listen_buttons();

    listen_seasons_buttons();
    listen_display_mode(format);

    listen_container();
    listen_content_thumbnail(comment_list);  

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (episod_id != "")
        launch_player("first", type_id, content_id, section_id, episod_id);
}

/*********************************************** LISTEN *********************************************/

function listen_seasons_buttons() {

    // Listen mouse over

     $("a.season").hover(function() {
        season_id = $(this).attr("id")
        season_id = season_id.replace("season_","")

        if (season_id != current_season) $(this).css("color", "rgb(200, 200, 200)");
        $(this).css("cursor","pointer");

    },function() {
        if (season_id != current_season) $(this).css("color", "grey");   
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a.season").click(function() {

        var new_season = $(this).attr("id");
        new_season = new_season.replace("season_", "");

        $("a#season_" + current_season).css("color", "grey");
        $("a#season_" + new_season).css("color","white");

        $("div#video_thumbnail_season_" + current_season).fadeOut(250, function(){
            $("div#video_thumbnail_season_" + new_season).fadeIn(250);
        });

        current_season =  new_season; 
    });
}

function listen_display_mode(format) {

     $("img#grid").hover(function() {
        $(this).css("cursor","pointer");
        if (format == "grid") $(this).attr("src","/img/icons/tvshow/mosaic_icon_white.png");
        if (format == "list") $(this).attr("src","/img/icons/tvshow/mosaic_icon_grey.png");
    },function() {
        $(this).css("cursor","auto");
        if (format == "grid") $(this).attr("src","/img/icons/tvshow/mosaic_icon_white.png");
        if (format == "list") $(this).attr("src","/img/icons/tvshow/mosaic_icon_dark_grey.png");
    });

     $("img#list").hover(function() {
        $(this).css("cursor","pointer");
        if (format == "grid") $(this).attr("src","/img/icons/tvshow/list_icon_grey.png");
        if (format == "list") $(this).attr("src","/img/icons/tvshow/list_icon_white.png");
    },function() {
        $(this).css("cursor","auto");
        if (format == "grid") $(this).attr("src","/img/icons/tvshow/list_icon_dark_grey.png");
        if (format == "list") $(this).attr("src","/img/icons/tvshow/list_icon_white.png");
    });

    // Listen click on

    $("img#grid").click(function() {
        format = "grid";
        change_display_mode(format);
    });

    $("img#list").click(function() {
        format = "list";
        change_display_mode(format);
    });

}

function change_display_mode(format) {

    if (format == "list") {

        $("div#video_thumbnail_season_" + current_season).hide();

        $("div.video_thumbnail_season, div.series_thumbnail_info").addClass("list");
        $("div.series_panorama, img.series_panorama, img.series_play_panorama, div.series_info_panorama").addClass("list");
        $("div.series_squared, img.series_squared, img.series_play_squared, div.series_info_squared").addClass("list");
        $("div.resume_bar_13, div.resume_bar_21, div.resume_bar_45").addClass("list");
        $("a.series_line_1, a.series_line_2, a.series_line_3, a.series_line_4").addClass("list");

        $("img#list").attr("src", "/img/icons/tvshow/list_icon_white.png");
        $("img#grid").attr("src", "/img/icons/tvshow/mosaic_icon_dark_grey.png");

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
        $("div.resume_bar_13, div.resume_bar_21, div.resume_bar_45").removeClass("list");
        $("a.series_line_1, a.series_line_2, a.series_line_3, a.series_line_4").removeClass("list");

        $("img#list").attr("src", "/img/icons/tvshow/list_icon_dark_grey.png");
        $("img#grid").attr("src", "/img/icons/tvshow/mosaic_icon_white.png");

        if (window.innerWidth > trigger_width)
            $("div.series_info_panorama, div.series_info_portrait, div.series_info_squared").hide();

        set_cookie("display_mode", format, 1);

        $("div#video_thumbnail_season_" + current_season).fadeIn(1000);
    }

}

/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width)
        screen_scroll();
    else
        move_element("img.background_image", 0.15, 0.5);
}


/********************************************** SCROLL *********************************************/

function screen_scroll() {

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
        $("a.author, h1.name, img.logo_image, section#button_list").css("opacity", image_opacity_5);  
}

