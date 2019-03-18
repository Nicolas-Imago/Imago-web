
/************************************************ INIT **********************************************/

var test_wheel = "1";
var overflow_hidden = "0";

var pager_index = [1, 1, 1, 1, 1, 1, 1, 1];

// var ppv_cookie = get_cookie("ppv_cookie");

init_screen(); 

function init_screen() {

    // Display screen

    $("div#screen").fadeIn(1000);
    $("div#footer").show();

    for (index = 1; index <= 8; index++) {
        $("div#pager_" + index + "_1").css("background", "rgb(120, 120, 120)");
        $("img#left_arrow_container_" + index).hide();

        if (type_id == "documentary" || type_id == "shortfilm") {
            if (list_size[index] <= 5) {
                $("img#right_arrow_container_" + index).hide();
            }
        }
        else {
            if (list_size[index] <= 4) {
                $("img#right_arrow_container_" + index).hide();
            }
        }
    }

    $("div.info_panorama").hide();
    $("div.info_portrait").hide();
    $("div.info_squared").hide();

    // listen mouse over, scroll and resize

    listen_content_thumbnail();
    listen_left_arrow();
    listen_right_arrow();
    listen_pager();
    listen_container();

    addEventListener("resize", close_menu_and_user, false);

    // if (window.innerWidth > trigger_width) {
    //     addEventListener("wheel", test_scroll, false); 
    // }

    // if (ppv_cookie != "ok") {
    //     $("div#cookie_popup").show();
    // } 
}


/********************************************** FUNCTION *********************************************/

function scroll_thumbnail(list_id, page_id) {

    if (type_id == "tvshow" || type_id == "shortfilm" || type_id == "humour") {         
        var page_size = 4;
    }
    if (type_id == "documentary" || type_id == "podcast" || type_id == "music") {         
        var page_size = 5;   
    }

    $("div#pager_" + list_id + "_" + pager_index[list_id - 1]).css("background", "rgb(60, 60, 60)");
    pager_index[list_id - 1] = page_id;
    $("div#pager_" + list_id + "_" + pager_index[list_id - 1]).css("background", "rgb(120, 120, 120)");

    page_position = - (page_id - 1) * 0.904 * window.width;
    $("div#scrolling_container_" + list_id).animate({left : page_position}, 500);

    $("img#right_arrow_container_" + list_id).fadeIn();
    $("img#left_arrow_container_" + list_id).fadeIn();

    if (page_id == 1) {
        $("img#left_arrow_container_" + list_id).fadeOut();
    }
    if (page_id == Math.trunc(list_size[list_id]/page_size) + 1) {
        $("img#right_arrow_container_" + list_id).fadeOut();
    }
    
}


/*********************************************** LISTEN *********************************************/

// function listen_title() {

//     // Listen mouse over

//     $("a.title").hover(function() {
//         $(this).css("color", "white");
//         $(this).css("cursor","pointer");
//     },function() {
//         $(this).css("color", "grey");
//         $(this).css("cursor","auto");
//     });

//     // Listen click on

//     $("a.title").click(function() {
//         title_id = $(this).attr("id");
//         category_id = title_id.replace("title_", "");
        
//         go_to("/php/category.php?type_id=" + type_id + "&category_id=" + category_id);
//     });
// }

function listen_content_thumbnail() {

    // Listen mouse over

    $("div.thumbnail_info").hover(function() {
        $(this).css("cursor","pointer");

        content_id = this.id.split("-")[3];
        type_id = this.id.split("-")[2];
        index = this.id.split("-")[1];
        list_id = this.id.split("-")[0];

        // console.log(content_id)
        // console.log(type_id)
        // console.log(index)
        // console.log(list_id)

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

        // test_id = index - page_size * (pager_index[list_id - 1] - 1);

        // if (test_id == -1 && window.innerWidth > trigger_width) {
        //     page_id = (pager_index[list_id - 1])
        //     page_id = page_id - 1
        //     scroll_thumbnail(list_id, page_id)
        // }
        // else if (test_id == page_size && window.innerWidth > trigger_width) {
        //     page_id = (pager_index[list_id - 1])
        //     page_id = page_id + 1
        //     scroll_thumbnail(list_id, page_id)
        // }

        // if (index == "more") {
        //     $("div.more").hide();
        //     $("div.ppv").fadeIn();
        // }
        // else {
            if (type_id == "tvshow" || type_id == "podcast" || type_id == "humour" || type_id == "music") {
                go_to("/php/series.php?type_id=" + type_id + "&content_id=" + content_id);
            }
            else {
                go_to("/php/movie.php?type_id=" + type_id + "&content_id=" + content_id);
            }
        // }  
    });
}

