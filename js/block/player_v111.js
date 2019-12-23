
var current_time;
var duration;
var interval_timecode;

var youtube_ready = false;
var vimeo_ready = false;

var player;
var youtube_ready;


/************************************************ PLAYER ***********************************************/

function launch_player(mode, type_id, content_id, section_id, episod_id) {

        $.post("/ws/get_episod_info.php",
            {
                type_id : type_id,
                content_id : content_id,
                section_id : section_id,
                episod_id : episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
                data = "{" + data.split('{')[1];
                data = data.split('}')[0] + "}";

                hosting = JSON.parse(data).hosting;
                audio_hosting = JSON.parse(data).audio_hosting;
                episod_id = JSON.parse(data).episod_id;
                video_id = JSON.parse(data).video_id;
                audio_id = JSON.parse(data).audio_id;
                name = JSON.parse(data).name;
                title = JSON.parse(data).title;
                fact_checking = JSON.parse(data).fact_checking;
                timecode = JSON.parse(data).timecode;
                is_episod_favorite = JSON.parse(data).is_episod_favorite;
                is_episod_later = JSON.parse(data).is_episod_later;
                is_episod_reco = JSON.parse(data).is_episod_reco;

                   
                if (mode == "switch") {
                    pathname = window.location.pathname;
                    page_name = "Imago TV - " + name + " #" + episod_id; 

                    if (type_id == "documentary" || type_id == "shortfilm") {
                        section_name = section_of(section_id)
                        window.history.replaceState("stateObj", page_name, pathname + "/" + section_name + "/" + episod_id);
                    }
                    else
                        window.history.replaceState("stateObj", page_name, pathname + "/" + episod_id);

                    reset_matomo(page_name);
                }

                $("img#content_favorite, img#content_later, img#content_reco").hide();
                

                $("span#episod_title").show();

                if (type_id == "documentary" || type_id == "shortfilm") {
                    if (name.length > 40) name = name.substr(1, 40) + "..."  
                    $("a#episod_name").text(name + " - " + section_of(section_id));
                }
                else {
                    if (title.length > 50) title = title.substr(0, 50) + "..." 
                    $("a#episod_name").text("#" + title);

                    $("img#episod_favorite, img#episod_later, img#episod_reco").show();
                    
                    if (is_episod_favorite == "1") {
                        $("img#episod_favorite").css("opacity", "0.2");
                        $("img#episod_heart").show();
                    }
                    else {
                        $("img#episod_favorite").css("opacity", "1");
                        $("img#episod_heart").hide();
                    }

                    if (is_episod_later == "1") {
                        $("img#episod_later").css("opacity", "0.2");
                        $("img#episod_time").show();
                    }
                    else {
                        $("img#episod_later").css("opacity", "1");
                        $("img#episod_time").hide();
                    }

                    if (is_episod_reco == "1") {
                        $("img#episod_reco").css("opacity", "0.2");
                        $("img#episod_medal").show();
                    }
                    else {
                        $("img#episod_reco").css("opacity", "1");
                        $("img#episod_medal").hide();
                    }
                }

                if (fact_checking != "") {
                    $("img#captain_fact").show();
                    $("a#captain_fact").attr("href", fact_checking);                    
                }


                if (type_id == "podcast")
                    launch_audio_player(audio_hosting, episod_id, audio_id, timecode);
                else
                    launch_video_player(hosting, episod_id, video_id, timecode);


                if (content_id == "irrintzina_le_cri_de_la_generation_climat" && episod_id != "") {
                    $("div#donation_area").show();
                    setTimeout(function(){ $("div#donation_area").fadeOut(2000)}, 10000);
                } 

                set_sharing_url();

                if (type_id != "podcast")
                    $("a#embed_display").show();


                if ((type_id == "documentary" || type_id == "shortfilm") && (section_id != "movie")) {
                    $("section.comment").hide();
                }
                else
                    $("section.comment").show();


                if (section_id != "")
                    embed = "https://www.imagotv.fr/php/embed.php?content_id=" + content_id + "&section_id=" + section_id + "&episod_id=" + episod_id;
                else
                    embed = "https://www.imagotv.fr/php/embed.php?content_id=" + content_id + "&episod_id=" + episod_id;                    

                iframe = '<iframe width="640" height="360" src="' + embed + '" frameborder="0" allowfullscreen></iframe>';

                $("input#embed_value").val(iframe);
            }
        );

        $.post("/ws/add_tag_video.php",
            {
                type_id : type_id,
                content_id : content_id,
                section_id : section_id,
                episod_id : episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
            }
        );

        if (user_status != "user") {
            $("a#login").show();
            comment = "Connectez-vous pour pouvoir laisser votre avis !";
            $("textarea#comment_value").val(comment);
        }
        else {

            $.post("/ws/read_comment.php",
                {
                    content_id : content_id,
                    section_id : section_id,
                    episod_id : episod_id
                },
                function(data, status) {
                    // alert("Data: " + data + "\n Status: " + status);

                    if (data.includes("[]")) {
                        comment = "Vous avez aimé ? Laissez votre avis ici !";
                    }
                    else {
                        data = "{" + data.split('{')[1];
                        data = data.split('}')[0] + "}";
                        comment = JSON.parse(data).comment;
                        $("a#modify, a#remove").show();
                    }

                    $("textarea#comment_value").val(comment);
                }
            );
        }

        $.post("/ws/read_comment_list.php",
            {
                content_id : content_id,
                section_id : section_id,
                episod_id : episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
                data = "[" + data.split('[')[1];
                data = data.split(']')[0] + "]";
                data = JSON.parse(data);

                comment_number = data.length;

                if (comment_number == "0") {
                    if (user_status == "user") $("div#comment_list").append('<a class = "comment_text"> Aucun autre avis encore publié </a>')
                    if (user_status != "user") $("div#comment_list").append('<a class = "comment_text"> Aucun avis encore publié </a>')
                }
                else {
                
                    for (index = 0; index < comment_number; index++) {
                        $("div#comment_list").append('<a class = "comment_author">' + data[index]["login"] + ' : </a> <br>')
                        $("div#comment_list").append('<a class = "comment_text">' + data[index]["comment"] + '</a> <br> <br>')
                    }
                }
            }
        );

        listen_embed_display();
        listen_embed_copy();
    }

