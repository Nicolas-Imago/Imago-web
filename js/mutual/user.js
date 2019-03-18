
/*********************************************** INIT *********************************************/

var width = window.innerWidth;

init_user()

function init_user() {

    user_panel_update()

    listen_user_level1()

    addEventListener("resize", user_panel_update, false)
}


/********************************************** LEVEL 1 ********************************************/

function listen_user_level1() {

    // Listen mouse over

    $("span#item_user_3, span#item_user_4").hover(function() {

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_user_", "");

        $(this).css("cursor","pointer"); 
        // $(this).css("background-color", "rgb(0, 0, 0)");

        $("a#text_item_user_" + hightlight_id).css("color", "rgb(255, 255, 255");
        $("img#icon_item_user_" + hightlight_id).attr("src", "../img/icons/user/level_1/menu_icon_white_" + hightlight_id + ".png");

        }, function() {

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_user_", "");

        $(this).css("cursor","auto"); 
        // $(this).css("background-color", "rgb(0, 0, 0)");

        $("a#text_item_user_" + hightlight_id).css("color", "grey");
        $("img#icon_item_user_" + hightlight_id).attr("src", "../img/icons/user/level_1/menu_icon_grey_" + hightlight_id + ".png");

    });

    // Listen click on

    $("span#item_user_3").click(function() {
        go_to("/php/member.php");
    });

    $("span#item_user_4").click(function() {
        go_to("/php/login.php");
    });
}


/********************************************** RESIZE ********************************************/

function user_panel_update() {

    // $("#user").css("margin-left", window.innerWidth);
    $("#user").show();

}



