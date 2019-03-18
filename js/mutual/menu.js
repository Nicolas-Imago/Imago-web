
/*********************************************** INIT *********************************************/

init_menu()

function init_menu() {

    listen_menu_level1();
    listen_menu_level2();
    listen_menu_down()
}


/********************************************** LEVEL 1 ********************************************/

var expand = new Array;

function listen_menu_level1() {

    // Listen mouse over

    $("a#text_item_menu_0, a#text_item_menu_1, a#text_item_menu_3, a#text_item_menu_4, a#text_item_menu_5, a#text_item_menu_6, a#text_item_menu_7, a#text_item_menu_9").hover(function() {

        $(this).css("cursor","pointer"); 

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("text_item_menu_", "");

        $("a#text_item_menu_" + hightlight_id).css("color", "rgb(255, 255, 255");
        $("img#icon_item_menu_" + hightlight_id).attr("src", "../img/icons/menu/level_1/menu_icon_white_" + hightlight_id + ".png");

        }, function() {

        $(this).css("cursor","auto"); 

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("text_item_menu_", "");

        $("a#text_item_menu_" + hightlight_id).css("color", "grey");
        $("img#icon_item_menu_" + hightlight_id).attr("src", "../img/icons/menu/level_1/menu_icon_grey_" + hightlight_id + ".png");

    });

    // Listen click on

    $("a#text_item_menu_0, a#text_item_menu_1, a#text_item_menu_3, a#text_item_menu_4, a#text_item_menu_5, a#text_item_menu_6, a#text_item_menu_7, a#text_item_menu_9").click(function() {

        type_id = $(this).attr("id");
        type_id = type_id.replace("text_item_menu_", "");

        if (type_id.split("_")[0] == 0) {
            go_to("/php/search.php");
        }
        if (type_id.split("_")[0] == 1) {
            go_to("/php/homepage.php");
        }
        if (type_id.split("_")[0] == 2) {
        }
        else {
            if (type_id.split("_")[0] == 3) {
                go_to("/php/category.php?type_id=tvshow");
            }
            if (type_id.split("_")[0] == 4) {
                go_to("/php/category.php?type_id=documentary");
            }
            if (type_id.split("_")[0] == 5) {
                go_to("/php/category.php?type_id=podcast");
            };
            if (type_id.split("_")[0] == 6) {
                go_to("/php/category.php?type_id=shortfilm");
            }
            if (type_id.split("_")[0] == 7) {
                go_to("/php/category.php?type_id=humour");
            }

            // if (type_id.split("_")[0] == 8) {type_id = "kids"};

            if (type_id.split("_")[0] == 9) {
                go_to("/php/category.php?type_id=music");
            }          
        }
    });
}


function listen_menu_down() {

    // FOR TEST ONLY

    $("img.icon_item_down").hover(function() {

        $(this).css("cursor","pointer"); 

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) {
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/up_white.png");
        }
        else {
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/down_white.png");
        }

        }, function() {

        $(this).css("cursor","auto"); 

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) {
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/up_grey.png");
        }
        else {
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/down_grey.png");
        }

    });

    // Listen click on

    $("img.icon_item_down").click(function(){

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) {
            expand[expand_id] = false;
            $("#sub_list_" + expand_id).slideUp();
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/down_white.png");
        }
        else {
            expand[expand_id] = true;
            $("#sub_list_" + expand_id).slideDown();
            $("img#icon_item_down_" + expand_id).attr("src", "../img/icons/menu/up_white.png");
        }
    });
}


/********************************************** LEVEL 2 ********************************************/

function listen_menu_level2() {

    // Listen mouse over

    $("a.text_tvshow_list_item").hover(function() {

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("text_tvshow_list_item_", "");

        id = hightlight_id.split("_")[1];

        $(this).css("cursor","pointer"); 

        $("a#text_tvshow_list_item_" + hightlight_id).css("color", "rgb(255, 255, 255");
        $("img#icon_tvshow_list_item_" + hightlight_id).attr("src", "../img/icons/menu/level_2/menu_icon_white_" + id + ".png");

        }, function() {

        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("text_tvshow_list_item_", "");

        id = hightlight_id.split("_")[1];

        $(this).css("cursor","auto"); 

        $("a#text_tvshow_list_item_" + hightlight_id).css("color", "grey");
        $("img#icon_tvshow_list_item_" + hightlight_id).attr("src", "../img/icons/menu/level_2/menu_icon_grey_" + id + ".png");

    });

    // Listen click on

    $("a.text_tvshow_list_item").click(function() {

        category_id = $(this).attr("id");
        category_id = category_id.replace("text_tvshow_list_item_", "");

        if (category_id.split("_")[0] == 3) {type_id = "tvshow"};
        if (category_id.split("_")[0] == 4) {type_id = "documentary"};

        category_id = category_id.split("_")[1];
        go_to("/php/category.php?type_id=" + type_id + "&category_id=" + category_id);

    });
}