function listen_embed_display() {

    // Listen mouse over

    $("a#embed_display").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color", "white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color", "grey");
    });

    // Listen click on

    $("a#embed_display").click(function() {
        $("input#embed_value, a#embed_copy").fadeIn(1000);
        setTimeout(function(){ $("input#embed_value, a#embed_copy").fadeOut(1000)}, 5000);
    });
}


function listen_embed_copy() {

    // Listen mouse over

    $("a#embed_copy").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color", "white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color", "grey");
    });

    // Listen click on

    $("a#embed_copy").click(function() {
        var text_to_copy = document.getElementById('embed_value');
        text_to_copy.select();
        document.execCommand('copy');
    });

}

// Un premier film d'une grande sensibilité. A la fois très personnel et en même temps d'une grande sensibilité. Nicolas

function remove_warning() {

    if ($("textarea#comment_value").val() == "Vous avez aimé ? Laissez votre avis ici !") {
        $("textarea#comment_value").val(""); 
        $("a#save").show();
    }
}

function listen_comment_buttons() {

    // Listen mouse over

    $("a.comment_button").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color", "white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color", "grey");
    });

    // Listen click on

    $("a#login").click(function() {
        set_cookie("url_cookie", window.location, 1);
        window.location.href = "/connexion"; 
    });

    $("a#save, a#modify").click(function() {

        comment = $("textarea#comment_value").val();
        
        $.post("/ws/add_comment.php",
            {
                content_id : content_id,
                section_id : section_id,
                episod_id : episod_id,
                comment : comment
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
                callback = callback_status(data);

                if (callback == "created") {
                    $("a#save").hide();
                    $("a#modify, a#remove").show();
                    $("a#callback").show();
                    $("a#callback").text("avis publié");
                    setTimeout(function(){ $("a#callback").fadeOut(1000)}, 2000);
                }
                if (callback == "modified") {
                    $("a#callback").show();
                    $("a#callback").text("avis modifié");
                    setTimeout(function(){ $("a#callback").fadeOut(1000)}, 2000);
                }
            }
        );

    });

    $("a#remove").click(function() {
        
        $.post("/ws/remove_comment.php",
            {
                content_id : content_id,
                section_id : section_id,
                episod_id : episod_id
            },
            function(data, status) {
                // alert("Data: " + data + "\n Status: " + status);
                callback = callback_status(data);

                if (callback == "removed") {
                    comment = "Vous avez aimé ? Laissez votre avis ici !";
                    $("textarea#comment_value").val(comment);
                    $("a#modify, a#remove").hide();
                    $("a#callback").show();
                    $("a#callback").text("avis supprimé");
                    setTimeout(function(){ $("a#callback").fadeOut(1000)}, 2000);
                }
            }
        );

    });
}

