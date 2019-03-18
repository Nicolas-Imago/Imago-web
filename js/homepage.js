
/************************************************ INIT **********************************************/

var pager_index = 2;

init_screen();

function init_screen() {

    // Display screen

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    $("div#slideshow_pager_2").css("background", "rgb(120, 120, 120)");

    $("iframe.live_player").attr("src", "https://www.invidio.us/embed/hbnzQtLS4T8?autoplay=1&fs=1&color=white&showinfo=0&rel=0&mute=0&disablekb=1");  


    // $("div#footer").css("top", "5vw");
    // $("img#layer").delay(5000).fadeOut(200);

    if (window.innerWidth > trigger_width) {
        $("div.info_panorama").hide();
        $("div.info_portrait").hide();
        $("div.info_squared").hide();
    }

    $("div.slideshow_info").hide();

    // listen mouse over, scroll and resize

    listen_slideshow_pager();
    // listen_slideshow_container();
    listen_slideshow_thumbnail();

    listen_type_thumbnail();
    listen_promo_thumbnail();
    listen_content_thumbnail();
    listen_category_thumbnail();

    addEventListener("resize", close_menu_and_user, false);
}

/********************************************** FUNCTION *********************************************/

function scroll_slideshow_thumbnail(page_id) {

    $("div#slideshow_pager_" + pager_index).css("background", "rgb(60, 60, 60)");
    pager_index = page_id;
    $("div#slideshow_pager_" + pager_index).css("background", "rgb(120, 120, 120)");

    page_position = - (page_id - 2) * 0.625 * window.width;
    $("div#slideshow_container").animate({left : page_position}, 500);

}


/*********************************************** LISTEN *********************************************/

function listen_slideshow_pager() {

    // Listen mouse over

    $("div.slideshow_pager").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("background", "rgb(200, 200, 200)");

        pager_id = this.id;
        pager_id = pager_id.replace("pager_", "");

        page_id = pager_id.split("_")[1];

    },function() {
        $(this).css("cursor","auto");

        if (pager_index == page_id) {
            $(this).css("background", "rgb(120, 120, 120)");
        }
        else {
            $(this).css("background", "rgb(60, 60, 60)");
        }
    });

    // Listen click on

    $("div.slideshow_pager").click(function() {
        scroll_slideshow_thumbnail(page_id)
    });   

}

function listen_slideshow_thumbnail() {

    // Listen mouse over

    $("div.slideshow_thumbnail_info").hover(function() {
        $(this).css("cursor","pointer");

        content_id = this.id.split("-")[2];

        if (window.innerWidth > trigger_width) {
            $("div#slideshow_info_" + content_id).fadeIn(200);
        }

    },function() {
        $(this).css("cursor","auto");

        if (window.innerWidth > trigger_width) {
            $("div#slideshow_info_" + content_id).hide();
        }
    });

    // Listen click on

    $("div.slideshow_thumbnail_info").click(function() {

        index = this.id.split("-")[1]
        index = parseInt(index) + 1

        console.log(index)
        console.log(pager_index)

        if (index == pager_index - 1) {
            page_id = pager_index - 1
            scroll_slideshow_thumbnail(page_id)
        }
        else if (index == pager_index + 1) {
            page_id = pager_index + 1
            scroll_slideshow_thumbnail(page_id)
        }
        else {
            go_to("/php/series.php?type_id=tvshow&content_id=" + content_id);
        }  
    });
}

// function listen_slideshow_thumbnail() {

//     // Listen mouse over

//     $("div.slideshow_thumbnail_info").hover(function() {
//         $(this).css("cursor","pointer");

//         content_id = this.id.split("-")[1];

//         console.log(content_id)

//         if (window.innerWidth > trigger_width) {
//             $("div#slideshow_info_" + content_id).fadeIn(200);
//         }

//     },function() {
//         $(this).css("cursor","auto");

//         if (window.innerWidth > trigger_width) {
//             $("div#slideshow_info_" + content_id).hide();
//         }
//     });
// }

function listen_type_thumbnail() {

    // Listen mouse over

    $("img.type").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img.type").click(function() {
        image_source = this.src;
        image_source = image_source.split("/img/homepage/")[1];
        type_id = image_source.split("_")[0];

        go_to("/php/category.php?type_id=" + type_id);
    });
}

function listen_promo_thumbnail() {

    // Listen mouse over

    $("img.promo").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img.info").click(function() {
        go_to("/php/page.php?page_id=presentation");
        // open("https://imagotv.fr/pdf/imago_presentation.pdf");
    });

    $("img.facebook").click(function() {
        open("https://www.facebook.com/imagotv.fr/");
    });

    $("img.subscribe").click(function() {
        if (status == "logout") {
            go_to("/php/subscribe.php");
        }

        if (status == "login") {
            go_to("/php/member.php?");
        }
    });
}

function listen_content_thumbnail() {

    // Listen mouse over

    $("div.thumbnail_info").hover(function() {
        $(this).css("cursor","pointer");

        content_id = this.id.split("-")[3];

        if (window.innerWidth > trigger_width) {
            $("div#info_" + content_id).fadeIn(200);
        }

    },function() {
        $(this).css("cursor","auto");

        if (window.innerWidth > trigger_width) {
            $("div#info_" + content_id).hide();
        }
    });

    // Listen click on

    $("div.thumbnail_info").click(function() {

        type_id = this.id.split("-")[2];
        index = this.id.split("-")[1];

        if (type_id == "tvshow" || type_id == "shortfilm" || type_id == "humour") {         
            var page_size = 4;
        }
        if (type_id == "documentary" || type_id == "podcast" || type_id == "music") {         
            var page_size = 5;   
        }

        list_id = this.id.split("-")[0];
        test_id = index - page_size * (pager_index[list_id - 1] - 1);

        if (test_id == -1) {
            page_id = pager_index[list_id - 1] - 1
            scroll_thumbnail(list_id, page_id)
        }
        else if (test_id == page_size) {
            page_id = pager_index[list_id - 1] + 1
            scroll_thumbnail(list_id, page_id)
        }
        else {
            if (type_id == "tvshow" || type_id == "podcast" || type_id == "humour" || type_id == "music") {
                go_to("/php/series.php?type_id=" + type_id + "&content_id=" + content_id);
            }
            else {
                go_to("/php/movie.php?type_id=" + type_id + "&content_id=" + content_id);
            }
        }  
    });
}

function listen_category_thumbnail() {

    // Listen mouse over

    $("img.category").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img.category").click(function() {
        image_source = this.src;
        image_source = image_source.split("/img/homepage/category/")[1];
        category_id = image_source[0];

        go_to("/php/category.php?category_id=" + category_id);
    });
}