function listen_left_arrow() {

    // Listen mouse over

    $("img.left_arrow_container").hover(function() {
        $(this).css("cursor","pointer");
        $(this).attr("src", "../img/icons/category/page_left_white.png");        
    },function() {
        $(this).css("cursor","auto");
        $(this).attr("src", "../img/icons/category/page_left_grey.png");
    });

    // Listen click on

    $("img.left_arrow_container").click(function() {

        if (window.innerWidth > trigger_width) {
            page_id = (pager_index[list_id - 1])
            page_id = page_id - 1
            scroll_thumbnail(list_id, page_id)
        }
    });
}

function listen_right_arrow() {

    // Listen mouse over

    $("img.right_arrow_container").hover(function() {
        $(this).css("cursor","pointer");
        $(this).attr("src", "../img/icons/category/page_right_white.png");        
    },function() {
        $(this).css("cursor","auto");
        $(this).attr("src", "../img/icons/category/page_right_grey.png");
    });

    // Listen click on

    $("img.right_arrow_container").click(function() {

        if (window.innerWidth > trigger_width) {
            page_id = (pager_index[list_id - 1])
            page_id = page_id + 1
            scroll_thumbnail(list_id, page_id)
        }
    });
}

function listen_pager() {

    // Listen mouse over

    $("div.pager").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("background", "rgb(200, 200, 200)");

        pager_id = this.id;
        pager_id = pager_id.replace("pager_", "");

        list_id = pager_id.split("_")[0];
        page_id = pager_id.split("_")[1];

        page_id = parseInt(page_id);

    },function() {
        $(this).css("cursor","auto");

        if (pager_index[list_id - 1] == page_id) {
            $(this).css("background", "rgb(120, 120, 120)");
        }
        else {
            $(this).css("background", "rgb(60, 60, 60)");
        }
    });

    // Listen click on

    $("div.pager").click(function() {
        scroll_thumbnail(list_id, page_id)
    });   

}

function listen_container() {  

    $("div.scrolling_container").hover(function() {
        container_id = this.id;
        container_id = container_id.replace("scrolling_container_", "");
        list_id = container_id.split("_")[0];
    });
}

// function test_scroll(event) {

//     // active horizontal or vertical scrolling separately

//     if ((event.deltaX > 5 || event.deltaX < - 5) && overflow_hidden == "0") {
//         overflow_hidden = "1";
//         $("html").css("overflow-y", "hidden");
//     }
//     else if ((event.deltaY > 5 || event.deltaY < - 5) && overflow_hidden == "1") {
//         overflow_hidden = "0";
//         $("html").css("overflow-y", "visible");
//     }

//     // horizontal scrolling 

//     if (event.deltaX > 20 && test_wheel == "1") {
//         test_wheel = "0";
//         page_id = pager_index[list_id - 1] + 1;
//         scroll_thumbnail(list_id, page_id)
//     }
//     else if (event.deltaX > 0 && event.deltaX < 10 && test_wheel == "0") {
//         test_wheel = "1";
//     }

//     if (event.deltaX < - 20 && test_wheel == "1") {
//         test_wheel = "0";
//         page_id = pager_index[list_id - 1] - 1;
//         scroll_thumbnail(list_id, page_id)
//     }
//     else if (event.deltaX < 0 && event.deltaX > -10 && test_wheel == "0") {
//         test_wheel = "1";
//     }

// }