// php/embed.php?content_id=irrintzina_le_cri_de_la_generation_climat&section_id=movie&episod_id=1


/************************************************ VIDEO ***********************************************/

function launch_video_player(hosting, episod_id, video_id, timecode) {

        if (window.innerWidth > trigger_width) {
            $("div#screen").css("position", "fixed");
            $("div#footer").hide();
            $("section#button_list").css("margin-left", "76vw");
            $("div#pop_up").css("overflow-y", "auto");
        }
        else 
            $("body").css("overflow", "hidden");

        $("div#pop_up_shadow, div#pop_up").fadeIn(500);

        // if (type_id == "tvshow") {
        //     current_image_url   = "https://www.asset.imagotv.fr/img/tvshow/episod/" + content_id + "/hd/" + episod_id + ".jpg";       
        //     $("img#current_video").attr("src", current_image_url);
        //     $("img#current_video").fadeIn();
        //     setTimeout(function(){ $("img#current_video").fadeOut(2000); $("iframe#player").show();}, 2000);
        // }
        // else
        //     $("img#current_video").hide();


        if (hosting == "youtube") {
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&color=white&modestbranding=0&loop=1&playlist=" + video_id;

            if (youtube_ready == true) {
                player.loadVideoById(video_id, timecode);
            }
            else
                init_youtube();

            // if (status == "user") 
            //     if (type_id != "documentary" && type_id != "shortfilm")
            //         interval_timecode = setInterval(display_video, 1000);

            $("iframe#player").show();
        }

        else if (hosting == "vimeo") {

            var video_url = "https://player.vimeo.com/video/" + video_id + "?autoplay=1&color=FFFFFF&loop=true";
            $("section#video_player").prepend('<iframe id = "main_player" class = "player_popup" src = "' + video_url + '" allowfullscreen allow = "autoplay" > </iframe>');

            iframe = document.querySelector('iframe#main_player');
            player = new Vimeo.Player(iframe);
        
            player.on('loaded', function(data) {
                player.setCurrentTime(timecode);
                current_time = timecode;
                // if (status == "user") 
                //     if (type_id != "documentary" && type_id != "shortfilm")
                //         interval_timecode = setInterval(display_video, 1000);
            });

            player.on('timeupdate', function(data) {
                current_time = parseInt(data.seconds);
                duration = parseInt(data.duration);
            });

            $("iframe#main_player").show();
        } 

        else {

            switch (hosting) {

                case "invidio"      : var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1"; break;  //&listen=1
                case "dailymotion"  : var video_url = "https://www.dailymotion.com/embed/video/" + video_id + "?autoplay=1"; break;
                case "peertube"     : var video_url = "https://peertube.fr/videos/embed/" + video_id + "?api=1&autoplay=1&start=" + timecode; break;
                case "thinkerview"  : var video_url = "https://thinkerview.video/videos/embed/" + video_id + "?autoplay=1"; break;
                case "imago"        : var video_url = "https://video.imagotv.fr/videos/embed/" + video_id + "?api=1&autoplay=1&start=" + timecode; break;                
                case "wetube"       : var video_url = "https://members.wetube.io/embed/" + video_id; break;  // ?autoplay=1
                case "facebook"     : var video_url = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/imagotv/videos/" + video_id + "/&mute=0&autoplay=1"; break;
                case "arte"         : var video_url = "https://www.arte.tv/player/v3/index.php?json_url=https://api.arte.tv/api/player/v1/config/fr/" + video_id + "?autostart=1&lifeCycle=1&amp;lang=fr_FR&amp;mute=0"; break;
                case "ftv"          : var video_url = "https://embedftv-a.akamaihd.net/" + video_id; break;
                case "tv5monde"     : var video_url = "https://www.tv5mondeplus.com/embed/" + video_id; break;
            } 

            $("section#video_player").prepend('<iframe id = "main_player" class = "player_popup" src = "' + video_url + '" allowfullscreen allow = "autoplay" > </iframe>');

            // $("iframe#main_player").attr("src", video_url);
            var my_iframe = document.getElementById("main_player");
            my_iframe.contentWindow.location.replace(video_url);

            $("iframe#main_player").show();
        }


        // Display pop up

        // previous_episod_id  = parseInt(episod_id) - 1;
        // next_episod_id      = parseInt(episod_id) + 1;

        // if (episod_id == 1)               previous_episod_id = video_number;  
        // if (episod_id == video_number)    next_episod_id = 1;  

        // previous_image_url  = "/img/episod/tvshow/" + content_id + "/hd/" + previous_episod_id + ".jpg"; 
        // next_image_url      = "/img/episod/tvshow/" + content_id + "/hd/" + next_episod_id + ".jpg"; 

        // previous_url = "/podcasts/" + content_id + "/" + previous_episod_id;
        // next_url = "/podcasts/" + content_id + "/" + next_episod_id;

        // $("img.previous_video").attr("src", previous_image_url);
        // $("img#current_video").attr("src", current_image_url);
        // $("img.next_video").attr("src", next_image_url);

        // $("a.previous_video, img#previous").attr("href", previous_url);
        // $("a.next_video, img#next").attr("href", next_url);

        // $("img.previous_video").hide();
        // $("img.next_video").hide();

        $("section#video_player").show();
        init_close_player();
}

