
/*********************************************** CONTENT ***********************************************/

function listen_name() {

    // Listen mouse over

    $("a.name").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a.name").click(function() {     
        open("/admin/content_form.php?content_id=" + content_id);
    });
}

function listen_author() {

    // Listen mouse over

    $("img.author_image").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.author_image").click(function() {
        var author_id = $(this).attr("src")
        author_id = author_id.split("img/author/thumbnail/")[1];
        author_id = author_id.split(".")[0]
        
        go_to("/php/creator.php?type_id=author&creator_id=" + author_id);
    });
}

function listen_category() {

    // Listen mouse over

    $("a.category").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color","white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color","grey");
    });

    // Listen click on

    $("a.category").click(function() {
        var text = $(this).text();
        text = text.replace(" ", "");
        text = text.replace(" ", "");
        category_tmp = category_id_of(text);

        go_to("/php/category.php?category_id=" + category_tmp);
    });
}

function listen_producer() {

    // Listen mouse over

    $("a.data").hover(function() {

        if ($(this).text() != " non renseigné " && type_id == "documentary") {
            $(this).css("cursor","pointer");
            $(this).css("color","white");
        }
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color","grey");
    });
}

function listen_my_contents() {

    // Listen mouse over

    $("img.display").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("img#episod_heart, img#heart_mobile, img#heart_pc").click(function() {
        go_to("/favoris")
    });

    $("img#episod_time, img#time_mobile, img#time_pc").click(function() {
        go_to("/memos")
    });

    $("img#episod_medal, img#medal_mobile, img#medal_pc").click(function() {
        go_to("/recommandations")
    });
}

function listen_note() {

    // Listen mouse over

    $("div.note").hover(function() {
        $(this).css("cursor","pointer");
    },function() {
        $(this).css("cursor","auto"); 
    });

    // Listen click on

    $("img.note_image").click(function() {
        var note_id = $(this).attr("id");
        note_category = note_id.split("_")[1];
        note_value[note_category] = note_id.split("_")[2];

        // console.log("Je vote " + note_value[note_category] + " dans la catégorie " + note_category)

        if (note_category == 1) {note_trigger = note_1}
        if (note_category == 2) {note_trigger = note_2}
        if (note_category == 3) {note_trigger = note_3}

        for (index = 1; index <= 5; index++) {
            if (index <= note_value[note_category]) {
                $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_white.png")
            }
            else {
                if (index <= note_trigger) {
                    $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_light_grey.png")
                }
                else {
                    $("img#note_" + note_category + "_" + index).attr("src", "../img/icons/notation/star_grey.png")
                }
            }
        } 

        $("a.set_note").show();
    });
}

function listen_note_setting() {

    $("a.set_note").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color","white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color","grey"); 
    });

    $("a.set_note").click(function() {

        $.post("../php/functions/set_note.php",
            {
                type_id : type_id,
                content_id : content_id,
                note_1 : note_value[1],
                note_2 : note_value[2],
                note_3 : note_value[3]
            },
            function(data, status){
                // alert("Data: " + data + "\n Status: " + status);
        });

        $("a.set_note").hide();

        for (note_category_index = 1; note_category_index <= 3; note_category_index++) {
            for (index = 1; index <= 5; index++) {
                if (index <= note_value[note_category_index]) {
                    $("img#note_" + note_category_index + "_" + index).attr("src", "../img/icons/notation/star_light_grey.png")
                }
                else {
                    $("img#note_" + note_category_index + "_" + index).attr("src", "../img/icons/notation/star_grey.png")   
                }
            } 
        }
    });
}

