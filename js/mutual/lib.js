
/******************************************** ENV VARIABLES ********************************************/

// Log env

console.log(env)
console.log(base_url)


// Variables

var trigger_width = 480;
var version = "1.0.8"


/*********************************************** COOKIES ***********************************************/


function set_cookie(cookie_name, cookie_value, expire_day) {

    var date = new Date();
    date.setTime(date.getTime() + (expire_day * 24 * 60 * 60 * 1000));
    
    var expires = "expires=" + date.toGMTString();
    document.cookie = cookie_name + "=" + cookie_value + ";" + expires + ";path=/";
}

function get_cookie(cookie_name) {

    var name = cookie_name + "=";
    var my_cookie = decodeURIComponent(document.cookie);
    var my_cookie = my_cookie.split(";");

    // console.log("step 1 : " + my_cookie)
    
    for(index = 0; index < my_cookie.length; index++) {

        var cookie_temp = my_cookie[index];
        while (cookie_temp.charAt(0) == " ") {
            cookie_temp = cookie_temp.substring(1);
        }
        if (cookie_temp.indexOf(name) == 0) {
            result_cookie = cookie_temp.substring(name.length, cookie_temp.length);
            // console.log("step 2 : " + result_cookie)
            return result_cookie;
        }
    }

    return "";
}


/********************************************** FUNCTIONS **********************************************/

function go_to(url) {

        // console.log(base_url + url)
        window.location.href = base_url + url;
        // window.open($(this).attr('href'));
}

function category_name_of(category_id) {

    if (category_id == 1) {category_name = "Conscience"}
    if (category_id == 2) {category_name = "Alternatives"}
    if (category_id == 3) {category_name = "Esprit critique"}
    if (category_id == 4) {category_name = "Santé"}        
    if (category_id == 5) {category_name = "Ecologie"}
    if (category_id == 6) {category_name = "Economie"}
    if (category_id == 7) {category_name = "Société"}
    if (category_id == 8) {category_name = "Connaissance"}

    return category_name
}; 

function category_id_of(category_name) {

    if (category_name == "Conscience") {category_id = 1}
    if (category_name == "Alternatives") {category_id = 2}
    if (category_name == "Esprit critique") {category_id = 3}
    if (category_name == "Santé") {category_id = 4}
    if (category_name == "Ecologie") {category_id = 5}
    if (category_name == "Economie") {category_id = 6}
    if (category_name == "Société") {category_id = 7}
    if (category_name == "Connaissance") {category_id = 8}

    return category_id
}; 

function init_close_player(player) {

    $("img#close_player").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    $("img#close_player").click(function() {

        $("body").css("overflow", "");
        $("img#background_shadow, img#close_player").hide();

        $(".popup").attr("src", "");
        $(".popup").hide();

        $("img#audio_popup_wix_image").hide();
        
        $(".player_popup").attr("src", "");
        $(".player_popup").hide();

    });
}


/*********************************************** CONTENT ***********************************************/

