
// var format = get_cookie("display_mode");
// if (format != "grid" && format != "list") format = "list";

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

    // $("a#season_" + current_season).css("color", "white");
    // $("div.video_thumbnail_season").hide();
    // $("div#video_thumbnail_season_" + current_season).show();

    // if (window.innerWidth < trigger_width)
    //     $("a#season_" + current_season).css("color", "white");

    // Buttons

    $("img.donation").jrumble({x:0, y:0, rotation:10});

    if (crowdfunding_url != "") {  
        $("img#crowdfunding").show();
        $("a#crowdfunding").attr("href", crowdfunding_url);
    }
    
    if (content_id == "irrintzina_le_cri_de_la_generation_climat")
        $("img#crowdfunding").attr("src", "/img/icons/button/helloasso.png");

    if (content_id == "je_suis_contradictoire")
        $("img#crowdfunding").attr("src", "/img/icons/button/ulule.png");
    

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

    if (type_id == "shortfilm")
        if (window.innerWidth < trigger_width)
            $("section#information").css("margin-top", "70vw")


    set_mosaic_mode();

    // listen mouse over, scroll and resize

    listen_author();
    listen_category();
    listen_producer();
    listen_my_contents();
    listen_buttons();
    
    // listen_seasons_buttons();
    // listen_display_mode(format);

    listen_container();
    listen_content_thumbnail(comment_list);

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (episod_id != "")
        launch_player("first", type_id, content_id, section_id, episod_id);
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width)
        screen_scroll();
    else
        move_element("img.cover_image", 0.15, 0.5);
};


/********************************************** SCROLL *********************************************/

function screen_scroll() {

        trigger_1 = 0;                              speed_1 = 0.03 * window.innerWidth;
        trigger_2 = 0.06 * window.innerWidth;       speed_2 = 0.04 * window.innerWidth;
        trigger_3 = 0.12 * window.innerWidth;       speed_3 = 0.06 * window.innerWidth;
        trigger_4 = 0.20 * window.innerWidth;       speed_4 = 0.06 * window.innerWidth;  

        image_opacity_1 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_1) / speed_1)));
        image_opacity_2 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_2) / speed_2)));
        image_opacity_3 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_3) / speed_3)));
        image_opacity_4 = Math.max(0, (Math.min(1, 1 - (window.scrollY - trigger_4) / speed_4)));

        $("div#note_1, div#note_2, div#note_3").css("opacity", image_opacity_1);
        $("div.date, div.duration, div.category, div.info").css("opacity", image_opacity_2);
        $("div.description").css("opacity", image_opacity_3);        
        $("a.author, h1.name, section#button_list").css("opacity", image_opacity_4);
}

