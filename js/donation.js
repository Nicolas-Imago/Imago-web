
/********************************************** INIT ***********************************************/

var check_item = [];

check_item[1] = [];
check_item[2] = [];
check_item[3] = [];
check_item[4] = [];


init_screen(); 

function init_screen() {

    // Display screen

    $("div#screen").fadeIn(2000);
    $("div#footer").show();


    for (index = 1; index <= 4; index++) {
        $("img#left_arrow_container_" + index).hide();
        $("img#right_arrow_container_" + index).hide();
    }

    for (type_index = 1; type_index <= 4; type_index++)
        for (content_index = 1; content_index <= item_number[1]; content_index++)
            check_item[type_index][content_index] = 0;

    format = "list";

    if (format == "list") {
        $("div.list_container").addClass("list");
        $("div.panorama, img.panorama, img.play_logo_panorama, div.info_panorama").addClass("list");
        $("div.portrait, img.portrait, img.play_logo_portrait, div.info_portrait").addClass("list");
        $("div.squared, img.squared, img.play_logo_squared, div.info_squared").addClass("list");
    }

    // listen mouse over, scroll and resize

    listen_content_thumbnail();

    listen_check();
    listen_check_all();

    addEventListener("resize", close_menu_and_user, false);
}


/********************************************* ACTION **********************************************/

function listen_check() {

    // Listen mouse over

    $("img.check").hover(function() {
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img.check").click(function() {

        list_id = this.id.split("-")[0];
        index = this.id.split("-")[1];

        if (check_item[list_id][index] == 0) {
            $(this).attr("src", "../img/icons/check_on.png");
            check_item[list_id][index] = 1;
        }
        else {
            $(this).attr("src", "../img/icons/check_off.png");
            check_item[list_id][index] = 0;
        }
    });
}

function listen_check_all() {

    // Listen mouse over

    $("a#donation_select").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#donation_select").click(function() {

        for (type_index = 1; type_index <= 4; type_index++)
            for (content_index = 1; content_index <= item_number[1]; content_index++) {
                check_item[type_index][content_index] = 1;
                $("img.check").attr("src", "../img/icons/check_on.png");
            }
    });
}

function listen_donate() {

    // Listen mouse over

    $("a#donation_pay").hover(function() {
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#donation_pay").click(function() {

        alert("")
    });
}

