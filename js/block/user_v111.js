
/*********************************************** INIT *********************************************/

var width = window.innerWidth;

init_user()

function init_user() {

    if (user_status == "logout")
        $("span#item_user_8").hide();
    else
        $("span#item_user_9").hide();

    // user_panel_update()
    listen_user_level1()

    // addEventListener("resize", user_panel_update, false)
}


/********************************************** LEVEL 1 ********************************************/

function listen_user_level1() {

    // Listen mouse over

    $("span.item_user").hover(function() {
        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_user_", "");

        $(this).css("cursor","pointer");

        if (hightlight_id == 8) {
            $("a#text_item_user_8").css("color", "red");
            $("img#icon_item_user_8").attr("src", "/img/icons/user/level_1/menu_icon_white_8_red.png");            
        }

        else if (hightlight_id == 9) {
            $("a#text_item_user_9").css("color", "rgb(0, 255, 90)");
            $("img#icon_item_user_9").attr("src", "/img/icons/user/level_1/menu_icon_white_9_green.png");            
        }

        else {
            $("a#text_item_user_" + hightlight_id).css("color", "white");
            $("img#icon_item_user_" + hightlight_id).attr("src", "/img/icons/user/level_1/menu_icon_white_" + hightlight_id + ".png");
        }

        }, function() {
        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_user_", "");

        $(this).css("cursor","auto"); 
        $("a#text_item_user_" + hightlight_id).css("color", "grey");
        $("img#icon_item_user_" + hightlight_id).attr("src", "/img/icons/user/level_1/menu_icon_grey_" + hightlight_id + ".png");

    });

    // Listen click on

    $("span#item_user_1").click(function() {
        set_cookie("url_cookie", "/favoris", 1);
        go_to("/favoris");
    });

    $("span#item_user_2").click(function() {
        set_cookie("url_cookie", "/memos", 1);
        go_to("/memos");
    });

    $("span#item_user_3").click(function() {
        set_cookie("url_cookie", "/recommandations", 1);
        go_to("/recommandations");
    });

    $("span#item_user_4").click(function() {
        set_cookie("url_cookie", "/amis", 1);
        go_to("/amis");
    });

    $("span#item_user_5").click(function() {
        set_cookie("url_cookie", "/profil", 1);
        go_to("/profil");
    });

    $("span#item_user_6").click(function() {
        set_cookie("url_cookie", "/amis", 1);
        go_to("/amis");
    });

    $("span#item_user_7").click(function() {
        set_cookie("url_cookie", "/dons", 1);
        go_to("/dons");
    });

    $("span#item_user_8").click(function() {

        $.post("/ws/destroy_session.php",
            {
                    // no POST argument
            },
            function(data, status){
                // alert("Data: " + data + "\n Status: " + status);
                go_to("");      // reload on call back
        });
    });

    $("span#item_user_9").click(function() {
        set_cookie("url_cookie", page_url, 1);
        go_to("/connexion");
    });
}


/********************************************** RESIZE ********************************************/

// function user_panel_update() {

//     $("#user").css("margin-left", window.innerWidth);
//     $("#user").show();

// }