function listen_name() {

    // Listen mouse over

    $("a.name").hover(function() {
        $(this).css("cursor","pointer")
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("a.name").click(function() {     
        // open("/php/admin/content_form.php?content_id=" + content_id);
    });
}

function listen_author() {

    // Listen mouse over

    $("img.author_image").hover(function() {
        $(this).css("cursor","pointer")
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.author_image").click(function() {
        var author_id = $(this).attr("src")
        author_id = author_id.split("img/author/thumbnail/")[1];
        author_id = author_id.split(".")[0]
        
        go_to("/php/creator.php?type_id=author&creator_id=" + author_id);
    });
}

function listen_social_network() {

    // Listen mouse over

    $("img#cock_a_doodle_doo, img#trombinobooq, img#favorite").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img#cock_a_doodle_doo, img#trombinobooq, img#favorite").click(function() {

        var action = $(this).attr("id");
        sharing_url = encodeURIComponent(page_url);

        if (action == "trombinobooq") {
            open("https://www.facebook.com/dialog/share?app_id=593792624381849&display=popup&href=" + sharing_url, "_blank")
        }

        if (action == "cock_a_doodle_doo") {
            open("https://twitter.com/intent/tweet?url=" + sharing_url + "&via=ImagoTV_fr", "_blank")
        }

        console.log(is_favorite);

        if (action == "favorite") {
            if (status == "logout") {
                go_to("/php/login.php") 
            }
            else {
                if (is_favorite == "0") {
                    $("img#favorite").attr("src", "../img/icons/button/favorite_on.png");

                    console.log(user_id)
                    console.log(content_id)

                    $.post("../functions/add_favorite.php",
                        {
                            user_id : user_id,
                            content_id : content_id
                        },
                        function(data, status){
                            alert("Data: " + data + "\n Status: " + status);
                    });
 
                    is_favorite = "1";
                }
                else {
                    $("img#favorite").attr("src", "../img/icons/button/favorite_off.png");

                    // $.post("../functions/remove_favorite.php",
                    //     {
                    //         user_id : user_id,
                    //         content_id : content_id
                    //     },
                    //     function(data, status){
                    //         // alert("Data: " + data + "\n Status: " + status);
                    // });

                    is_favorite = "0";
                }
            }
        }
    });
}

function listen_note() {

    // Listen mouse over

    $("div.note").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.note_image").click(function() {
        var note_id = $(this).attr("id");
        note_category = note_id.split("_")[1];
        note_value[note_category] = note_id.split("_")[2];

        // console.log("Je vote " + note_value[note_category] + " dans la catégorie " + note_category)

        if (note_category == 1) {note_trigger = note_1}
        if (note_category == 2) {note_trigger = note_2}
        if (note_category == 3) {note_trigger = note_3}

        for (index = 1; index <= 5; index++) {
            if (index <= note_value[note_category]) {
                $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_white.png")
            }
            else {
                if (index <= note_trigger) {
                    $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_light_grey.png")
                }
                else {
                    $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_grey.png")
                }
            }
        } 

        $("a.set_note").show();
    });
}

function listen_note_setting() {

    $("a.set_note").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color","white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color","grey"); 
    });

    $("a.set_note").click(function() {

        $.post("../functions/set_note.php",
            {
                type_id : type_id,
                content_id : content_id,
                note_1 : note_value[1],
                note_2 : note_value[2],
                note_3 : note_value[3]
            },
            function(data, status){
                // alert("Data: " + data + "\n Status: " + status);
        });

        $("a.set_note").hide();

        for (note_category_index = 1; note_category_index <= 3; note_category_index++) {
            for (index = 1; index <= 5; index++) {
                if (index <= note_value[note_category_index]) {
                    $("img#note_" + note_category_index + "_" + index).attr("src", "../img/icons/notation/star_light_grey.png")
                }
                else {
                    $("img#note_" + note_category_index + "_" + index).attr("src", "../img/icons/notation/star_grey.png")   
                }
            } 
        }
    });
}

function listen_thumbnails(type) {

    // Listen mouse over

    $("div.thumbnail").hover(function() {
        $(this).css("cursor","pointer");
        image_id = this.id.split("_")[1];

        if (window.innerWidth > trigger_width) {
            $("div#info_" + image_id).fadeIn(200);
        }

    },function() {
        $(this).css("cursor","auto");
        image_id = this.id.split("_")[1];

        if (window.innerWidth > trigger_width) {
            $("div#info_" + image_id).fadeOut(200);
        }
    });

    // Listen click on

    $("div.thumbnail").click(function() {

        div_id = this.id;
        thumbnail = div_id.split("_")[1];
        episod_id = div_id.split("_")[2];

        image_source = $("img#thumbnail_image_" + episod_id).attr("src");
        console.log(thumbnail)

        if (thumbnail == "youtube") {
            video_id = image_source.split("https://img.youtube.com/vi/")[1];
            video_id = video_id.split("/")[0];
        }

        if (thumbnail == "local") {
            video_id = image_source.split("/img/video/" + content_id + "/")[1];
            video_id = video_id.split(".")[0];
            console.log(video_id)
        }

        // if (video_id == "greenpeace") {
        //     open(link);
        // }

        if (type == "series") {
            go_to("/php/" + type + ".php?type_id=" + type_id + "&content_id=" + content_id + "&episod_id=" + episod_id);
        }
        else {
            go_to("/php/" + type + ".php?type_id=" + type_id + "&content_id=" + content_id + "&video_id=" + video_id); 
        }
    });
}


