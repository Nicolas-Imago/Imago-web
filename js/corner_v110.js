
/************************************************ INIT **********************************************/

var pager_index = [1, 1, 1, 1, 1, 1, 1, 1];

// streaming = streaming_type_of(hosting);

init_screen();

function init_screen() {

    // Display screen

    screen_update();
    set_cookie("url_cookie", page_url, 1);

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    for (index = 1; index <= 8; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1) 
            $("img#right_arrow_container_" + index).hide();
    }

    if (window.innerWidth > trigger_width)
        $("div.info_panorama, div.info_portrait, div.info_squared").hide();

    // listen mouse over, scroll and resize

    // listen_button();

    listen_buttons();

    listen_corner_content_thumbnail();

    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    if (video_id != "" && type_id != "podcast") launch_video_player(hosting, video_id);
    if (video_id != "" && type_id == "podcast") launch_audio_player(hosting, episod_id, video_id, timecode); 
}


/********************************************* QUERY **********************************************/

// function listen_button() {

//     // Listen mouse over

//     $("a#validate_button").hover(function() {
//         $(this).css("cursor","pointer"); 
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("a#validate_button").click(function() {
//         document.getElementById("form").submit();      
//     });
// }


function listen_corner_content_thumbnail() {

    // Listen mouse over

    $("div.thumbnail_info").hover(function() {
        $(this).css("cursor","pointer");

        list_id = this.id.split("-")[0];
        index = this.id.split("-")[1];
        thumbnail_type = this.id.split("-")[2];
        type_id = this.id.split("-")[3];
        content_id = this.id.split("-")[4];
        section_id = this.id.split("-")[5];
        episod_id = this.id.split("-")[6];

        console.log("list_id = " + list_id);
        console.log("index = " + index); 
        console.log("thumbnail_type = " + thumbnail_type);      
        console.log("type_id = " + type_id);
        console.log("content_id = " + content_id);
        console.log("section_id = " + section_id);
        console.log("episod_id = " + episod_id);
        console.log();

        if (window.innerWidth > trigger_width) {
            $("div#info_" + content_id + '_' + episod_id).fadeIn(200);
        }

    },function() {
        $(this).css("cursor","auto");

        if (window.innerWidth > trigger_width) {
            $("div#info_" + content_id + '_' + episod_id).hide();
        }
    });

    // Listen click on

    $("div.thumbnail_info").click(function() {

        go_to("/php/corner.php?corner_id=" + corner_id + "&content_id=" + content_id + "&episod_id=" + episod_id);

    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    current_scroll = window.scrollY;

    if (window.innerWidth > trigger_width) {
        header_height = 0.04 * window.innerWidth; 
        image_top = header_height + 0.5 * (current_scroll);
        console.log(image_top);
        $("img#banner_image").css("top", image_top);

        // if (streaming == "audio" && video_id != "") {$("img#close_player").css("left", "64vw");}
        // if (streaming == "video" && video_id != "") {$("img#close_player").css("left", "74vw");}     
    }
    else {
        header_height = 0.15 * window.innerWidth;
        image_top = header_height + 0.5 * (current_scroll);
        $("img#banner_image").css("top", image_top);
        // $("img#close_player").css("left", "");
    }

    // screen_scroll();
}


/********************************************** SCROLL *********************************************/

function screen_scroll() {

    // console.log(current_scroll);

    if (window.innerWidth > trigger_width) {

        // Opacity management

        trigger_1 = 0;                              speed_1 = 0.25 * window.innerWidth;
        trigger_2 = 0;                              speed_2 = 0.03 * window.innerWidth;
        trigger_3 = 0.06 * window.innerWidth;       speed_3 = 0.04 * window.innerWidth;
        trigger_4 = 0.12 * window.innerWidth;       speed_4 = 0.04 * window.innerWidth;
        trigger_5 = 0.22 * window.innerWidth;       speed_5 = 0.04 * window.innerWidth;  

        image_opacity_1 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_1) / speed_1)));
        image_opacity_2 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_2) / speed_2)));
        image_opacity_3 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_3) / speed_3)));
        image_opacity_4 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_4) / speed_4)));
        image_opacity_5 = Math.max(0, (Math.min(1, 1 - (current_scroll - trigger_5) / speed_5)));

        $("img.background_image").css("opacity", image_opacity_1);
        $("div#note_1, div#note_2, div#note_3").css("opacity", image_opacity_2);
        $("div.number, div.duration, div.category, div.info").css("opacity", image_opacity_3);
        $("div.description").css("opacity", image_opacity_4);
        $("a.author, img.author_image").css("opacity", image_opacity_5);  

        if (current_scroll >= trigger_3) {$("div#note_1, div#note_2, div#note_3").hide()}
        else if (current_scroll < trigger_3) {$("div#note_1, div#note_2, div#note_3").show()}

        if (current_scroll >= trigger_4) {$("div.number, div.duration, div.category, div.info").hide()}
        else if (current_scroll < trigger_4) {$("div.number, div.duration, div.category, div.info").show()}

        if (current_scroll >= trigger_5) {$("div.description").hide()}
        else if (current_scroll < trigger_5) {$("div.description").show()}


        // Scroll management

        trigger_fixed = 0.27 * window.innerWidth;

        if (current_scroll >= trigger_fixed) {
            $("div#season_list").addClass("fixed");
            $("#video_thumbnail").addClass("fixed");
            $("div#shadow_info").show();
        }
        else {
            $("div#season_list").removeClass("fixed");
            $("#video_thumbnail").removeClass("fixed");
            $("div#shadow_info").hide();
        }
    }
}