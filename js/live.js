
/************************************************ INIT **********************************************/

var display_channel = channel;
var current_channel = channel;

var new_channel;
var video_id_now;

if (window.innerWidth > trigger_width) {$("div#footer").css("top", "50vw")}
if (window.innerWidth <= trigger_width) {$("div#footer").css("top", "150vw");}

$.getJSON("../functions/create_live_player_list.php", function(homepage_json) {
    init_live_screen(homepage_json);
});


function init_live_screen(homepage) {

    display_channel_thumbnails(homepage, channel);
    $("iframe#channel_player").attr("src", "https://www.youtube.com/embed/" + homepage[channel - 1][0]["video"] + "?autoplay=1&fs=1&color=white&showinfo=0&rel=0&mute=1&disablekb=1");  


    // Display header

    $("a#title_text_1").hide();
    $("a#title_text_2").hide();
    $("a#title_text_3").hide();

    // Display screen

    screen_update();

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    $("img#channel_logo_" + channel).attr("src", "../img/homepage/logo/channel_" + channel + ".png");

    // listen mouse over, scroll and resize

    listen_channel_thumbnails(homepage);
    listen_live_video_thumbnails(homepage);

    addEventListener("resize", screen_update, false);

}


/*********************************************** FUNCTION *********************************************/

function display_channel_thumbnails(homepage, channel) {

    now_video_id = homepage[channel - 1][0]["video"];
    next_video_id = homepage[channel - 1][1]["video"];

    now_content_id = homepage[channel - 1][0]["tvshow"];
    next_content_id = homepage[channel - 1][1]["tvshow"];

    selector_url = "../img/homepage/selector/video/" + channel + ".png";

    if (homepage[channel - 1][0]["thumbnail"] == "local") {
        now_image_url = "../img/video/" + now_content_id + "/" + now_video_id + ".jpg";
    }
    if (homepage[channel - 1][0]["thumbnail"] == "youtube") {
        now_image_url = "https://img.youtube.com/vi/" + now_video_id + "/mqdefault.jpg";
    }

    if (homepage[channel - 1][1]["thumbnail"] == "local") {
        next_image_url = "../img/video/" + next_content_id + "/" + next_video_id + ".jpg";
    }
    if (homepage[channel - 1][1]["thumbnail"] == "youtube") {
        next_image_url = "https://img.youtube.com/vi/" + next_video_id + "/mqdefault.jpg";
    }

    $("img#video_now").attr("src", now_image_url);
    $("img#video_next").attr("src", next_image_url);

    $("img#video_selector").attr("src", selector_url);

}


/*********************************************** LISTEN *********************************************/

function listen_channel_thumbnails(homepage) {

    // Listen mouse over

    $("img.channel_logo").hover(function() {
        $(this).css("cursor","pointer");

        channel_id = this.src;
        channel_id = channel_id.split("/img/homepage/logo/channel_")[1];
        channel_id = channel_id[0];

        if (channel_id != current_channel && channel_id != display_channel) {
            $(this).attr("src", "../img/homepage/logo/channel_" + channel_id + ".png");
        }

    },function() {
        $(this).css("cursor","auto");

        if (channel_id != current_channel && channel_id != display_channel) {
            $(this).attr("src", "../img/homepage/logo/channel_" + channel_id + "_grey.png");
        }
    });

    // Listen click on

    $("img.channel_logo").click(function() {

        new_channel = this.src;
        new_channel = new_channel.split("/img/homepage/logo/channel_")[1];
        new_channel = new_channel[0];

        if (new_channel != display_channel) {

            display_channel_thumbnails(homepage, new_channel)

            if (current_channel != display_channel) {
                $("img#channel_logo_" + display_channel).attr("src", "../img/homepage/logo/channel_" + display_channel + "_grey.png");
            }
        }

        if (new_channel == display_channel) {

            // start_time = homepage[new_channel]["now"]["start_time"];
            selector_url = "../img/homepage/selector/channel/" + new_channel + ".png";

            $("iframe#channel_player").attr("src", "https://www.youtube.com/embed/" + now_video_id + "?autoplay=1&showinfo=0&fs=1&color=white&showinfo=0&rel=0&mute=1");
            
            $("img#channel_selector").attr("src", selector_url);

            current_channel = display_channel;
        }

        display_channel = new_channel;
    });
}

function listen_live_video_thumbnails(homepage) {

    // Listen mouse over

    $("img.video").hover(function() {
        $(this).css("cursor","pointer");

    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img#video_now").click(function() {
        now_video_id = homepage[new_channel - 1][0]["video"];
        // start_time = homepage[new_channel][0]["start_time"];
        $("iframe#channel_player").attr("src", "https://www.youtube.com/embed/" + now_video_id + "?autoplay=1&showinfo=0&fs=1&color=white&showinfo=0&rel=0&mute=1");  
    });

    $("img#video_next").click(function() {
        next_video_id = homepage[new_channel - 1][1]["video"];
        $("iframe#channel_player").attr("src", "https://www.youtube.com/embed/" + next_video_id + "?autoplay=1&showinfo=0&fs=1&color=white&showinfo=0&rel=0&mute=1");  
    });
}


/********************************************** RESIZE *********************************************/

function screen_update() {

    close_menu_and_user();

    if (window.innerWidth > trigger_width) {$("img#imago_logo").css("width", "14vw")}
    if (window.innerWidth <= trigger_width) {$("img#imago_logo").css("width", "40vw")}

};