// -nocookie
// autoplay=1&mute=0&color=white&controls=1&origin=https://www.imagotv.fr&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1"

// var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1&color=white&modestbranding=0";
// var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=0&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";


/*********************************************** YOUTUBE *********************************************/

function init_youtube () {

    var script = document.createElement("script");
    script.src = "https://www.youtube.com/iframe_api";

    var youtube_script = document.getElementsByTagName("script")[0];
    youtube_script.parentNode.insertBefore(script, youtube_script);
}

function onYouTubeIframeAPIReady() {

    player = new YT.Player('player', {
        videoId: video_id,
        events: {
            'onReady': onPlayerReady
        }
    });
}

function onPlayerReady(event) {

    youtube_ready = true;
    player = event.target;

    player.seekTo(timecode, true);
    player.playVideo();
}

function display_video() {

    if (hosting == "youtube") {    
        current_time = parseInt(player.getCurrentTime());
        duration = parseInt(player.getDuration());
    }

    resume_bar_size = 21 * (current_time / duration) + "vw";
    $("div#resume_" + episod_id).css("width", resume_bar_size);

    $.post("/ws/add_resume.php",
        {
            content_id : content_id,
            episod_id : episod_id,
            resume_time : current_time
        },
        function(data, status){
            // alert("Data: " + data + "\n Status: " + status);
        }
    )
}


/*********************************************** AUDIO *********************************************/

listen_progess_bar();
listen_player_control();

