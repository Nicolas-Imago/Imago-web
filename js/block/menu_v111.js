
/*********************************************** INIT *********************************************/

var expand = new Array;

init_menu()

function init_menu() {

    listen_menu_level1();
    // listen_menu_level2();
    listen_menu_down()
}


/********************************************** LEVEL 1 ********************************************/

function listen_menu_level1() {

    // Listen mouse over

    $("span.item_menu").hover(function() {
        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_menu_", "");

        $(this).css("cursor","pointer"); 
        $("a#text_item_menu_" + hightlight_id).css("color", "white");
        $("img#icon_item_menu_" + hightlight_id).attr("src", "/img/icons/menu/level_1/menu_icon_white_" + hightlight_id + ".png");

        }, function() {
        var hightlight_id = $(this).attr("id");
        hightlight_id = hightlight_id.replace("item_menu_", "");

        $(this).css("cursor","auto"); 
        $("a#text_item_menu_" + hightlight_id).css("color", "grey");
        $("img#icon_item_menu_" + hightlight_id).attr("src", "/img/icons/menu/level_1/menu_icon_grey_" + hightlight_id + ".png");

    });
}


function listen_menu_down() {

    // FOR TEST ONLY

    $("img.icon_item_down").hover(function() {

        $(this).css("cursor","pointer"); 

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) { $("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/up_white.png");}
        else {$("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/down_white.png");}

        }, function() {

        $(this).css("cursor","auto"); 

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) {$("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/up_grey.png");}
        else {$("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/down_grey.png");}

    });

    // Listen click on

    $("img.icon_item_down").click(function(){

        var expand_id = $(this).attr("id");
        expand_id = expand_id.replace("icon_item_down_", "");

        if (expand[expand_id]) {
            expand[expand_id] = false;
            $("#sub_list_" + expand_id).slideUp();
            $("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/down_white.png");
        }
        else {
            expand[expand_id] = true;
            $("#sub_list_" + expand_id).slideDown();
            $("img#icon_item_down_" + expand_id).attr("src", "/img/icons/menu/up_white.png");
        }
    });
}


/********************************************** LEVEL 2 ********************************************/

// function listen_menu_level2() {

//     // Listen mouse over

//     $("a.sub_list_item").hover(function() {
//         $(this).css("color","white");

//         }, function() {
//         $(this).css("color","grey");
//     });
// }





