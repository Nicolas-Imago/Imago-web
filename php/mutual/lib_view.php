<?php

// Display functions
function display_link($link) {
    global $content;
    global $type_id, $content_id, $page_url;

    if ($link == "crowdfunding" AND strlen($content[$link]) != 0) {
        ECHO ' href = "' . $content[$link] . ' " ';
    } else if ($link == "admin") {
        ECHO ' href = "/admin/content_form.php?type_id=' . $type_id . '&content_id=' . $content_id . '"';
        ECHO ' onclick = "window.open(this.href); return false"';
    } else if (($link == "vod" OR $link == "dvd") AND strlen($content[$link]) != 0) {
        ECHO ' href = "' . $content[$link] . ' " ' ;
    }
}


function display_image($link) {
    global $content, $content_id, $type_id, $video_id;
    global $author_id_list, $author_number;

    if ($link == "logo") {
        ECHO ' src = "../img/' . $type_id . '/thumbnail/' . $content_id . '.jpg" ';
    } else if ($link == "cover") {
        ECHO ' src = "../img/' . $type_id . '/cover/' . $content_id . '.jpg" ';
    } else if ($link == "vod" OR $link == "dvd") {
        if (strlen($content[$link]) == 0) {$logo_color = "dark_grey";}
        if (strlen($content[$link]) != 0) {$logo_color = "grey";}
        ECHO ' src = "../img/' . $type_id . '/icons/' . $link . '_logo_' . $logo_color . '.png" ';
    } else if ($link == "crowdfunding" AND $content["crowdfunding"] != "") {
        ECHO ' src = "../img/icons/share/tipeee.png" ';
        ECHO ' style = "display : block" ';
    } else if ($link == "background") {
        ECHO ' src = "../img/' . $type_id . '/background/' . $content_id . '.jpg" ';
    } else if ($link == "og_image") {
        if ($video_id == "") {
            if ($type_id == "documentary" OR $type_id == "shortfilm") {
                ECHO 'http://www.imagotv.fr/img/' . $type_id . '/cover_big/' . $content_id . '.jpg';
            } else {
                ECHO 'http://www.imagotv.fr/img/' . $type_id . '/background/' . $content_id . '.jpg';
            }
        } else {
            if ($content["thumbnail"] == "local") {
                ECHO 'http://www.imagotv.fr/img/video/' . $content_id . '/hd/' . $video_id . '.jpg';
            } else {
                ECHO 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
            }
        }
    } else if ($link == "author") {
        for ($author_index = 0; $author_index <= $author_number - 1; $author_index++) {
            $author_id = $author_id_list[$author_index];

            ECHO ' <img ';
            ECHO ' id = "author_image_' . $author_index . '" ';
            ECHO ' class = "author_image" ';
            ECHO ' src = "../img/author/thumbnail/' . $author_id . '.png" ';
            ECHO ' > ';
        }
    }
}


function display_note($index, $note) {
    global $content;

    if ($index <= $content["note_" . $note]) {
        ECHO ' src = "../img/icons/notation/star_light_grey.png" ';
    } else {
        ECHO ' src = "../img/icons/notation/star_grey.png" ';}
}


// Horizontal navigation
function display_next() {
    // global $type_id, $category_id;

    ECHO 'style = "display:none;" ';

    // if ($category_id == 8) {
    //     ECHO 'style = "display:none;" ';
    // }
    // else if ($category_id <= 7) {
    //     $next = $category_id + 1;
    //     ECHO 'href = "category.php?type_id=' . $type_id . '&category_id=' . $next . '"';
    // }
}


function display_preview() {
    // global $type_id, $category_id;
    ECHO 'style = "display:none;" ';

    // if ($category_id == 1) {
    //     ECHO 'style = "display:none;" ';
    // }
    // else if ($category_id >= 2) {
    //     $previous = $category_id - 1;
    //     ECHO 'href = "category.php?type_id=' . $type_id . '&category_id=' . $previous . '"';
    // }
}


