
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

        if (pager_index[list_id - 1] == page_id)
            $(this).css("background", "rgb(120, 120, 120)");
        else 
            $(this).css("background", "rgb(60, 60, 60)");
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

function scroll_thumbnail(list_id, page_id) {

    $("div#pager_" + list_id + "_" + pager_index[list_id - 1]).css("background", "rgb(60, 60, 60)");
    pager_index[list_id - 1] = page_id;
    $("div#pager_" + list_id + "_" + pager_index[list_id - 1]).css("background", "rgb(120, 120, 120)");

    page_position = - (page_id - 1) * 0.904 * $(window).width();

    $("div#scrolling_container_" + list_id).animate({left : page_position}, 500);

    $("img#right_arrow_container_" + list_id).fadeIn();
    $("img#left_arrow_container_" + list_id).fadeIn();

    if (page_id == 1)
        $("img#left_arrow_container_" + list_id).fadeOut();

    if (page_id == page_number[list_id])
        $("img#right_arrow_container_" + list_id).fadeOut();
}

function listen_left_arrow() {

    // Listen mouse over

    $("img.left_arrow_container").hover(function() {
        $(this).css("cursor","pointer");
        $(this).attr("src", "/img/icons/arrow/page_left_white.png");  

    },function() {
        $(this).css("cursor","auto");
        $(this).attr("src", "/img/icons/arrow/page_left_grey.png");
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
        $(this).attr("src", "/img/icons/arrow/page_right_white.png"); 
               
    },function() {
        $(this).css("cursor","auto");
        $(this).attr("src", "/img/icons/arrow/page_right_grey.png");
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


function listen_content_thumbnail(comment_list) {

    // Listen mouse over

    $("div.thumbnail, div.series_thumbnail, div.user_thumbnail").hover(function() {

        $(this).css("cursor","pointer");
        if (Math.floor(Math.random() * 3) == 1) $("img.donation").trigger("startRumble");

        list_id = this.id.split("-")[0];
        index = this.id.split("-")[1];
        thumbnail_type = this.id.split("-")[2];
        content_id = this.id.split("-")[3];
        param_1 = this.id.split("-")[4];  // user_id_1 or section_id
        param_2 = this.id.split("-")[5];  // user_id_2 or episod_id

        // console.log("div#info_" + list_id + '_' + content_id + '_' + param_2)

        if (window.innerWidth > trigger_width && thumbnail_type != "comment" && content_id != "user") {
            $("div#info_" + list_id + '_' + content_id + '_' + param_2).fadeIn();
            // $("div#series_info_" + list_id + '_' + content_id + '_' + param_2).fadeIn();
        }

        if (thumbnail_type == "search") {
            // $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_action_" + list_id + '_' + index).show();
        }

        if (thumbnail_type == "pending_in") {
            console.log("ici")
            // $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_action_" + list_id + '_' + index).show();
        }

        if (thumbnail_type == "pending_out") {
            // $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_layer_" + list_id + "_" + index).show();
            $("img#user_action_" + list_id + '_' + index).show();
        }

        // if (type_id == "tvshow") {
        //     current_image_url   = "http://www.asset.imagotv.fr/img/episod/tvshow/" + content_id + "/hd/" + episod_id + ".jpg"; 
        //     $("img#current_video").attr("src", current_image_url);
        // }

        // if (type_id == "podcast") {
        //     current_image_url   = "http://www.asset.imagotv.fr/img/episod/podcast/" + content_id + "/hd/" + episod_id + ".jpg"; 
        //     $("img#current_audio").attr("src", current_image_url);
        // }


    },function() {
        $(this).css("cursor","auto");
        $("img.donation").trigger("stopRumble");

        if (window.innerWidth > trigger_width && thumbnail_type != "comment" && content_id != "user") {
            $("div#info_" + list_id + '_' + content_id + '_' + param_2).hide();
            // $("div#series_info_" + list_id + '_' + content_id + '_' + param_2).hide();
        }

        if (window.innerWidth > trigger_width) {
            if (thumbnail_type == "search" || thumbnail_type == "pending_in" || thumbnail_type == "pending_out") {
                $("img#user_layer_" + list_id + '_' + index).hide();
                $("img#user_action_" + list_id + '_' + index).hide();
            }
        }
    });

    // Listen click on

    $("div.series_thumbnail").click(function() {
        $('html,body').animate({scrollTop: 0})
        launch_player("switch", type_id, content_id, param_1, param_2)
    });


    $("div.user_thumbnail").click(function() {

        if (thumbnail_type == "search") {

            $.post("/ws/add_friend.php",
                {
                    user_id_1 : param_1,
                    user_id_2 : param_2
                },
                function(data, status) {
                    // alert("Data: " + data + "\n Status: " + status);
                    status = callback_status(data);

                    if (status == "ok")
                        go_to("");
            });
        }

        if (thumbnail_type == "pending_in") {

            $.post("/ws/accept_friend.php",
                {
                    user_id_1 : param_1,
                    user_id_2 : param_2
                },
                function(data, status) {
                    // alert("Data: " + data + "\n Status: " + status);
                    go_to("");
            });
        }

        if (thumbnail_type == "pending_out") {

            $.post("/ws/remove_friend.php",
                {
                    user_id_1 : param_1,
                    user_id_2 : param_2
                },
                function(data, status) {
                    // alert("Data: " + data + "\n Status: " + status);
                    go_to("");
            });
        }

        if (thumbnail_type == "friend") {

            $.post("/ws/remove_friend.php",
                {
                    user_id_1 : param_1,
                    user_id_2 : param_2
                },
                function(data, status) {
                    // alert("Data: " + data + "\n Status: " + status);
                    go_to("");
            });
        }

        if (thumbnail_type == "comment") {
            index = this.id.split("-")[1];
            display_comment("others", index)
        }

    });
}
