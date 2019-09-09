
/************************************************ PLAYER ***********************************************/

function launch_video_player(hosting, video_id) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#close_player, a.view_number").show();

        if (hosting == "invidio") {
            var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1"; //&listen=1
        }

        if (hosting == "youtube") {
            var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&color=white&modestbranding=0&loop=1&playlist=" + video_id;
            
            // var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1&color=white&modestbranding=0";
            // var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=0&mute=0&controls=1&origin=https%3A%2F%2Fcaptainfact.io&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1";
        }

        // -nocookie
        // autoplay=1&mute=0&color=white&controls=1&origin=https://www.imagotv.fr&playsinline=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&enablejsapi=1&widgetid=1"

        if (hosting == "dailymotion") {
            var video_url = "https://www.dailymotion.com/embed/video/" + video_id + "?autoplay=1";
        }

        if (hosting == "vimeo") {
            var video_url = "https://player.vimeo.com/video/" + video_id + "?autoplay=1&color=FFFFFF&loop=true";
            // $("iframe#video_popup").attr("src", video_url);

            // var iframe = document.querySelector('iframe.popup');
            // var player = new Vimeo.Player(iframe);

            // player.on('play', function() {
            //     console.log('Played the video');
            // });

            // player.getVideoTitle().then(function(title) {
            //     console.log('title:', title);
            // });

            // player.on('timeupdate', function(data) {
            //     console.log(data.seconds)
            // });

        } 

        if (hosting == "thinkerview") {
            var video_url = "https://thinkerview.video/videos/embed/" + video_id + "?autoplay=1";
        }

        if (hosting == "peertube") {
            var video_url = "https://peertube.fr/videos/embed/" + video_id + "?autoplay=1";
        }

        if (hosting == "wetube") {
            var video_url = "https://members.wetube.io/embed/" + video_id + "?autoplay=1";
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

        if (hosting == "tv5monde") {
            var video_url = "https://www.tv5mondeplus.com/embed/" + video_id;
        }  

        $("iframe#video_popup").attr("src", video_url);
        $("iframe#video_popup").show();

        if (video_format == "squared") {$("iframe#video_popup").addClass("squared");}

        if (window.innerWidth > trigger_width) {$("img#close_player").css("left", "74vw")}
        init_close_player(); 
}

function launch_audio_player(hosting, episod_id, audio_id, timecode) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#close_player").show();

        if (hosting == "soundcloud") {
            var audio_url = "http://feeds.soundcloud.com/stream/" + audio_id + ".mp3?auto_play=1";
        }
        
        else if (hosting == "infomaniak") {
            var audio_url = "https://vod.infomaniak.com/redirect/rseauraje_2_vod/podcasts_raje_mp3-43197/mp3-1133/" + audio_id + ".mp3?auto_play=1";
        }

        else if (hosting == "podcloud") {
            var audio_url = "http://stats.podcloud.fr/ca-commence-par-nous/" + audio_id + ".mp3?auto_play=1";
        }
        
        else if (hosting == "pippa") {
            var audio_url = "https://feed.pippa.io/public/streams/" + audio_id + ".mp3?auto_play=1";
        }
        
        else if (hosting == "ausha") {
            var audio_url = "https://audio.ausha.co/" + audio_id + ".mp3";
        }

        else if (hosting == "anchor") {
            var audio_url = "https://d3ctxlq1ktw2nl.cloudfront.net/production/" + audio_id + ".mp3";
        }

        else if (hosting == "radio_france") {
            var audio_url = "http://media.radiofrance-podcast.net/podcast09/" + audio_id + ".mp3";
        }

        else if (hosting == "reporterre") {
            var audio_url = "https://reporterre.net/IMG/mp3/" + audio_id + ".mp3";
        }

        else if (hosting == "invidio") {
            var audio_url = "https://www.invidio.us/latest_version?id=" + video_id + "&itag=140&listen=1";
        }

        else if (hosting == "imago") {
            var audio_url = "https://www.imagotv.fr/mp3/podcast/" + video_id + ".mp3";
        }

        else if (hosting == "thinkerview") {
            var audio_url = "https://www.thinkerview.com/podcast-download/" + video_id + ".mp3";
        }

        // else if (hosting == "soundcloud_embed") {
            
        //     var audio_url = "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" + audio_id + "&auto_play=true&visual=true";
        //     $("iframe#audio_popup_soundcloud").attr("src", audio_url);
        //     $("iframe#audio_popup_soundcloud").show();

        //     init_close_player();
        // }

        // else if (hosting == "wix") {
        //     var audio_url = "https://music.wixstatic.com/preview/" + audio_id + ".mp3?auto_play=1";
        // }

        // else if (hosting == "invidio") {
        //     var audio_url = "https://www.invidio.us/latest_version?id=" + video_id + "&itag=251&listen=1";
        //     audio_popup.currentTime = 360;
        // }

        // var audio_url = "https://zoom-ecologie.net/IMG/mp3/02_-_zoom_ecologie_14.02.2019.mp3"
        // var audio_url = "https://player.pippa.io/" + content_id + "/episodes/" + audio_id + "?auto_play=1";

        if (timecode != "") {
            audio_popup.currentTime = timecode;
        }

        $("audio#audio_popup").attr("src", audio_url);
        $("audio#audio_popup").show();

        image_url = "../img/video/podcast/" + content_id + "/" + episod_id + ".jpg"
        $("img#audio_popup_image").attr("src", image_url);
        $("img#audio_popup_image").show();

        if (window.innerWidth > trigger_width) {$("img#close_player").css("left", "64vw")}
        init_close_player();

}

function init_close_player() {

    $("img#close_player").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");

        // var myIFrame = document.getElementById("video_popup");
        // var content = myIFrame.contentWindow.document.body.innerHTML;

        // console.log(content);

        // timecode = $(".vjs-current-time-display").text();
        // console.log("timecode = " + timecode);

    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    $("img#close_player").click(function() {

        $("body").css("overflow", "");
        $("img#background_shadow, img#close_player").hide();

        $(".popup").attr("src", "");
        $(".popup").hide();

        $("img#audio_popup_image").hide();
        
        $(".player_popup").attr("src", "");
        $(".player_popup").hide();

        $("a.view_number").hide();

        $("div#eqds_button").hide();


        // window.history.pushState("object or string", "Title", "/toto");
        // window.history.back();

        // $("div#button_header, img.sharing").removeClass("player");

    });
}