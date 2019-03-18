
/******************************************* INIT SCREEN ********************************************/

var note_value = new Array();
note_value[1] = note_1;
note_value[2] = note_2;
note_value[3] = note_3;

console.log("hosting = " + hosting);
console.log("is favorite = " + is_favorite);

if (hosting == "youtube" || hosting == "vimeo" || hosting == "dailymotion" || hosting == "facebook") {
    streaming = "video";
}

else if (hosting == "peertube" || hosting == "wetube") {
    streaming = "video";
}

else if (hosting == "arte" || hosting == "ftv") {
    streaming = "video";
}

else if (hosting == "wix" || hosting == "soundcloud" || hosting == "pippa") {
    streaming = "audio";
}

else {
    streaming = "";
}

init_screen();

function init_screen() {

    // Display screen

    screen_update();

    $("div#screen").fadeIn(1000);
    $("div#footer").show(); 

    $("div.video_thumbnail_season").hide();
    display_season();

    $("div.info_panorama").hide();
    $("div.info_portrait").hide();
    $("div.info_squared").hide();

    // listen mouse over, scroll and resize

    // listen_name();
    listen_author();
    listen_social_network();
    // listen_note();
    // listen_note_setting();
    listen_thumbnails("series");

    listen_seasons_buttons();

    addEventListener("resize", screen_update, false);
    addEventListener("scroll", screen_update, false);

    console.log("streaming = " + streaming);
    console.log("current_season = " + video_id);

    if (streaming == "audio" && video_id != "") {launch_audio_player(hosting, video_id)}
    if (streaming == "video" && video_id != "") {launch_video_player(hosting, video_id)} 
 }


/********************************************** FUNCTIONS *******************************************/

function display_season() {

    $("div#video_thumbnail_season_" + current_season).show();

    element_id = $("a#season_" + current_season).attr("id");
    element = document.getElementById(element_id);
    var selector_position = element.getBoundingClientRect().left;
    $("img#season_selector").css("left", selector_position);

    width = $("a#season_" + current_season).css("width")
    $("img#season_selector").css("width", width);
    $("img#season_selector, img#icons_selector").fadeIn(1000);

}


/*********************************************** LISTEN *********************************************/

function listen_seasons_buttons() {

    // Listen mouse over

     $("a.season").hover(function() {
        $(this).css("color", "white");
        $(this).css("cursor","pointer");

        season_id = $(this).attr("id")
        season_id = season_id.replace("season_","")
        if (season_id == current_season) {$("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_white.png")};

    },function() {
        $(this).css("color", "grey");
        $(this).css("cursor","auto");
        if (season_id == current_season) {$("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_grey.png")};
    });

    // Listen click on

    $("a.season").click(function() {

        var new_season = $(this).attr("id");
        new_season = new_season.replace("season_", "");

        element = document.getElementById(this.id);
        selector_position = element.getBoundingClientRect().left;
        width = $(this).css("width")

        $("img#season_selector").animate({left : selector_position}, 500);
        $("img#season_selector").css("width", width);

        $("div#video_thumbnail_season_" + current_season).fadeOut(250, function(){
            $("div#video_thumbnail_season_" + new_season).fadeIn(250);
        });

        current_season =  new_season; 

        $("img#season_selector").attr("src", "../img/icons/tvshow/season_selector_white.png")
    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    current_scroll = window.scrollY;

    if (window.innerWidth > trigger_width) {
        header_height = 0.04 * window.innerWidth; 
        image_top = header_height + 0.5 * (current_scroll);
        $("img.background_image, div.background_shadow").css("top", image_top);

        if (streaming == "audio" && video_id != "") {$("img#close_player").css("left", "64vw");}
        if (streaming == "video" && video_id != "") {$("img#close_player").css("left", "74vw");}     
    }
    else {
        header_height = 0.15 * window.innerWidth;
        image_top = header_height + 0.5 * (current_scroll);
        $("img.background_image").css("top", image_top);
        $("img#close_player").css("left", "");
    }

    screen_scroll();
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
        $("div.duration, div.category, div.info").css("opacity", image_opacity_3);
        $("div.description").css("opacity", image_opacity_4);
        $("a.author, img.author_image").css("opacity", image_opacity_5);  

        if (current_scroll >= trigger_3) {$("div#note_1, div#note_2, div#note_3").hide()}
        else if (current_scroll < trigger_3) {$("div#note_1, div#note_2, div#note_3").show()}

        if (current_scroll >= trigger_4) {$("div.duration, div.category, div.info").hide()}
        else if (current_scroll < trigger_4) {$("div.duration, div.category, div.info").show()}

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