// General functions
function get_time() {
    date_default_timezone_set("Europe/Paris"); // CDT
    $info = getdate();

    $year = $info["year"];
    $month = $info["mon"];
    $date = $info["mday"];
    $hour = $info["hours"];
    $min = $info["minutes"];
    $sec = $info["seconds"];

    $month = sprintf("%02d", $month);
    $date = sprintf("%02d", $date);
    $hour = sprintf("%02d", $hour);
    $min = sprintf("%02d", $min);
    $sec = sprintf("%02d", $sec);

    $current_date = "$year-$month-$date $hour:$min:$sec";

    return $current_date;
}


function year_of($date) {
    $year = explode("-", $date)[0];
    return $year;
}


function month_of($date) {
    $month_nb = explode("-", $date)[1];

    if ($month_nb == "0") {$month = "-";}
    if ($month_nb == "1") {$month = "janvier";}
    if ($month_nb == "2") {$month = "février";}
    if ($month_nb == "3") {$month = "mars";}
    if ($month_nb == "4") {$month = "avril";}
    if ($month_nb == "5") {$month = "mai";}
    if ($month_nb == "6") {$month = "juin";}
    if ($month_nb == "7") {$month = "juillet";}
    if ($month_nb == "8") {$month = "août";}
    if ($month_nb == "9") {$month = "sept.";}
    if ($month_nb == "10") {$month = "oct.";}
    if ($month_nb == "11") {$month = "nov.";}
    if ($month_nb == "12") {$month = "déc.";}

    return $month;
}


function duration_of($duration_int) {
    $heures = intval($duration_int / 3600);
    $minutes = intval(($duration_int % 3600) / 60);
    $secondes = intval((($duration_int % 3600) % 60));

    if ($secondes > 30) {
        $minutes = $minutes + 1;
        if ($heures == 0) {
            $duration = $minutes . " min ";
        } else {
            $duration = $heures . "h " . $minutes . "min ";
        }
    } else {
        if ($heures == 0) {
            $duration = $minutes . " min ";
        } else {
            $duration = $heures . "h " . $minutes . "min ";
        }
    }

    return $duration;
}


function display_author() {
    global $author_id_list;

    $author_number = sizeof($author_id_list);
    $author_id = $author_id_list[0];

    if ($author_number <= 2) {
        $author = get_author_info($author_id)["name"];
    }

    if ($author_number > 2) {
        $author = get_author_first_name($author_id);
    }

    for ($author_index = 1; $author_index <= $author_number - 2; $author_index++) {

        if ($author_number <= 2) {
            $author_id = $author_id_list[$author_index];
            $author = $author . ", " . get_author_info($author_id)["name"];
        }

        if ($author_number > 2) {
            $author_id = $author_id_list[$author_index];
            $author = $author . ", " . get_author_first_name($author_id);
        }
    }

    if ($author_number >= 2) {
        if ($author_number <= 2) {
            $author_id = $author_id_list[$author_number - 1];
            $author = $author . " et " . get_author_info($author_id)["name"];
        }

        if ($author_number > 2) {
            $author_id = $author_id_list[$author_number - 1];
            $author = $author . " et " . get_author_first_name($author_id);
        }
    }

    ECHO $author;
}


function image_format_of($type_id) {
    $format = "";

    switch ($type_id) {
        case "video":
            $format = "panorama";
            break;
        case "tvshow":
            $format = "panorama";
            break;
        case "documentary":
            $format = "portrait";
            break;
        case "podcast":
            $format = "squared";
            break;
        case "shortfilm":
            $format = "panorama";
            break;
        case "humour":
            $format = "panorama";
            break;
        case "music":
            $format = "squared";
            break;
    }

    return $format;
}


function title_of_type($type_id) {
    $title = "";

    switch ($type_id) {
        case "video":
            $title = "Vidéos";
            break;
        case "tvshow":
            $title = "Emissions";
            break;
        case "documentary":
            $title = "Documentaires";
            break;
        case "podcast":
            $title = "Podcasts radio";
            break;
        case "shortfilm":
            $title = "Courts-métrages";
            break;
        case "humour":
            $title = "Humour";
            break;
        case "music":
            $title = "Albums musicaux";
            break;
    }

    return $title;
}


