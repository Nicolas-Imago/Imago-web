
function listen_buttons(content_id, episod_id, user_id) {

    // Listen mouse over

    $("img.button").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.button").click(function() {

        var action = $(this).attr("id");
        sharing_url = encodeURIComponent(page_url);

        if (action == "crowdfunding") {
            open(crowdfunding_url, "_blank")
        }

        if (action == "fact_check") {
            open(fact_check_url, "_blank")
        }

        if (action == "trombinobooq") {
            open("https://www.facebook.com/dialog/share?app_id=593792624381849&display=popup&href=" + sharing_url, "_blank")
        }

        if (action == "cock_a_doodle_doo") {
            open("https://twitter.com/intent/tweet?url=" + sharing_url + "&via=ImagoTV_fr", "_blank")
        }

        if (action == "favorite") {

            set_cookie("url_cookie", page_url, 1);

            if (is_favorite == "0") { 

                $.post("../ws/add_favorite.php",
                    {
                        user_id : user_id,
                        content_id : content_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        status = callback_status(data);

                        if (status == "ok") {
                            $("img#favorite").css("opacity", "0.2");
                            $("img#heart").show();
                            is_favorite = "1";
                        }
                    }
                )
            }

            else {

                $.post("../ws/remove_favorite.php",
                    {
                        user_id : user_id,
                        content_id : content_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        status = callback_status(data);

                        if (status == "ok") {
                            $("img#favorite").css("opacity", "1");
                            $("img#heart").hide();
                            is_favorite = "0";
                        }                    
                    }
                )
            }
        }

        if (action == "watch_later") {

            set_cookie("url_cookie", page_url, 1);

            if (watch_later == "0") {

                $.post("../ws/add_later.php",
                    {
                        user_id : user_id,
                        content_id : content_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        status = callback_status(data);

                        if (status == "ok") {
                            $("img#watch_later").css("opacity", "0.2");
                            $("img#time").show();
                            watch_later = "1"; 
                        }                      
                    }
                )
            }

            else {

                $.post("../ws/remove_later.php",
                    {
                        user_id : user_id,
                        content_id : content_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        status = callback_status(data);

                        if (status == "ok") {
                            $("img#watch_later").css("opacity", "1");
                            $("img#time").hide();
                            watch_later = "0"; 
                        }                     
                    }
                )
            }
        }

        if (action == "comment") {

            $.post("../ws/read_comment.php",
                {
                    user_id : user_id,
                    content_id : content_id,
                },
                function(data, status){
                    // alert("Data: " + data + "\n Status: " + status);
                    
                    data = '[' + data.split('"[')[1];
                    data = data.substring(0, data.length - 2);

                    comment_list = JSON.parse(data);
                    display_comment("mine", 1);
                }
            )          
        }
    });
}

function display_comment(type, comment_index) {

        $("body").css("overflow", "hidden");
        $("img#background_shadow, img#close_player").show();

        if (type == "mine")     $("a#title, a#remove, a#validate").show();
        if (type == "others")   $("a#previous, a#next, a#useless, a#useful").show();

        $("img#comment_popup, textarea, a#comment_validate, a#comment_remove").show();
        comment_index = comment_list.length - comment_index;
        $("textarea").text(comment_list[comment_index].comment);
        $("textarea").focus();

        console.log(comment_list[comment_index])

        image_src = "../img/icons/comment_" + comment_list[comment_index].color + ".png";

        $("img#comment_popup").attr("src", image_src);

        if (window.innerWidth > trigger_width) {$("img#close_player").css("left", "64vw")}
        init_close_popup();

        listen_comment_validate();
}

function init_close_popup() {

    $("img#close_player").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("opacity","1");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("opacity","0.7");
    });

    $("img#close_player").click(function() {

        $("body").css("overflow", "");
        
        $("img#background_shadow, img#close_player").hide();
        $("a.comment").hide();
        $("img#comment_popup, textarea").hide();

    });
}

function listen_comment_validate() {

    // Listen mouse over

    $("a#comment_validate").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("a#comment_validate").click(function() {

        comment = $("textarea").val();

        // if (is_favorite == "0") { 

            $.post("../ws/add_comment.php",
                {
                    user_id : user_id,
                    content_id : content_id,
                    comment : comment
                },
                function(data, status){
                    alert("Data: " + data + "\n Status: " + status);
                    status = callback_status(data);

                    if (status == "created" || status == "modified") {
                        $("body").css("overflow", "");
                        $("img#background_shadow, img#close_player").hide();
                        $("img#comment_popup, textarea, a#popup_validate").hide();
                    }

                    else {
                        alert(status);
                    }
                }
            )
        // }
    });
}