function launch_audio_player(hosting, episod_id, audio_id, timecode) {

        if (window.innerWidth > trigger_width) {
            $("div#screen").css("position", "fixed");
            $("div#footer").hide();
            $("section#button_list").css("margin-left", "76vw");
            $("div#pop_up").css("overflow-y", "auto");
        }
        else 
            $("body").css("overflow", "hidden");

        $("div#pop_up_shadow, div#pop_up").fadeIn(500);

        // $("body").css("overflow", "hidden");
        // $("img#background_shadow, div#pop_up, img#audio_close").show();

        switch (hosting) {

            case "soundcloud"   : var audio_url = "http://feeds.soundcloud.com/stream/" + audio_id + ".mp3"; break;      
            case "infomaniak"   : var audio_url = "https://vod.infomaniak.com/redirect/rseauraje_2_vod/podcasts_raje_mp3-43197/mp3-1133/" + audio_id + ".mp3"; break;
            case "podcloud"     : var audio_url = "http://stats.podcloud.fr/ca-commence-par-nous/" + audio_id + ".mp3"; break;        
            case "pippa"        : var audio_url = "https://feed.pippa.io/public/streams/" + audio_id + ".mp3"; break;        
            case "ausha"        : var audio_url = "https://audio.ausha.co/" + audio_id + ".mp3"; break;
            case "anchor"       : var audio_url = "https://d3ctxlq1ktw2nl.cloudfront.net/production/" + audio_id + ".mp3"; break;
            case "libsyn"       : var audio_url = "https://traffic.libsyn.com/secure/" + audio_id + ".mp3"; break;
            case "radio_france" : var audio_url = "http://media.radiofrance-podcast.net/podcast09/" + audio_id + ".mp3"; break;
            case "reporterre"   : var audio_url = "https://reporterre.net/IMG/mp3/" + audio_id + ".mp3"; break;
            case "invidio"      : var audio_url = "https://www.invidio.us/latest_version?id=" + audio_id + "&itag=140&listen=1"; break;
            case "imago"        : var audio_url = "https://asset.imagotv.fr/mp3/podcast/" + audio_id + ".mp3"; break;
            case "thinkerview"  : var audio_url = "https://www.thinkerview.com/podcast-download/" + audio_id + ".mp3"; break;
        }

        // Display pop up

        // if (timecode != "") {
        //     audio_popup.currentTime = timecode;
        // }

        audio_popup.currentTime = timecode;
        $("audio#audio_popup").attr("src", audio_url);

        previous_episod_id  = parseInt(episod_id) - 1;
        next_episod_id      = parseInt(episod_id) + 1;

        if (episod_id == 1)               previous_episod_id = video_number;  
        if (episod_id == video_number)    next_episod_id = 1;  

        previous_image_url  = "https://www.asset.imagotv.fr/img/podcast/episod/" + content_id + "/" + previous_episod_id + ".jpg"; 
        next_image_url      = "https://www.asset.imagotv.fr/img/podcast/episod/" + content_id + "/" + next_episod_id + ".jpg"; 

        previous_url = "/podcasts/" + content_id + "/" + previous_episod_id;
        next_url = "/podcasts/" + content_id + "/" + next_episod_id;

        // if (!image_exist(current_image_url)) {
        //     current_image_url = "/img/episod/podcast/" + content_id + "/default.jpg";
        // }

        $("img.previous_audio").attr("src", previous_image_url);
        $("img.next_audio").attr("src", next_image_url);

        $("a.previous_audio, img#previous").attr("href", previous_url);
        $("a.next_audio, img#next").attr("href", next_url);


        current_image_url   = "https://www.asset.imagotv.fr/img/podcast/episod/" + content_id + "/" + episod_id + ".jpg"; 
        $("img#current_audio").attr("src", current_image_url);

        // if (status == "user") interval_timecode = setInterval(display_audio, 1000);
        interval_progress_bar = setInterval(update_progess_bar, 1000);

        $("section#audio_player").show();
        init_close_player();
}

