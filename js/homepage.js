
/************************************************ INIT **********************************************/

var pager_index = [1, 1, 1, 1, 1];

init_screen();

function init_screen() {

    // Display screen

    set_cookie("url_cookie", page_url, 1);

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    for (index = 1; index <= 5; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (page_number[index] <= 1)
            $("img#right_arrow_container_" + index).hide();
    }

    // $("div#slideshow_pager_2").css("background", "rgb(120, 120, 120)");

    $("iframe.live_player").attr("src", "https://www.youtube.com/embed/w_yQp2G7k04?autoplay=1&fs=1&color=white&showinfo=0&rel=0&mute=0&disablekb=1");  
    $("a#switch_fr").hide();

    $("img#page_back").hide()

    if (window.innerWidth > trigger_width) {
        $("div.info_panorama, div.info_portrait, div.info_squared").hide();
        $("div.series_info_panorama, div.series_info_squared").hide();
    }


    // listen mouse over, scroll and resize

    listen_buttons();

    listen_switch();

    // listen_slideshow_pager();
    // listen_slideshow_container();
    // listen_slideshow_thumbnail();

    // listen_docu_thumbnail();
    // listen_promo_thumbnail();

    // listen_folder_thumbnail();
    // listen_corner_thumbnail();

    // listen_type_thumbnail();
    // listen_category_thumbnail();

    listen_pager();
    listen_left_arrow();
    listen_right_arrow();
    listen_container();
    listen_content_thumbnail();

    addEventListener("resize", close_menu_and_user, false);
}

/********************************************** FUNCTION *********************************************/

function listen_switch() {

    // Listen mouse over

    $("a.switch").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#switch_fr").click(function() {
        $("iframe.live_player").attr("src", "https://www.youtube.com/embed/w_yQp2G7k04?autoplay=1&fs=1&color=white&showinfo=0&rel=0&mute=0&disablekb=1");  
        $("a#switch_fr").hide();
        $("a#switch_en").show();
    });

    $("a#switch_en").click(function() {
        $("iframe.live_player").attr("src", "https://www.youtube.com/embed/svULUXvAblU?autoplay=1&fs=1&color=white&showinfo=0&rel=0&mute=0&disablekb=1");  
        $("a#switch_en").hide();
        $("a#switch_fr").show();
    });

}

// function scroll_slideshow_thumbnail(page_id) {

//     $("div#slideshow_pager_" + pager_index).css("background", "rgb(60, 60, 60)");
//     pager_index = page_id;
//     $("div#slideshow_pager_" + pager_index).css("background", "rgb(120, 120, 120)");

//     page_position = - (page_id - 2) * 0.625 * window.width;
//     $("div#slideshow_container").animate({left : page_position}, 500);

// }


/*********************************************** LISTEN *********************************************/


// function listen_docu_thumbnail() {

//     // Listen mouse over

//     $("img.docu").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.docu").click(function() {
//         image_source = this.src;
//         image_source = image_source.split("/img/homepage/")[1];
//         action = image_source.split(".")[0];

//         if (action == "album_kalune") {
//             go_to("/php/series.php?type_id=music&content_id=kalune_aimer"); 
//         }

//         if (action == "event_tres_court") {
//             open("https://trescourt.com/fr/48h");
//         }

//         if (action == "event_otravia") {
//             open("https://www.facebook.com/events/484611235640242/");
//         }

//         if (action == "event_low_carbon") {
//             open("https://www.facebook.com/events/343132969887724/");
//         }

//         if (action == "cine_l_epoque") {
//             open("http://www.bacfilms.com/distribution/fr/films/young-and-alive"); 
//         }

//         if (action == "cine_les_media_le_monde_et_moi") {
//             open("https://lesmediaslemondeetmoi.com");
//         }

//         if (action == "spectacle_giorgia") {
//             open("https://www.lanouvelleseine.com/event/4829/2019-05-23/"); 
//         }

//         if (action == "spectacle_nina") {
//             open("https://www.marieclaireneveu.com/nina-des-tomates-et-des-bombes");
//         }

//         if (action == "tres_court_gaia") {
//             go_to("/php/movie.php?type_id=shortfilm&content_id=gaia");
//         }

//         if (action == "tres_court_100_pourcent_dechets") {
//             go_to("/php/movie.php?type_id=shortfilm&content_id=une_famille_100_pourcent_dechets");
//         }

//     });
// }

// function listen_promo_thumbnail() {

//     // Listen mouse over

//     $("img.promo").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.info").click(function() {
//         go_to("/php/page.php?page_id=qui_sommes_nous");
//     });

//     $("img.donate").click(function() {
//         go_to("/php/page.php?page_id=aidez_nous#help_1");
//     });

//     $("img.facebook").click(function() {
//         open("https://www.facebook.com/imagotv.fr/");
//     });

//     $("img.subscribe").click(function() {
//         if (status == "logout") {
//             go_to("/php/login.php");
//         }

//         if (status == "login") {
//             go_to("/php/member.php?");
//         }
//     });
// }

// function listen_corner_thumbnail() {

//     // Listen mouse over

//     $("img.corner").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.corner").click(function() {
//         image_source = this.src;
//         image_source = image_source.split("/img/corner/")[1];
//         corner_id = image_source.split(".")[0];

//         go_to("/php/corner.php?corner_id=" + corner_id);
//     });
// }

// function listen_folder_thumbnail() {

//     // Listen mouse over

//     $("img.folder").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.folder").click(function() {
//         image_source = this.src;
//         image_source = image_source.split("/img/folder/")[1];
//         query_id = image_source.split(".")[0];

//         go_to("/php/list.php?list_id=folder&query_id=" + query_id);
//     });
// }

// function listen_category_thumbnail() {

//     // Listen mouse over

//     $("img.category").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.category").click(function() {
//         image_source = this.src;
//         image_source = image_source.split("/img/homepage/category/")[1];
//         category_id = image_source[0];

//         go_to("/php/category.php?category_id=" + category_id);
//     });
// }

// function listen_type_thumbnail() {

//     // Listen mouse over

//     $("img.type").hover(function() {
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("img.type").click(function() {
//         image_source = this.src;
//         image_source = image_source.split("/img/homepage/")[1];
//         type_id = image_source.split("_")[0];

//         go_to("/php/category.php?type_id=" + type_id);
//     });
// }

