
var current_time;
var duration;
var interval_timecode;

var youtube_ready = false;
var vimeo_ready = false;

var player;
var youtube_ready;


/************************************************ PLAYER ***********************************************/

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
                fact_checking = JSON.parse(data).fact_checking;
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

                $("img#favorite").hide();
                $("img#content_later").hide();
                $("img#content_reco").hide();

                if (type_id != "documentary" && type_id != "shortfilm") {
                    $("span#episod_title").show();
                    $("a#episod_name").text("Episode n°" + episod_id);
                    $("img#episod_later").show();
                    $("img#episod_reco").show();
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

                if (fact_checking != "") {
                    $("img#captain_fact").show();
                    $("a#captain_fact").attr("href", fact_checking);                    
                }


                if (content_id == "irrintzina_le_cri_de_la_generation_climat" && episod_id != "") {
                    $("div#donation_area").show();
                    setTimeout(function(){ $("div#donation_area").fadeOut(2000)}, 10000);
                } 

                set_sharing_url();
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


/************************************************ VIDEO ***********************************************/

function launch_video_player(hosting, episod_id, video_id, timecode) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#video_close").fadeIn(500);

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

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#audio_close").show();

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

    $("img#audio_close, img#video_close").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    $("img#audio_close, img#video_close").click(function() {

        $pathname = window.location.pathname;
        $pathname = $pathname.split("/");
        $new_pathname = "/" + $pathname[1] + "/" + $pathname[2];

        // var stateObj = { pathname: "" };
        window.history.replaceState("stateObj", name + " sur Imago TV", $new_pathname);
 
        $("body").css("overflow", "");
        $("img#background_shadow, img#audio_close, img#video_close").hide();

        $("img#favorite").show();
        $("img#content_reco").show();
        $("img#episod_later").hide();
        $("img#episod_reco").hide();

        if (type_id == "documentary" || type_id == "shortfilm") {
            $("img#content_later").show();
        }

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
