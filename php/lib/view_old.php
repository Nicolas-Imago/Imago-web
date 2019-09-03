<?php


    ////////////////////////////////// Display functions //////////////////////////////////


    function display_og_image($type_id, $content_id, $thumbnail, $episod_id, $video_id) {

        global $content;

        if ($episod_id == "") {
            if ($type_id == "documentary" OR $type_id == "shortfilm")
                ECHO 'https://www.imagotv.fr/img/' . $type_id . '/cover_big/' . $content_id . '.jpg';
            else 
                ECHO 'https://www.imagotv.fr/img/' . $type_id . '/background/' . $content_id . '.jpg';
        }
        else {
            if ($thumbnail == "local")
                ECHO 'https://www.imagotv.fr/img/video/' . $content_id . '/hd/' . $episod_id . '.jpg';
            else
                ECHO 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
        }
    }


    function display_admin($type_id, $content_id) {

        // global $content;

        // ECHO ' href = "/admin/content_form.php?type_id=' . $type_id . '&content_id=' . $content_id . '"';
        // ECHO ' onclick = "window.open(this.href); return false"';           
    }


    function display_author_image($author_id_list) {

        // $author_number = sizeof($author_id_list);

        // for ($index = 0; $index <= $author_number - 1; $index++) {
        //     $author_id = $author_id_list[$index];

        //     ECHO ' <img ';
        //         ECHO ' id = "author_image_' . $index . '" ';
        //         ECHO ' class = "author_image" ';
        //         ECHO ' src = "../img/author/thumbnail/' . $author_id . '.png" ';
        //     ECHO ' > ';
        // }
    }


    function display_note($index, $note) {

        global $content;

        if ($index <= $content["note_" . $note])
            ECHO ' src = "../img/icons/notation/star_light_grey.png" ';
        else
            ECHO ' src = "../img/icons/notation/star_grey.png" ';
    }



    ////////////////////////////////// Thumbnail container display //////////////////////////////////
 

    function display_thumbnail_container($list_id, $thumbnail_type, $type_id, $category_id, $title, $content_list) {

        $format = image_format_of($thumbnail_type, $type_id);
        $list_size = sizeof($content_list);
        $page_number = page_number_of($type_id, $content_list);

        if ($type_id == "") 
            $title_href = "/php/category.php?category_id=" . $category_id;
        if ($category_id == "")
            $title_href = "/php/category.php?type_id=" . $type_id;
        else 
            $title_href = "/php/category.php?type_id=" . $type_id . "&category_id=" . $category_id;


        if ($list_size > 0) {

            // Display title 

            ECHO ' <a href = "' . $title_href . '" id = "' . $list_id . '" class = "title" > ' . $title . '</a> ';


            // Display pager

            ECHO ' <div class = "pager_container" > ';

                for ($index = 1; $index <= $page_number; $index++) {
                    ECHO ' <div ';
                        ECHO ' id = "pager_' . $list_id . '_' . $index . '" ';
                        ECHO ' class = "pager" ';
                        if ($page_number == 1) ECHO ' style = "visibility:hidden" ';
                        ECHO ' > ';
                    ECHO ' </div> ' ;
                }

            ECHO ' </div> ';


            // Display thumbnail list

            $thumbnail_number = sizeof($content_list);

            ECHO ' <div id = "scrolling_container_' . $list_id . '" class = "scrolling_container" > ';
                ECHO ' <div id = "list_container_' . $list_id . '" class = "list_container" > ';
                    
                    for ($index = $thumbnail_number; $index >= 1; $index--) {

                        $thumbnail = $content_list[$thumbnail_number - $index];
                        display_thumbnail($list_id, $index, $thumbnail_type, $type_id, "", $thumbnail);
                    } 

                ECHO ' </div> ';
            ECHO ' </div> ';


            // Display arrows

            $left_div_class = "arrow_container left_arrow_container_" . $format;

            $left_img_id = "left_arrow_container_" . $list_id;
            $left_img_class = "left_arrow_container";
            $left_img_src = "../img/icons/category/page_left_grey.png";

            $right_div_class = "arrow_container right_arrow_container_" . $format;

            $right_img_id = "right_arrow_container_" . $list_id;
            $right_img_class = "right_arrow_container";
            $right_img_src = "../img/icons/category/page_right_grey.png";

            include("block/arrow.php");

        }
        return $list_size;
    }



    ////////////////////////////////// Thumbnail list display //////////////////////////////////


    ///////////// Category & list /////////////


    function display_thumbnail_list($list_id, $thumbnail_type, $type_id, $content_list) {

        $thumbnail_number = sizeof($content_list);

        for ($index = 0; $index < $thumbnail_number; $index++) {

            $thumbnail = $content_list[$index];
            display_thumbnail($list_id, $index, $thumbnail_type, $type_id, $thumbnail);
        } 

        // $format = image_format_of($thumbnail_type, $type_id);

        // ECHO ' <div id = "' . $list_id .'-more" class = "thumbnail_info ' . $format . ' more" > ';
        //     ECHO ' <img class = "thumbnail ' . $format . '" src = "../img/more_' . $format . '.jpg" > </img>';
        // ECHO ' </div>';
    }


    ///////////// Series /////////////


    function display_season($season_number) {

        global $content;
        global $season_number;

        for ($season_index = 1; $season_index <= $season_number ; $season_index++) {
            ECHO ' <a ';
                ECHO ' id = "season_' . $season_index . '" ';
                ECHO ' class = "season" >';
                    ECHO ' SAISON ' . $season_index;
            ECHO ' </a>';
        }
    }


    ///////////// Movie /////////////


    function display_series_video($content_id, $content, $video_id_list, $type_id) {

        global $season_size;

        if ($type_id == "podcast") $thumbnail_type = "audio";
        if ($type_id != "podcast") $thumbnail_type = "video";

        $format = image_format_of($thumbnail_type, $type_id);

        $video_number = sizeof($video_id_list);
        $season_number = intval(($video_number - 1) / $season_size) + 1;
        $video_number_last_season = $video_number - $season_size * ($season_number - 1);


        for ($season_index = $season_number; $season_index >= 1; $season_index--) {

            ECHO ' <div class = "scrolling_container" > ';
                ECHO ' <div id = "video_thumbnail_season_' . $season_index . '" class = "video_thumbnail_season" > ';

                for ($video_index = $season_size; $video_index >= 1; $video_index--) {

                    if (($season_index != $season_number) OR ($video_index <= $video_number_last_season)) {

                        $index = $season_size * ($season_index - 1) + $video_index;
                        $thumbnail = $video_id_list[$index - 1];

                        display_thumbnail(1, $index, $thumbnail_type, $type_id, "", $thumbnail);
                    }
                }

                ECHO '</div>';
            ECHO '</div>';
        }
    }


    function display_movie_video($content_id, $content, $video_id_list, $type_id, $section_id) {

        $video_number = sizeof($video_id_list[$section_id]);
        $title = title_of_sub_type($section_id);

        // Title

        if ($video_number != 0)
            ECHO ' <a class = "thumbnail_title" > ' . $title . '</a>';

        // Video list

            ECHO ' <div class = "scrolling_container" > ';
                ECHO ' <div id = ' . $section_id . '_thumbnail" class = "video_thumbnail_type" > ';

                    if ($video_number > 0)
                        for ($index = 1; $index <= $video_number; $index++) {

                            $thumbnail = $video_id_list[$section_id][$index - 1];
                            display_thumbnail(1, $index, "video", $type_id, $section_id, $thumbnail);
                        }

                ECHO '</div>';
            ECHO '</div>';
    }


    ////////////////////////////////// Thumbnail display //////////////////////////////////


    function display_thumbnail($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);

        // Prepare image URL

        if (in_array($thumbnail_type, array("search", "pending", "friend")))
            $image_url = "../img/default_user.png";

        if ($thumbnail_type == "video" OR $thumbnail_type == "audio") {

            $content_id = $thumbnail["content_id"];

            $episod_id = $thumbnail["episod_id"];
            $hosting = $thumbnail["hosting"];
                
            if ($hosting == "invidio") {$video_id = $thumbnail["youtube_id"];}
            else {$video_id = $thumbnail[$hosting . '_id'];}

            if ($thumbnail["thumbnail"] == "local") {

                if ($section_id == "")
                    $image_url = "../img/video/" . $content_id . "/" . $episod_id . ".jpg";
    
                if ($section_id != "")
                    $image_url = "../img/video/" . $content_id . "/" . $section_id . "_" . $episod_id . ".jpg";

                if(!file_exists($image_url)) $image_url = "../img/video/" . $content_id . "/default.jpg";
            }

            if ($thumbnail["thumbnail"] == "youtube")
                $image_url = "https://img.youtube.com/vi/" . $video_id . "/mqdefault.jpg";

            $teasing = $thumbnail["teaser"];
        }

        if ($thumbnail_type == "content") {

            $content_id = $thumbnail["content_id"];

            $episod_id = "null";
            $image_url = '../img/' . $type_id . '/cover/' . $content_id . '.jpg';

            if(!file_exists($image_url)) $image_url = '../img/' . $type_id . '/default.jpg';
        }

        // Prepare thumbnail text

        if (in_array($thumbnail_type, array("search", "pending", "friend"))) {
            $info_free = "";
            $line_1 = $thumbnail["login"];
            $line_2 = "";
        }

        if ($thumbnail_type == "video" OR $thumbnail_type == "audio") {

            $title = "#" . $thumbnail["title"];

            $publication_date = $thumbnail["publication_date"];
            $date = day_of($publication_date) . " " . month_of($publication_date) . " " . year_of($publication_date);

            $duration = $thumbnail["duration"];                    
            $duration = duration_of($duration);

            $info_free = "";
            // $line_1 = $title;
            // $line_2 = $duration . '   -   ' . $date;

            if ($title != "##") {$line_1 = $title;} else {$line_1 = "";}
            if ($duration != "0 min ") {$line_2 = $duration . '   -   ' . $date;} else {$line_2 = "";}

            // $line_2 = $duration . '   -   ' . $date;
        }

        if ($thumbnail_type == "content") {

            $short_description = $thumbnail["short_description"];
            $sub_type = $thumbnail["format"];
            $video_number = $thumbnail["video_number"];
            $duration = $thumbnail["duration"];

            // if ($content_list[$index]["playback"] != "available") {
            //     $info_free = "A voir sur Imago";
            // }
            // else {
            //     $info_free = "A louer / A acheter";
            // }

            $info_free = "";

            if ($type_id == "tvshow" OR $type_id == "humour") {
                $line_1 = $short_description;
                $line_2 = $sub_type .' - ' . $video_number . '  vidéos (' . $duration . ' min)';
            }
            else if ($type_id == "music") {
                $line_1 = $short_description;
                $line_2 = $sub_type .' - ' . $video_number . '  clips (' . $duration . ' min)';
            }
            else if ($type_id == "podcast") {
                $line_1 = $short_description;
                $line_2 = $sub_type .' - ' . $video_number . '  podcats (' . $duration . ' min)';
            }
            else if ($type_id == "documentary" OR $type_id == "shortfilm") {
                $line_1 = $short_description;
                $line_2 = '(' . $duration . ' min)';
            }
            else {
                $line_1 = "";
                $line_2 = "";                
            }
        }

        // Prepare HTML params

        if (in_array($thumbnail_type, array("search", "pending", "friend"))) {
            $content_id = "user";
            $section_id = $list_id;
            $episod_id = $index;

            $th_img_href = "";
        }

        $th_div_id = $list_id . '-' . $index . '-' . $content_id . '-' . $section_id . '-' . $episod_id;
        $th_div_class = "thumbnail_info " . $format; 


        if ($thumbnail_type == "video" OR $thumbnail_type == "audio") {

            if ($type_id == "documentary" OR $type_id == "shortfilm")
                $th_img_href = "movie.php?type_id=" . $type_id . "&content_id=" . $content_id . "&section_id=" . $section_id . "&episod_id=" . $episod_id;
            else 
                $th_img_href = "series.php?type_id=" . $type_id . "&content_id=" . $content_id . "&episod_id=" . $episod_id;
        }

        else if ($thumbnail_type == "content") {

            if ($type_id == "documentary" OR $type_id == "shortfilm")
                $th_img_href = 'movie.php?type_id=' . $type_id . '&content_id=' . $content_id;
            else 
                $th_img_href = 'series.php?type_id=' . $type_id . '&content_id=' . $content_id;
        }


        $th_img_id = "";
        $th_img_class = "thumbnail " . $format;
        $th_img_src = $image_url;

        if (in_array($thumbnail_type, array("search", "pending", "friend"))) {
            $play_img_id = "";
            $play_img_class = "";
            $play_img_src = "";
        }

        if ($thumbnail_type == "video" OR $thumbnail_type == "audio") {
            if ($teasing != "1") {
                $play_img_id = "play_logo_" . $section_id . '_' . $index;
                $play_img_class = "play_logo play_logo_" . $format;
                $play_img_src = "../img/icons/play.png";
            }
            else {
                $play_img_id = "";
                $play_img_class = "";
                $play_img_src = "";
            }
        }

        if ($thumbnail_type == "content") {
            $play_img_id = "";
            $play_img_class = "";
            $play_img_src = "";
        }

        $text_div_id = "info_" . $list_id . '_' . $content_id. '_' . $episod_id;
        $text_div_class = "info_" . $format . " " . $format;

        // HTML code

        include("block/thumbnail.php");

    }

?>