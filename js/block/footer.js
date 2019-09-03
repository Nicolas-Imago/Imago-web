
/*********************************************** INIT *********************************************/

init_footer()

function init_footer() {

    // size = window.innerWidth;

    $("img#page_up").hide();
    $("a#info_footer").text("ImagoTV - Plateforme vidéo de la transition - v" + version + " " + env);

    listen_footer_page_right();
    listen_footer_page_left();

    listen_cookie_close();
    init_history_back();

    listen_footer_page_up();
    listen_footer_links();

    addEventListener("scroll", footer_scroll, false);
}


/********************************************** ARROWS ********************************************/

function listen_footer_page_right() {

    // Listen mouse over

    $("img#arrow_right_page").hover(function() {
        $(this).attr("src", "../img/icons/category/page_right_white.png");
    },function() {
        $(this).attr("src", "../img/icons/category/page_right_grey.png");
    });
}

function listen_footer_page_left() {

    // Listen mouse over

    $("img#arrow_left_page").hover(function() {
        $(this).attr("src", "../img/icons/category/page_left_white.png");
    },function() {
        $(this).attr("src", "../img/icons/category/page_left_grey.png");
    });
}


/********************************************* COOKIES *******************************************/

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
    });
}


/********************************************* HISTORY *******************************************/

function init_history_back() {

    $("img#page_back").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    $("img#page_back").click(function() {
        window.history.back();
    });
}


/********************************************* SCROLL UP *******************************************/

function footer_scroll() {

    if (window.scrollY > 0) {$("img#page_up").fadeIn()}
    else {$("img#page_up").fadeOut(200)}         
}

function listen_footer_page_up() {

    // Listen mouse over

    $("#page_up").hover(function() {
        $(this).css("cursor","pointer");
        $("img#page_up").attr("src", "../img/icons/footer/page_up_white.png");
    },function() {
        $(this).css("cursor","auto"); 
        $("img#page_up").attr("src", "../img/icons/footer/page_up_grey.png");
    });

    // Listen click on

    $("#page_up").click(function(){    
        $('html,body').animate({scrollTop: 0}, 'slow')
    });
}


/********************************************** FOOTER *********************************************/

function listen_footer_links() {

    // Listen mouse over

    $("a.item_footer").hover(function() {
        // $(this).css("cursor","pointer"); 
        $(this).css("color", "white");
        }, function() {
        // $(this).css("cursor","auto"); 
        $(this).css("color", "grey");
    });

    // $("a#item_footer_1").click(function() {
    //     go_to("/pdf/imago_presentation.pdf");
    // });

    // $("a#item_footer_2").click(function() {
    //     go_to("/pdf/imago_charte.pdf");
    // });
}

