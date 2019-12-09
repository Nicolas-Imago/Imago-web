
/******************************************* INIT SCREEN ********************************************/

var mode = "splashscreen";

init_screen();

function init_screen() {

    // Display screen

    $("div#screen").fadeIn(1000);
    $("div#footer").show(); 

    // listen mouse over, scroll and resize

    listen_player();
    listen_logo();
    listen_layer();
}


/************************************************ PLAYER ***********************************************/


function listen_player() {

    // Listen mouse over

     $("img#logo_play").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img#logo_play").click(function() {

        $("img#logo_play, img#logo_imago, div#content_layer").fadeOut(2000);
        launch_player("first", type_id, content_id, section_id, episod_id);
        $("img#thumbnail_image").delay(3000).fadeOut(2000);

    });
}

function listen_logo() {

    // Listen mouse over

     $("img#logo_imago").hover(function() {
        $(this).css("cursor","pointer");
        $("div#content_layer").show();
        $("img#logo_imago").show();
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img#logo_imago").click(function() {

        if (type_id == "tvshow")
            open("/emissions/" + content_id); 

        else if (type_id == "documentary")
            open("/documentaires/" + content_id); 

        else if (type_id == "shortfilm")
            open("/courts-metrages/" + content_id);

        else if (type_id == "podcast")
            open("/podcasts/" + content_id);  
    });
}


function listen_layer() {

    // Listen mouse over

    $("div#screen").hover(function() {

        if (mode == "player") {
            $("div#content_layer").fadeIn();
            $("img#logo_imago").fadeIn();
            // $("div#episod_layer").fadeIn();
        }

    },function() {

        if (mode == "player") {
            $("div#content_layer").fadeOut();
            $("img#logo_imago").fadeOut();
            // $("div#episod_layer").fadeOut();
        } 
    });
}


function launch_player(mode, type_id, content_id, current_section_id, current_episod_id) {

        $.post("/ws/get_episod_info.php",
            {
                type_id : type_id,
                content_id : content_id,
                section_id : current_section_id,
                episod_id : current_episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
                data = "{" + data.split('{')[1];
                data = data.substring(0, data.length - 2);

                hosting = JSON.parse(data).hosting;
                audio_hosting = JSON.parse(data).audio_hosting;
                name = JSON.parse(data).name;
                episod_id = JSON.parse(data).episod_id;
                video_id = JSON.parse(data).video_id;
                audio_id = JSON.parse(data).audio_id;
                timecode = JSON.parse(data).timecode;
                is_episod_later = JSON.parse(data).is_episod_later;
                is_episod_reco = JSON.parse(data).is_episod_reco;

                if (type_id == "podcast")
                    launch_audio_player(audio_hosting, episod_id, audio_id, timecode);
                else
                    launch_video_player(hosting, episod_id, video_id, timecode);
                   
                if (mode == "switch") {
                    pathname = window.location.pathname;
                    page_name = "Imago TV - " + name + " #" + episod_id; 

                    if (type_id == "documentary" || type_id == "shortfilm") {
                        section_name = section_of(current_section_id)
                        window.history.replaceState("stateObj", page_name, pathname + "/" + section_name + "/" + episod_id);
                    }
                    else
                        window.history.replaceState("stateObj", page_name, pathname + "/" + episod_id);

                    reset_matomo(page_name);
                }
            }
        );

        $.post("/ws/add_tag_video.php",
            {
                type_id : type_id,
                content_id : content_id,
                section_id : current_section_id,
                episod_id : current_episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
            }
        );
    }


function launch_video_player(hosting, episod_id, video_id, timecode) {

        mode = "player";

        if (hosting == "invidio") {
            // var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1"; //&listen=1
            var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
        }

        if (hosting == "youtube") {
            // var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1"; //&listen=1
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
            var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&modestbranding=1";
        }

        // -nocookie
        // autoplay=1&mute=0&color=white&controls=1&origin=https://www.imagotv.fr&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1"

        if (hosting == "dailymotion") {
            var video_url = "https://www.dailymotion.com/embed/video/" + video_id + "?autoplay=1";
        }

        if (hosting == "vimeo") {
            var video_url = "https://player.vimeo.com/video/" + video_id + "?autoplay=1";
        } 

        if (hosting == "thinkerview") {
            var video_url = "https://thinkerview.video/videos/embed/" + video_id + "?autoplay=1";
        }

        if (hosting == "peertube") {
            var video_url = "https://peertube.mastodon.host/videos/embed/" + video_id + "?autoplay=1";
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
        }

        if (hosting == "imago") {
            var video_url = "https://video.imagotv.fr/videos/embed/" + video_id + "?autoplay=1";
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
        }

        if (hosting == "wetube") {
            var video_url = "https://members.wetube.io/embed/" + video_id + "?autoplay=1";
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
        }

        if (hosting == "facebook") {
            var video_url = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/imagotv/videos/" + video_id + "/&mute=0&autoplay=1";
            var video_format = "squared";
        }    

        if (hosting == "arte") {
            var video_url = "https://www.arte.tv/player/v3/index.php?json_url=https://api.arte.tv/api/player/v1/config/fr/" + video_id + "?autostart=1&lifeCycle=1&amp;lang=fr_FR&amp;mute=0";
        }  

        if (hosting == "ftv") {
            var video_url = "https://embedftv-a.akamaihd.net/" + video_id;
        }   

        $("iframe#video").attr("src", video_url);
        $("iframe#video").show();

        // if (video_format == "squared") {$("iframe#video").addClass("squared");}
}