function title_of_category($category_id) {
    $title = "";

    switch ($category_id) {
        case 0:
            $title = "";
            break;
        case 1:
            $title = "Eveil des consciences";
            break;
        case 2:
            $title = "Alternatives concrètes";
            break;
        case 3:
            $title = "Media et communication";
            break;
        case 4:
            $title = "Santé et alimentation";
            break;
        case 5:
            $title = "Écologie";
            break;
        case 6:
            $title = "Économie";
            break;
        case 7:
            $title = "Société";
            break;
        case 8:
            $title = "Connaissance";
            break;
    }

    return $title;
}


function category_of($category_id) {
    $category = "";

    switch ($category_id) {
        case 0:
            $category = "";
            break;
        case 1:
            $category = "Conscience";
            break;
        case 2:
            $category = "Alternatives";
            break;
        case 3:
            $category = "Esprit critique";
            break;
        case 4:
            $category = "Santé";
            break;
        case 5:
            $category = "Ecologie";
            break;
        case 6:
            $category = "Economie";
            break;
        case 7:
            $category = "Société";
            break;
        case 8:
            $category = "Connaissance";
            break;
    }

    return $category;
}


function category_id_of($category) {
    $category_id = "";

    switch ($category) {
        case "":
            $category_id = 0;
            break;
        case "Conscience":
            $category_id = 1;
            break;
        case "Alternatives":
            $category_id = 2;
            break;
        case "Esprit critique":
            $category_id = 3;
            break;
        case "Santé":
            $category_id = 4;
            break;
        case "Ecologie":
            $category_id = 5;
            break;
        case "Economie":
            $category_id = 6;
            break;
        case "Société":
            $category_id = 7;
            break;
        case "Connaissance":
            $category_id = 8;
            break;
    }

    return $category_id;
}


function display_thumbnail_list($list_id, $type_id, $title, $content_list) {
    $format = image_format_of($type_id);
    $list_size = sizeof($content_list);

    if ($list_size > 0) {

        // Display title
        ECHO ' <a ';
        // ECHO ' id = "title_' . $category_id . '" ';
        ECHO ' class = "title" ';
        ECHO ' > ';
        ECHO $title;
        ECHO ' </a> ';

        // Display pager
        ECHO ' <div class = "pager_container" > ';

        if ($type_id == "documentary") {
            $page_number = ceil($list_size / 5);
        } else {
            $page_number = ceil($list_size / 4);
        }

        for ($index = 1; $index <= $page_number; $index++) {
            ECHO ' <div ';
            ECHO ' id = "pager_' . $list_id . '_' . $index . '" ';
            ECHO ' class = "pager" ';
            if ($page_number == 1) { ECHO ' style = "visibility:hidden" '; }
            ECHO ' > ';
            ECHO ' </div> ' ;
        }

        ECHO ' </div> ';


        // Display video with or without horizontal scrolling
        ECHO ' <div ';
        ECHO ' id = "scrolling_container_' . $list_id . '" ';
        ECHO ' class = "scrolling_container" ';
        ECHO ' > ';

        ECHO ' <div ';
        ECHO ' id = "list_container_' . $list_id . '" ';
        ECHO ' class = "list_container" ';
        // add_scroll();  // add horizontal scrolling if need
        ECHO ' > ';
        display_thumbnail($list_id, $type_id, $content_list);
        ECHO ' </div> ';

        ECHO ' </div> ';

        // Display arrows
        ECHO ' <div ' ;
        ECHO ' class = "left_arrow_container_' . $format . '" ';
        ECHO ' > ';
        ECHO ' <img ';
        ECHO ' class = "left_arrow_container" ';
        ECHO ' id = "left_arrow_container_' . $list_id . '" ';
        ECHO ' src = "../img/icons/category/page_left_grey.png" ';
        ECHO ' > ' ;
        ECHO ' </div> ';

        ECHO ' <div ' ;
        ECHO ' class = "right_arrow_container_' . $format . '" ';
        ECHO ' > ';
        ECHO ' <img ';
        ECHO ' class = "right_arrow_container" ';
        ECHO ' id = "right_arrow_container_' . $list_id . '" ';
        ECHO ' src = "../img/icons/category/page_right_grey.png" ';
        ECHO ' > ' ;
        ECHO ' </div> ';
    }

    return $list_size;
}


