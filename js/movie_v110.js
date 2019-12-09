
/******************************************* INIT SCREEN ********************************************/

var pager_index = [1, 1, 1, 1, 1, 1];

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

    // Buttons

    if (crowdfunding_url != "") {  
        $("img#crowdfunding").show();
        $("a#crowdfunding").attr("href", crowdfunding_url);
    }
    
    if (content_id == "irrintzina_le_cri_de_la_generation_climat") {
        $("img#crowdfunding").attr("src", "/img/icons/button/helloasso.png");
        $("div#donation_area_sheet").show();
    }

    if (content_id == "je_suis_contradictoire") {
        $("img#crowdfunding").attr("src", "/img/icons/button/ulule.png");
    }

    if (episod_id == "") {           
        $("img#favorite").show();
        $("img#content_reco").show();
        $("img#content_later").show();
    }

    if (is_favorite == "1") {
        $("img#favorite").css("opacity", "0.2");
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

    // Specific cases

    if (content_id == "en_quete_de_sens" && episod_id != "") $("div#eqds_button").show();

    if (type_id == "shortfilm") {
        if (window.innerWidth < trigger_width)
            $("section#information").css("margin-top", "70vw")
    }

    for (index = 0; index <= 7; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    } 

    $("img.arrow_page").hide();
    $("img.donation").jrumble({x:0, y:0, rotation:10});

    if (window.innerWidth > trigger_width) {
        $("div.info_panorama, div.info_portrait, div.info_squared").hide();
    }

    if (content_id == "irrintzina_le_cri_de_la_generation_climat" && episod_id != "") {
        $("div#donation_area").show();
    } 

    set_mosaic_mode();

    // listen mouse over, scroll and resize

    // if (env != "prod" && status == "admin") listen_name();

    listen_author();
    listen_category();
    listen_producer();
    listen_my_contents();
    listen_buttons();
    // listen_note();
    // listen_note_setting();
    



    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail(comment_list);

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (episod_id != "")
        launch_player("first", type_id, content_id, section_id, episod_id);

    // if (video_id != "") launch_video_player(hosting, episod_id, video_id, timecode);
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width) {
        // move_element("img.background_image", 0.04, 0.5); 
        screen_scroll();
    }
    else {
        move_element("img.cover_image", 0.15, 0.5);
        $("img#close_player").css("left", "");
    }
};


/********************************************** SCROLL *********************************************/

function screen_scroll() {

        // Opacity management

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

        if (window.scrollY >= trigger_2) {$("div#note_1, div#note_2, div#note_3").hide()}
        else if (window.scrollY < trigger_2) {$("div#note_1, div#note_2, div#note_3").show()}

        if (window.scrollY >= trigger_3) {$("div.date, div.duration, div.category, div.info").hide()}
        else if (window.scrollY < trigger_3) {$("div.date, div.duration, div.category, div.info").show()}

        if (window.scrollY >= trigger_4) {$("div.description").hide()}
        else if (window.scrollY < trigger_4) {$("div.description").show()}
}