function display_audio() {

    duration = audio_popup.duration;
    current_time = audio_popup.currentTime;

    resume_bar_size = 13 * (current_time / duration) + "vw";
    $("div#resume_" + episod_id).css("width", resume_bar_size);

    $.post("/ws/add_resume.php",
        {
            content_id : content_id,
            episod_id : episod_id,
            resume_time : current_time
        },
        function(data, status){
            // alert("Data: " + data + "\n Status: " + status);
        }
    )
}

// var audio_url = "https://www.invidio.us/latest_version?id=" + video_id + "&itag=251&listen=1";

/*********************************************** CONTROL *********************************************/

function listen_progess_bar() {

    // Listen mouse over

    $("div#progress_bar_background").mousemove(function(event) {

        if (window.innerWidth > trigger_width) {
            ratio = (event.pageX - 0.37 * window.width) / (0.26 * window.width);
            timecode_position = event.pageX - 0.37 * window.width;
        }
        else {
            ratio = event.pageX / window.width;
            timecode_position = event.pageX
        }

        timecode_width = parseInt($("a#timecode").css("width"));
        timecode_position = timecode_position - 1.4 * ratio * timecode_width;
        $("a#timecode").css("left", timecode_position);

        time = ratio * audio_popup.duration;
        formated_time = format_time(time);
        $("a#timecode").text(formated_time);
    });

    $("div#progress_bar_background").hover(function() {
        $(this).css("cursor","pointer");
        $("a#timecode").show();
    },function() {
        $(this).css("cursor","auto");
        $("a#timecode").hide();
    });

    // Listen click on

    $("div#progress_bar_background").mouseup(function() {
        audio_popup.currentTime = time;
        update_progess_bar();
    });
}

function update_progess_bar() {

    duration            = audio_popup.duration;
    current_time        = audio_popup.currentTime;

    if (window.innerWidth > trigger_width)
        progress_bar_width  = 26 * current_time / duration;
    else
        progress_bar_width  = 100 * current_time / duration;

    $("div#progress_bar").css("width", progress_bar_width + 'vw')

    if (!Number.isNaN(audio_popup.duration)) {

        formated_current_time = format_time(current_time)
        $("a#current_time").text(formated_current_time);

        formated_duration = format_time(audio_popup.duration);
        $("a#duration").text("/ " + formated_duration);
    }
}

function listen_player_control() {

    // Listen mouse over

    $("img#previous, img#fast_rewind, img#pause_play, img#fast_forward, img#next, img#mute").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","0.9");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.6");
    });

    // Listen click on

    $("img#pause_play").click(function() {

        if (audio_popup.paused) {
            audio_popup.play();
            $(this).attr("src", "/img/icons/play/pause.png");
        } else {
            audio_popup.pause(); 
            $(this).attr("src", "/img/icons/play/play.png");
        }
    });

    $("img#previous").click(function() { 
        window.location.href = previous_url;
    });

    $("img#next").click(function() {
        window.location.href = next_url;
    });

    $("img#fast_rewind").click(function() {
        new_time = audio_popup.currentTime
        audio_popup.currentTime = new_time - 20;
        update_progess_bar();       
    });

    $("img#fast_forward").click(function() {
        new_time = audio_popup.currentTime
        audio_popup.currentTime = new_time + 20;
        update_progess_bar();
    });

    $("img#mute").click(function() {

        if (audio_popup.muted) {
            audio_popup.muted = false;
            $(this).attr("src", "/img/icons/play/mute.png");
        } else {
            audio_popup.muted = true;
            $(this).attr("src", "/img/icons/play/unmute.png");
        }
    });
}


/*********************************************** CLOSE *********************************************/