function display_thumbnail($list_id, $type_id, $content_list) {
    $format = image_format_of($type_id);
    $content_number = sizeof($content_list);

    for ($index = 0; $index < $content_number; $index++) {

        if ($type_id == "video") {
            // if ($content["thumbnail"] == "local") {
            //     $content_id = $content_list[$index]["content_id"];
            //     $image_url = "../img/video/" . $content_id . "/" . $video_id . ".jpg";
            // }
            // if ($content["thumbnail"] == "youtube") {
            $video_id = $content_list[$index]["video_id"];
            $content_id = $content_list[$index]["content_id"];
            $image_url = "https://img.youtube.com/vi/" . $video_id . "/mqdefault.jpg";
            // }
        } else {
            $content_id = $content_list[$index]["content_id"];
            $image_url = '../img/' . $type_id . '/cover/' . $content_id . '.jpg';
        }

        if ($type_id == "tvshow" OR $type_id == "humour" OR $type_id == "music") {
            $line_1 = $content_list[$index]["short_description"];
            $line_2 = $content_list[$index]["sub_type"] .' - ' . $content_list[$index]["video_number"] . '  vidéos (' . $content_list[$index]["duration"] . ' min)';
        } else if ($type_id == "podcast") {
            $line_1 = $content_list[$index]["short_description"];
            $line_2 = $content_list[$index]["sub_type"] .' - ' . $content_list[$index]["video_number"] . '  podcats (' . $content_list[$index]["duration"] . ' min)';
        } else if ($type_id == "documentary" OR $type_id == "shortfilm") {
            $line_1 = $content_list[$index]["short_description"];
            $line_2 = '(' . $content_list[$index]["duration"] . ' min)';
        } else {
            $line_1 = "";
            $line_2 = "";
        }

        ECHO ' <div ';
        ECHO ' id = "' . $list_id .'-' . $index . '-' . $type_id . '-' . $content_id . '" ';

        if ($type_id == "documentary" AND $content_list[$index]["playback"] == "greenpeace") {
            ECHO ' class = "thumbnail_info portrait ppv" ';
        } else {
            ECHO ' class = "thumbnail_info ' . $format . '" ';
        }

        ECHO ' > ';

        ECHO ' <img ';
        ECHO ' src = ' . $image_url;
        ECHO ' class = "thumbnail ' . $format . '" ';
        ECHO ' > ';
        ECHO ' </img> ';

        ECHO ' <div ';
        ECHO ' id = "info_' . $content_id . '" ';
        ECHO ' class = "info_' . $format . '" ' . $format . '" ';
        ECHO ' > ';

        if ($type_id == "documentary" AND $content_list[$index]["playback"] == "available") {
            ECHO ' <div>';
            ECHO ' <a class = "info_free"> A voir sur Imago </a>';
            ECHO ' </div>';
        }

        if ($type_id == "documentary" AND $content_list[$index]["playback"] == "greenpeace") {
            ECHO ' <div>';
            ECHO ' <a class = "info_ppv"> A louer / A acheter </a>';
            ECHO ' </div>';
        }

        ECHO ' <div>';
        ECHO ' <a class = "line_1">' . $line_1 . '</a>';
        ECHO ' </div>';

        ECHO ' <div>';
        ECHO ' <a class = "line_2">' . $line_2 . '</a>';
        ECHO ' </div>';

        ECHO ' </div>';

        $info_unlock = "Accéder aux documentaires payants";

        // if ($type_id == "documentary" AND $content_list[$index]["playback"] != "available") {
        //     ECHO ' <div ';
        //     ECHO ' class = "info_unlock" ';
        //     ECHO ' > ';
        //         ECHO ' <a class = "info_unlock">' . $info_unlock . '</a>';
        //     ECHO ' </div>';
        // }

        ECHO ' </div>';
    }

    // ECHO ' <div ';
    // ECHO ' id = "' . $list_id .'-more" ';
    // ECHO ' class = "thumbnail_info ' . $format . ' more" ';
    // ECHO ' > ';

    //     ECHO ' <img ';
    //     ECHO ' src = "../img/more_' . $format . '.jpg" ';
    //     ECHO ' class = "thumbnail ' . $format . '" ';
    //     ECHO ' > ';

    // ECHO ' </div>';
}