
var menu_mode = 0;
var user_mode = 0;

var animation_scroll = 0;
var rgpd_cookie = get_cookie("rgpd_cookie");

init_header()

function init_header() {

    resize_header();

    $("#header, #menu, #user").show();

    listen_header_logo();  
    listen_header_title();

    listen_menu_button();
    listen_user_button();

    listen_drop_down();

    listen_cookie_close();
    listen_screen_mouseover();

    addEventListener("resize", resize_header, false);
    
    if (rgpd_cookie != "ok") {
        $("div#cookie_popup").show();
    } 
}


/********************************************* RESIZE ********************************************/

function resize_header() {

    // remove text in header on smartphone 

    if (window.innerWidth > trigger_width) {
        animation_scroll = 0.22 * window.innerWidth
        $("a#menu_text").show();
        $("a#user_text").show();

    } else {
        animation_scroll = 0.8 * window.innerWidth
        $("a#menu_text").hide();
        $("a#user_text").hide();
    }
};


/******************************************** OPEN/CLOSE *******************************************/

function open_menu() {

    $("#menu").animate({left : animation_scroll}, 500);
    $("img#menu_button").attr("src", "../img/icons/menu/menu_icon_close_white.png");
    $("a#menu_text").css("color", "white");
    $("body").css("overflow", "hidden");
};

function close_menu() {

    $("#menu").animate({left : "0px"}, 500);
    $("img#menu_button").attr("src", "../img/icons/menu/menu_icon_open_white.png");
    $("a#menu_text").css("color", "white");
    $("body").css("overflow", "");
};

function open_user() {

    $("#user").animate({left : -animation_scroll}, 500);
    $("img#user_button").attr("src", "../img/icons/user/user_icon_close_white.png");
    $("a#user_text").css("color", "white");
    $("body").css("overflow", "hidden");
};

function close_user() {

    $("#user").animate({left : "0px"}, 500);
    $("img#user_button").attr("src", "../img/icons/user/user_icon_open_white.png");
    $("a#user_text").css("color", "white");
    $("body").css("overflow", "");
};

function close_menu_and_user() {

    if (menu_mode == 1) {
        menu_mode = 0;
        $("#menu").animate({left : "0px"}, 500);
        $("img#menu_button").attr("src", "../img/icons/menu/menu_icon_open_grey.png")
    }

    if (user_mode == 1) {
        user_mode = 0;
        $("#user").animate({left : "0px"}, 500);
        $("img#user_button").attr("src", "../img/icons/user/user_icon_open_grey.png")
    }    
}


/*********************************************** TITLE *********************************************/

function listen_header_logo() {

    // Listen mouse over

    $("img#imago_logo").hover(function() {
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img#imago_logo").click(function() {
        go_to("/php/homepage.php");
    });
}

function listen_header_title() {

    // Listen mouse over

    $("a.header_text").hover(function() {
        $(this).css("cursor","pointer"); 
        $(this).css("color", "white");
    },function() {
        $(this).css("cursor","auto"); 
        $(this).css("color", "grey");
    });

    // Listen click on

    $("a#live_text").click(function() {
        go_to("/php/homepage.php");
    });

    $("a#tvshow_text").click(function() {
        go_to("/php/category.php?type_id=tvshow");
    });

    $("a#documentary_text").click(function() {
        go_to("/php/category.php?type_id=documentary");
    });

   $("a#podcast_text").click(function() {
        go_to("/php/category.php?type_id=podcast");
    });

   $("a#shortfilm_text").click(function() {
        go_to("/php/category.php?type_id=shortfilm");
    });

    $("a#search_text").click(function() {
        go_to("/php/search.php");
    });

    $("a#category_text").click(function() {
        $("ol#sub_list").animate({top : "3vw"}, 500);
        // go_to("/php/category.php?category_id=2");
    });
}

function listen_drop_down() {

    // Listen mouse over

    $("a.text_category_list").hover(function() {
        $(this).css("cursor","pointer"); 
        $(this).css("color", "white");
    },function() {
        $(this).css("cursor","auto"); 
        $(this).css("color", "grey");
    });

    $("ol#sub_list").hover(function() {
    },function() {
        $("ol#sub_list").animate({top : "-15vw"}, 500);
    });

    // Listen click on

    $("a.text_category_list").click(function() {
        category_id = $(this).attr("id");
        category_id = category_id.replace("text_category_list_", "");
        go_to("/php/category.php?category_id=" + category_id);
    });
}


/*********************************************** ICONS *********************************************/

function listen_menu_button() {

    // Listen mouse over

    $("img#menu_button, a#menu_text").hover(function() {
        $(this).css("cursor","pointer"); 
    	if (menu_mode == 1) {$("img#menu_button").attr("src", "../img/icons/menu/menu_icon_close_white.png")}
        if (menu_mode == 0) {$("img#menu_button").attr("src", "../img/icons/menu/menu_icon_open_white.png")}
        $("a#menu_text").css("color", "white");
    },function() {
        $(this).css("cursor","auto"); 
    	if (menu_mode == 1) {$("img#menu_button").attr("src", "../img/icons/menu/menu_icon_close_grey.png")}
        if (menu_mode == 0) {$("img#menu_button").attr("src", "../img/icons/menu/menu_icon_open_grey.png")}
        $("a#menu_text").css("color", "grey");
    });

    // Listen click on

    $("img#menu_button, a#menu_text").click(function() {
        if (menu_mode == 1) {
            menu_mode = 0;
            close_menu();
        }
        else {
            menu_mode = 1;
            open_menu();
        }
    });

}

function listen_user_button() {

    // Listen mouse over

    $("img#user_button, a#user_text").hover(function() {
        $(this).css("cursor","pointer"); 
        if (user_mode == 1) {$("img#user_button").attr("src", "../img/icons/user/user_icon_close_white.png")};
        if (user_mode == 0) {$("img#user_button").attr("src", "../img/icons/user/user_icon_open_white.png")};
        $("a#user_text").css("color", "white");
    },function() {
        $(this).css("cursor","auto"); 
        if (user_mode == 1) {$("img#user_button").attr("src", "../img/icons/user/user_icon_close_grey.png")};
        if (user_mode == 0) {$("img#user_button").attr("src", "../img/icons/user/user_icon_open_grey.png")};
        $("a#user_text").css("color", "grey");
    });

    // Listen click on

    $("img#user_button, a#user_text").click(function() {

        console.log(status);

        if (status == "logout") {
            go_to("/php/login.php");
        }

        if (status == "login") {
            if (user_mode == 1) {
                user_mode = 0;
                close_user();
            }
            else {
                user_mode = 1;
                open_user();
            }
        }
    });
}

function listen_screen_mouseover() {

    if (window.innerWidth > trigger_width) {

        $("div#screen").hover(function() {
            if (menu_mode == 1) {
                menu_mode = 0;
                close_menu();
            }
            if (user_mode == 1) {
                user_mode = 0;
                close_user();
            }
        });
    }
}

function listen_cookie_close() {

    // Listen mouse over

    $("img#close_cookies").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    // Listen click on

    $("img#close_cookies").click(function() {
        $("div#cookie_popup").fadeOut(500);
        set_cookie("rgpd_cookie", "ok", 30);
        console.log(get_cookie("rgpd_cookie"))
    });
}
