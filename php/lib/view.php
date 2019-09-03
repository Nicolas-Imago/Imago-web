<?php

    /////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////// Thumbnail container display //////////////////////////////////
            
    /////////////////////////////////////////////////////////////////////////////////////////////////


    function display_thumbnail_container($list_id, $thumbnail_type, $type_id, $category_id, $title, $content_list) {

        $format = image_format_of($thumbnail_type, $type_id);
        $list_size = sizeof($content_list);
        $page_number = page_number_of($type_id, $content_list);

        if ($list_size > 0) {

            // Display title 

            if ($type_id == "")       $title_href = "/php/category.php?category_id=" . $category_id;
            if ($category_id == "")   $title_href = "/php/category.php?type_id=" . $type_id;
            else   $title_href = "/php/category.php?type_id=" . $type_id . "&category_id=" . $category_id;

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


    /////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////// Thumbnail list display ////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////


    ////////////  list  ////////////

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


    //////////// Series ////////////

    function display_season($season_number) {

        global $content;
        global $season_number;

        for ($season_index = 1; $season_index <= $season_number ; $season_index++) {
            ECHO ' <a ';
                ECHO ' id = "season_' . $season_index . '" ';
                ECHO ' class = "season" >';
                    ECHO ' Saison ' . $season_index;
            ECHO ' </a>';
        }
    }


    //////////// Movie ////////////

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

                        display_thumbnail(0, $index, $thumbnail_type, $type_id, "", $thumbnail);
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
                            display_thumbnail(0, $index, "video", $type_id, $section_id, $thumbnail);
                        }

                ECHO '</div>';
            ECHO '</div>';
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////// Thumbnail display ///////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////


    function display_thumbnail($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        if (in_array($thumbnail_type, array("content")))
            display_thumbnail_content($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail);

        if (in_array($thumbnail_type, array("video", "audio")))
            display_thumbnail_episod($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail);

        if (in_array($thumbnail_type, array("comment")))
            display_thumbnail_comment($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail);

        if (in_array($thumbnail_type, array("donation")))
            display_thumbnail_donation($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail);

        if (in_array($thumbnail_type, array("search", "pending_in", "pending_out", "friend")))
            display_thumbnail_user($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail);
    }


    //////////// Content ////////////

    function display_thumbnail_content($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);

        $content_id = $thumbnail["content_id"];
        $episod_id = "";

        $sub_type = $thumbnail["format"];
        $video_number = $thumbnail["video_number"];
        $duration = $thumbnail["duration"];

        // Prepare image URL

        $image_url = '../img/content/' . $type_id . '/cover/' . $content_id . '.jpg'; 
        if(!file_exists($image_url)) $image_url = '../img/content/' . $type_id . '/default.jpg';

        // Prepare thumbnail text

        $line_1 = $thumbnail["short_description"];

        if ($type_id == "tvshow" OR $type_id == "humour")
            $line_2 = $sub_type .' - ' . $video_number . '  vidéos (' . $duration . ' min)';

        else if ($type_id == "music") 
            $line_2 = $sub_type .' - ' . $video_number . '  clips (' . $duration . ' min)';

        else if ($type_id == "podcast")
            $line_2 = $sub_type .' - ' . $video_number . '  podcats (' . $duration . ' min)';

        else if ($type_id == "documentary" OR $type_id == "shortfilm")
            $line_2 = '(' . $duration . ' min)';
        else
            $line_2 = "";


        // Prepare HTML params

        $th_div_id = $list_id .'-'. $index .'-'. $thumbnail_type .'-'. $content_id .'-'. $section_id .'-'. $episod_id;
        // $th_div_class = "thumbnail_info " . $format; 

        if ($type_id == "documentary" OR $type_id == "shortfilm") {
            $href = 'movie.php?type_id=' . $type_id . '&content_id=' . $content_id;
            $target = "";
        }
        else if ($type_id == "book") {
            $href = $thumbnail["link"];
            $target = "_blank";
        }
        else {
            $href = 'series.php?type_id=' . $type_id . '&content_id=' . $content_id;
            $target = "";
        }

        $image_class = "thumbnail " . $format;
        // $th_img_src = $image_url;

        $text_div_id = "info_" . $list_id . '_' . $content_id . '_' . $episod_id;
        $text_div_class = "info_" . $format;

        // HTML code

    ?>

    <div id = "<?php ECHO $th_div_id ?>" class = "thumbnail" > 

        <a href = "<?php ECHO $href ?>" target = "<?php ECHO $target ?>" >
            <img class = "<?php ECHO $image_class ?>" src = "<?php ECHO $image_url ?>" > </img> </a>

        <div id = "<?php ECHO $text_div_id ?>" class = "<?php ECHO $text_div_class ?>" >
            <div> <a class = "line_1"> <?php ECHO $line_1 ?> </a> </div>
            <div> <a class = "line_2"> <?php ECHO $line_2 ?> </a> </div>
        </div>

    </div>

    <?php

    }


    //////////// Episod ////////////

    function display_thumbnail_episod($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);

        $content_id = $thumbnail["content_id"];
        $episod_id = $thumbnail["episod_id"];
        $hosting = $thumbnail["hosting"];

        // Prepare image URL
                
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


        // Prepare thumbnail text

        $line_1 = "";
        $line_2 = "";

        $date = $thumbnail["publication_date"];
        $date = day_of($date) . " " . month_of($date) . " " . year_of($date);

        $duration = duration_of($thumbnail["duration"]);
        $timing = $duration . '   -   ' . $date;

        $line_1 = '#' .$thumbnail["title"];
        $line_2 = $timing;
        $line_3 = $thumbnail["description"];
        $line_4 = 'Lu ' . '356' . ' fois sur Imago';


        // Prepare HTML params

        $th_div_id = $list_id.'-'.$index.'-'.$thumbnail_type.'-'.$content_id.'-'.$section_id.'-'.$episod_id;
        $th_div_class = "series_thumbnail series_" . $format; 

        if ($type_id == "documentary" OR $type_id == "shortfilm")
            $href = "movie.php?type_id=" . $type_id . "&content_id=" . $content_id . "&section_id=" . $section_id . "&episod_id=" . $episod_id;
        else 
            $href = "series.php?type_id=" . $type_id . "&content_id=" . $content_id . "&episod_id=" . $episod_id;

        $image_class = "series_thumbnail series_" . $format;

        // $play_id = "play_" . $section_id . '_' . $index;
        $play_class = "series_play_" . $format;

        $text_div_id = "series_info_" . $list_id . '_' . $content_id. '_' . $episod_id;
        $text_div_class = "series_info_" . $format;

        // HTML code

    ?>

    <div id = "<?php ECHO $th_div_id ?>" class = "<?php ECHO $th_div_class ?>" > 

        <a href = "<?php ECHO $href ?>" >
            <img class = "<?php ECHO $image_class ?>" src = " <?php ECHO $image_url ?>" > </a>
            
        <img class = "<?php ECHO $play_class ?>" src = "../img/icons/play_new.png" > </img>

        <div id = "<?php ECHO $text_div_id ?>" class = "<?php ECHO $text_div_class ?>" >
            <div> <a class = "series_line_1"> <?php ECHO $line_1 ?> </a> </div>
            <div> <a class = "series_line_2"> <?php ECHO $line_2 ?> </a> </div>
            <div> <a class = "series_line_3"> <?php ECHO $line_3 ?> </a> </div>
            <div> <a class = "series_line_4"> <?php ECHO $line_4 ?> </a> </div>
        </div>

    </div>

    <?php

    }


    //////////// Comment ////////////

    function display_thumbnail_comment($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);
        $comment_id = $thumbnail["id"];

        // Prepare thumbnail text

        $line_1 = substr($thumbnail["comment"], 0, 120) . '...';
        $line_2 = $thumbnail["login"];
        
        $date = $thumbnail["add_date"];
        $line_3 = day_of($date) . ' ' . month_of($date) . ' ' . year_of($date);


        // Prepare HTML params

        $th_div_id = $list_id .'-'. $index .'-'. $thumbnail_type .'-'. $comment_id;
        $th_div_class = 'thumbnail_info ' . $format; 

        $image_class = 'thumbnail ' . $format;
        $image_src = '../img/icons/comment_' . $thumbnail["color"] . '.png';

        $text_div_id = "info_" . $list_id;
        $text_div_class = "info_" . $format;

        // HTML code

    ?>

    <div id = "<?php ECHO $th_div_id ?>" class = "thumbnail" > 

        <img class = "<?php ECHO $image_class ?>" src = "<?php ECHO $image_src ?>" > </img>

        <div id = "<?php ECHO $text_div_id ?>" class = "<?php ECHO $text_div_class ?>" >
            <div> <a class = "post_it_line_1"> <?php ECHO $line_1 ?> </a> </div>
            <div> <a class = "post_it_line_2"> <?php ECHO $line_2 ?> </a> </div>
            <div> <a class = "post_it_line_3"> <?php ECHO $line_3 ?> </a> </div>
        </div>

    </div>

    <?php

    }


    //////////// Donation ////////////

    function display_thumbnail_donation($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);
        $donation_id = $thumbnail["id"];
        $content_id = $thumbnail["content_id"];

        // Prepare image URL

        $image_url = '../img/content/' . $type_id . '/cover/' . $content_id . '.jpg'; 
        if(!file_exists($image_url)) $image_url = '../img/content/' . $type_id . '/default.jpg';

        // Prepare thumbnail text

        // $line_1 = substr($thumbnail["name"], 0, 30) . '...';
        $line_1 = substr($thumbnail["name"], 0, 18);

        $date = $thumbnail["donation_date"];
        $line_2 = day_of($date) . ' ' . month_of($date) . ' ' . year_of($date);

        $line_3 = $thumbnail["value"] . ' euro(s)';

        if ($type_id == "documentary" OR $type_id == "podcast")
            $offset = "offset";
        else
            $offset = "";


        // Prepare HTML params

        if ($type_id == "documentary" OR $type_id == "shortfilm") {
            $th_img_href = 'movie.php?type_id=' . $type_id . '&content_id=' . $content_id;
            $th_img_target = "";
        }
        else if ($type_id == "tvshow" OR $type_id == "podcast") {
            $th_img_href = 'series.php?type_id=' . $type_id . '&content_id=' . $content_id;
            $th_img_target = "";
        }

        $th_div_id = $list_id . '-' . $index . '-' . $thumbnail_type . '-' . $content_id;
        $th_div_class = 'thumbnail_info ' . $format; 

        $th_img_class = 'thumbnail ' . $format;

        $th_img_src = $image_url;

        $ck_img_id = $list_id . '-' . $index . '-' . $donation_id;

        // $text_div_id = 'info_' . $list_id;
        // $text_div_class = 'info_' . $format . " " . $format;

        // HTML code

    ?>

    <div id = "<?php ECHO $th_div_id ?>" class = "<?php ECHO $th_div_class ?>" > 

        <a target = "<?php ECHO $th_img_target ?>" href = "<?php ECHO $th_img_href ?>" class = "href" >
            <img class = "<?php ECHO $th_img_class ?>" src = "<?php ECHO $th_img_src ?>" > </img>
        </a>

        <div>
            <div> <a class = "donation_line_1" > <?php ECHO $line_1 ?> </a> </div>
            <div> <a class = "donation_line_2" > <?php ECHO $line_2 ?> </a> </div>
            <div> <a class = "donation_line_3" > <?php ECHO $line_3 ?> </a> </div>
            <img id = "<?php ECHO $ck_img_id ?>" class = "check" src = '../img/icons/check_off.png'; > </img>
        </div>

    </div>

    <?php

    }


    ////////////  User  ////////////

    function display_thumbnail_user($list_id, $index, $thumbnail_type, $type_id, $section_id, $thumbnail) {

        $format = image_format_of($thumbnail_type, $type_id);

        $content_id = "user";

        if ($thumbnail_type == "search")        $section_id = $thumbnail["id"];
        if ($thumbnail_type == "pending_in")    $section_id = $thumbnail["user_id_1"];
        if ($thumbnail_type == "pending_out")   $section_id = $thumbnail["user_id_2"];
        if ($thumbnail_type == "friend")        $section_id = $thumbnail["user_id_1"];


        $episod_id = $index;

        // Prepare image URL

        $image_url = "../img/creator/author/default_user.png";

        // Prepare thumbnail text

        if (strlen($thumbnail["login"]) > 20)
            $line_1 = substr($thumbnail["login"], 0, 20) . '...';
        else
            $line_1 = $thumbnail["login"];

        // Prepare HTML params

        $th_div_id = $list_id.'-'.$index.'-'.$thumbnail_type.'-'.$content_id.'-'.$section_id.'-'.$episod_id;
        $th_div_class = "thumbnail_info " . $format; 

        $th_img_class = "thumbnail " . $format;
        $th_img_src = $image_url;

        $text_div_id = "info_" . $list_id . '_' . $content_id. '_' . $episod_id;
        $text_div_class = "info_" . $format . " " . $format;

        // HTML code

    ?>

    <div id = "<?php ECHO $th_div_id ?>" class = "<?php ECHO $th_div_class ?>" > 

        <img class = "<?php ECHO $th_img_class ?>" src = "<?php ECHO $th_img_src ?>" > </img>
            
        <div id = "<?php ECHO $text_div_id ?>" class = "<?php ECHO $text_div_class ?>" >
            <div> <a class = "line_1"> <?php ECHO $line_1 ?> </a> </div> 
        </div>

    </div>

    <?php
    
    }

?>