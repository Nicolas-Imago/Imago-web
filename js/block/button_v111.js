
/************************************************ BUTTONS ***********************************************/

set_sharing_url();

$("a#tipeee").attr("href", crowdfunding_url);
// $("a#captain_fact").attr("href", fact_check_url);


function listen_buttons() {

    // Listen mouse over

    $("img.button").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.button").click(function() {

        var action = $(this).attr("id");
        set_cookie("url_cookie", window.location, 1);

        if (action == "content_favorite") {

            if (is_content_favorite == "0") { 

                $.post("/ws/add_favorite.php",
                    {
                        content_id : content_id,
                        section_id : "",
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_favorite").css("opacity", "0.2");
                            if (window.innerWidth < trigger_width) $("img#heart_mobile").show();
                            if (window.innerWidth > trigger_width) $("img#heart_pc").show();
                            is_content_favorite = "1";
                        }
                    }
                )
            }

            else {

                $.post("/ws/remove_favorite.php",
                    {
                        content_id : content_id,
                        section_id : "",
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_favorite").css("opacity", "1");
                            if (window.innerWidth < trigger_width) $("img#heart_mobile").hide();
                            if (window.innerWidth > trigger_width) $("img#heart_pc").hide();
                            is_content_favorite = "0";
                        }                    
                    }
                )
            }
        }

        if (action == "content_later") {

            if (is_content_later == "0") {

                $.post("/ws/add_later.php",
                    {
                        content_id : content_id,
                        section_id : "",
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_later").css("opacity", "0.2");
                            if (window.innerWidth < trigger_width) $("img#time_mobile").show();
                            if (window.innerWidth > trigger_width) $("img#time_pc").show();
                            is_content_later = "1"; 
                        }                      
                    }
                )
            }

            else {

                $.post("/ws/remove_later.php",
                    {
                        content_id : content_id,
                        section_id : "",
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_later").css("opacity", "1");
                            if (window.innerWidth < trigger_width) $("img#time_mobile").hide();
                            if (window.innerWidth > trigger_width) $("img#time_pc").hide();
                            is_content_later = "0"; 
                        }                     
                    }
                )
            }
        }

        if (action == "content_reco") {

            if (is_content_reco == "0") {

                $.post("/ws/add_reco.php",
                    {
                        content_id : content_id,
                        section_id : "",
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_reco").css("opacity", "0.2");
                            if (window.innerWidth < trigger_width) $("img#medal_mobile").show();
                            if (window.innerWidth > trigger_width) $("img#medal_pc").show();
                            is_content_reco = "1"; 
                        }                      
                    }
                )
            }

            else {

                $.post("/ws/remove_reco.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : ""
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#content_reco").css("opacity", "1");
                            if (window.innerWidth < trigger_width) $("img#medal_mobile").hide();
                            if (window.innerWidth > trigger_width) $("img#medal_pc").hide();
                            is_content_reco = "0"; 
                        }                     
                    }
                )
            }
        }

        if (action == "episod_favorite") {

            if (is_episod_favorite == "0") { 

                $.post("/ws/add_favorite.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_favorite").css("opacity", "0.2");
                            $("img#episod_heart").show();
                            is_episod_favorite = "1";
                        }
                    }
                )
            }

            else {

                $.post("/ws/remove_favorite.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_favorite").css("opacity", "1");
                            $("img#episod_heart").hide();
                            is_episod_favorite = "0";
                        }                    
                    }
                )
            }
        }

        if (action == "episod_later") {

            if (is_episod_later == "0") {

                $.post("/ws/add_later.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_later").css("opacity", "0.2");
                            $("img#episod_time").show();
                            is_episod_later = "1"; 
                        }                      
                    }
                )
            }

            else {

                $.post("/ws/remove_later.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_later").css("opacity", "1");
                            $("img#episod_time").hide();
                            is_episod_later = "0"; 
                        }                     
                    }
                )
            }
        }

        if (action == "episod_reco") {

            if (is_episod_reco == "0") {

                $.post("/ws/add_reco.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_reco").css("opacity", "0.2");
                            $("img#episod_medal").show();
                            is_episod_reco = "1"; 
                        }                      
                    }
                )
            }

            else {

                $.post("/ws/remove_reco.php",
                    {
                        content_id : content_id,
                        section_id : section_id,
                        episod_id : episod_id
                    },
                    function(data, status){
                        // alert("Data: " + data + "\n Status: " + status);
                        callback = callback_status(data);

                        if (callback == "ok") {
                            $("img#episod_reco").css("opacity", "1");
                            $("img#episod_medal").hide();
                            is_episod_reco = "0"; 
                        }                     
                    }
                )
            }
        }
    });
}


/************************************************ COMMENT ***********************************************/

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

            $.post("/ws/add_comment.php",
                {
                    content_id : content_id,
                    comment : comment
                },
                function(data, status){
                    // alert("Data: " + data + "\n Status: " + status);
                    callback = callback_status(data);

                    if (callback == "created" || callback == "modified") {
                        $("body").css("overflow", "");
                        $("img#background_shadow, img#close_player").hide();
                        $("img#comment_popup, textarea, a#popup_validate").hide();
                    }

                    else {
                        alert(callback);
                    }
                }
            )
        // }
    });
}