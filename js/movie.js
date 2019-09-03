
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

    if (content_id == "en_quete_de_sens" && video_id != "") $("div#eqds_button").show();

    if (type_id == "shortfilm") {
        $("section#link").hide()
        if (window.innerWidth < trigger_width)
            $("section#information").css("margin-top", "70vw")
    }

    for (index = 1; index <= 6; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    } 

    $("img.arrow_page").hide();

    $("img.donate").jrumble({x:0, y:0, rotation:10});

    // listen mouse over, scroll and resize

    if (env != "prod" && status == "admin") listen_name();

    listen_author();
    listen_category();
    listen_producer();
    listen_my_contents();
    listen_buttons(content_id, episod_id, user_id);
    // listen_note();
    // listen_note_setting();
    

    listen_content_thumbnail();

    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail(comment_list);

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (video_id != "") launch_video_player(hosting, video_id);
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
        $("a.author, a.name, img.author_image").css("opacity", image_opacity_4);
}