/************************************************ PLAYER ***********************************************/

function launch_video_player(hosting, video_id) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#close_player").show();

        if (hosting == "invidio") {
            var video_url = "https://www.invidio.us/embed/" + video_id + "?autoplay=1&fs=1&color=white&showinfo=0&rel=0&modestbranding=0";
        }

        if (hosting == "youtube") {
            var video_url = "https://www.youtube.com/embed/" + video_id + "?autoplay=1&fs=1&color=white&showinfo=0&rel=0&modestbranding=0";
        }

        if (hosting == "dailymotion") {
            var video_url = "https://www.dailymotion.com/embed/video/" + video_id;
        }

        if (hosting == "vimeo") {
            var video_url = "https://player.vimeo.com/video/" + video_id + "?autoplay=1";
        } 

        if (hosting == "thinkerview") {
            var video_url = "https://thinkerview.video/videos/embed/" + video_id + "?autoplay=1";
        }

        if (hosting == "peertube") {
            var video_url = "https://peertube.mastodon.host/videos/embed/" + video_id + "?autoplay=1";
        }

        if (hosting == "wetube") {
            var video_url = "https://members.wetube.io/embed/21141ce79a3f517333089ad7073b0b580e915260";
        }

        if (hosting == "facebook") {
            var video_url = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/lareleveetlapeste/videos/1514849608609171/&mute=0&autosart=1";
        }    

        if (hosting == "arte") {
            var video_url = "https://www.arte.tv/player/v3/index.php?json_url=https://api.arte.tv/api/player/v1/config/fr/" + video_id + "?autostart=1&lifeCycle=1&amp;lang=fr_FR&amp;mute=0";
        }  

        if (hosting == "ftv") {
            var video_url = "https://embedftv-a.akamaihd.net/" + video_id;
        }   

        $("iframe#video_popup").attr("src", video_url);
        $("iframe#video_popup").show();

        if (window.innerWidth > trigger_width) {$("img#close_player").css("left", "74vw")}
        init_close_player(); 
}

function launch_audio_player(hosting, audio_id) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#close_player").show();

        if (hosting == "soundcloud") {
            
            var audio_url = "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" + audio_id + "&auto_play=true&visual=true";
            $("iframe#audio_popup_soundcloud").attr("src", audio_url);
            $("iframe#audio_popup_soundcloud").show();

            init_close_player();
        }
        else if (hosting == "wix") {

            var audio_url = "https://music.wixstatic.com/preview/" + audio_id + ".mp3";
            $("audio#audio_popup_wix").attr("src", audio_url);
            $("audio#audio_popup_wix").show();

            image_url = "../img/video/" + content_id + "/" + audio_id + ".jpg"
            $("img#audio_popup_wix_image").attr("src", image_url);
            $("img#audio_popup_wix_image").show();
        }
        else if (hosting == "pippa") {

            var audio_url = "https://player.pippa.io/sismique/episodes/" + audio_id + "?auto_play=true";
            $("iframe#audio_popup_pippa").attr("src", audio_url);
            $("iframe#audio_popup_pippa").show();

            image_url = "../img/video/" + content_id + "/" + audio_id + ".jpg"
            $("img#audio_popup_wix_image").attr("src", image_url);
            $("img#audio_popup_wix_image").show();
        }

        if (window.innerWidth > trigger_width) {$("img#close_player").css("left", "64vw")}
        init_close_player();

}