function init_close_player() {

    $("img#player_close").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.4");
    });

    $("img#player_close").click(function() {

        $pathname = window.location.pathname;
        $pathname = $pathname.split("/");
        $new_pathname = "/" + $pathname[1] + "/" + $pathname[2];

        // var stateObj = { pathname: "" };
        window.history.replaceState("stateObj", name + " sur Imago TV", $new_pathname);
 
        if (window.innerWidth > trigger_width) {
            $("div#screen").css("position", "static");
            $("div#footer").show();
            $("section#button_list").css("margin-left", "96vw")
        }
        else
            $("body").css("overflow", "");

        $("div#pop_up_shadow, div#pop_up").hide();

        $("img#content_favorite, img#content_later, img#content_reco").show();
        $("img#episod_favorite, img#episod_later, img#episod_reco").hide();

        $("span#episod_title").hide();

        if (type_id == "podcast") {

            $("section#audio_player").hide();
            $("audio#audio_popup").attr("src", "");

            clearInterval(interval_timecode);
            clearInterval(interval_progress_bar);

            $("a#current_time").text("--:--");
            $("a#duration").text("/ --:--");

            $("div#progress_bar").css("width", '0vw');
        }

        else {

            if (hosting == "youtube") {
                player.stopVideo();
                $("section#video_player").hide();            
                clearInterval(interval_timecode);
            }

            else if (hosting == "vimeo") {
                $("section#video_player").hide();
                $("iframe#main_player").remove();
                clearInterval(interval_timecode);
            }

            else {

                $("section#video_player").hide();
                $("iframe#main_player").remove();
                clearInterval(interval_timecode); 

                $("div#donation_area").hide();

                // $(".player_popup").attr("src", "");
                // var my_iframe = document.getElementById("main_player");
                // my_iframe.contentWindow.location.replace("");        
            }
        }

        set_sharing_url();

        $("div#comment_list").empty();

        $("div#eqds_button").hide();
    });
}


/********************************************* FULLSCREEN *******************************************/

// function playFullscreen() {

//     if (hosting == "youtube")
//         iframe = document.querySelector.bind(document)("iframe#player");
//     else
//         iframe = document.querySelector.bind(document)("iframe#main_player");

//     var requestFullScreen = iframe.requestFullScreen || 
//                             iframe.mozRequestFullScreen || 
//                             iframe.webkitRequestFullScreen;

//     if (requestFullScreen) {
//         requestFullScreen.bind(iframe)();
//     }
// }

// function fullscreen() {

//     var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
//         (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
//         (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
//         (document.msFullscreenElement && document.msFullscreenElement !== null);

//     var docElm = document.documentElement;

//     if (!isInFullScreen) {
//         if (docElm.requestFullscreen) {
//             docElm.requestFullscreen();
//         } else if (docElm.mozRequestFullScreen) {
//             docElm.mozRequestFullScreen();
//         } else if (docElm.webkitRequestFullScreen) {
//             docElm.webkitRequestFullScreen();
//         } else if (docElm.msRequestFullscreen) {
//             docElm.msRequestFullscreen();
//         }
//     } else {
//         if (document.exitFullscreen) {
//             document.exitFullscreen();
//         } else if (document.webkitExitFullscreen) {
//             document.webkitExitFullscreen();
//         } else if (document.mozCancelFullScreen) {
//             document.mozCancelFullScreen();
//         } else if (document.msExitFullscreen) {
//             document.msExitFullscreen();
//         }
//     }
// }


// fetch('https://graphql.captainfact.io', {
//     method: 'POST',
//     headers: {'Content-Type': 'application/json'},
//     body: JSON.stringify({
//         query: `{
//           video(url: "https://www.youtube.com/watch?v=dejeVuL9-7c") {
//             title
//             statements {
//               time
//               text
//               speaker {
//             slug
//             fullName
//             picture
//             title
//               }
//               comments {
//             replyToId
//             approve
//             score
//             text
//             source {
//               siteName
//               title
//               url
//             }
//             user {
//               miniPictureUrl
//               name
//               reputation
//               username
//             }
//               }
//             }
//           }
//         }`
//     })
// }).then(response => {
//     response.text().then((body) => {
//         console.log(JSON.parse(body).data)
//     });
// })
