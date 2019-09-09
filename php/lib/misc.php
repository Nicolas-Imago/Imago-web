
<?php


    ////////////////////////////////// Time functions //////////////////////////////////


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

    
    function day_of($date) {

        $day = explode("-", $date)[2];
        $day = explode(" ", $day)[0];
        return $day;
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


    function year_of($date) {

        $year = explode("-", $date)[0];
        return $year;
    }


    function duration_of($duration_int) {

        $heures = intval($duration_int / 3600);
        $minutes = intval(($duration_int % 3600) / 60);
        $secondes = intval((($duration_int % 3600) % 60));

        if ($secondes > 30) {
            $minutes = $minutes + 1; 
            if ($heures == 0) $duration = $minutes . " min ";
            else $duration = $heures . "h " . $minutes . "min ";
        }
        else {
            if ($heures == 0) $duration = $minutes . " min ";
            else $duration = $heures . "h " . $minutes . "min ";
        }       

        return $duration;
    }


    ////////////////////////////////// Author function //////////////////////////////////

    function display_author_name($author_id_list) {

        $author_number = sizeof($author_id_list);
        $author_name = "";
        
        if ($author_number != 0) {

            $author_id = $author_id_list[0];

            if ($author_number <= 2) 
                $author_name = get_author_info($author_id)["name"];
            
            if ($author_number > 2) 
                $author_name = get_author_first_name($author_id);   

            for ($author_index = 1; $author_index <= $author_number - 2; $author_index++) {

                if ($author_number <= 2) {
                    $author_id = $author_id_list[$author_index];
                    $author_name = $author_name . ", " . get_author_info($author_id)["name"];
                }
                if ($author_number > 2) {
                    $author_id = $author_id_list[$author_index];
                    $author_name = $author_name . ", " . get_author_first_name($author_id);
                }
            }
            if ($author_number >= 2) {
                if ($author_number <= 2) {  
                    $author_id = $author_id_list[$author_number - 1];
                    $author_name = $author_name . " et " . get_author_info($author_id)["name"];
                }
                if ($author_number > 2) {   
                    $author_id = $author_id_list[$author_number - 1];
                    $author_name = $author_name . " et " . get_author_first_name($author_id);
                }       
            }
        }

        return $author_name;
    }


    ////////////////////////////////// Misc functions //////////////////////////////////


   	function image_format_of($thumbnail_type, $type_id) {

        if ($type_id == "user")             $format = "rounded";

        if ($thumbnail_type == "video")     $format = "panorama";
        if ($thumbnail_type == "audio")     $format = "squared";

        if ($thumbnail_type == "content" || $thumbnail_type == "donation") {
            if ($type_id == "tvshow")       $format = "panorama";
            if ($type_id == "documentary")  $format = "portrait";
            if ($type_id == "podcast")      $format = "squared";
            if ($type_id == "shortfilm")    $format = "panorama";
            if ($type_id == "humour")       $format = "panorama";
            if ($type_id == "music")        $format = "squared";
            if ($type_id == "kids")         $format = "panorama";
            if ($type_id == "conference")   $format = "panorama";

            if ($type_id == "book")         $format = "portrait";
        }

        if ($thumbnail_type == "comment")   $format = "post_it";


        return $format;
    }


    function page_number_of($type_id, $content_list) {

        $list_size = sizeof($content_list);

        if ($type_id == "user")             $page_number = ceil($list_size / 9);

        if ($type_id == "video")            $page_number = ceil($list_size / 4);
        if ($type_id == "audio")            $page_number = ceil($list_size / 6);

        if ($type_id == "tvshow")           $page_number = ceil($list_size / 4);
        if ($type_id == "documentary")      $page_number = ceil($list_size / 5);
        if ($type_id == "podcast")          $page_number = ceil($list_size / 6);
        if ($type_id == "shortfilm")        $page_number = ceil($list_size / 4);
        if ($type_id == "humour")           $page_number = ceil($list_size / 4);
        if ($type_id == "music")            $page_number = ceil($list_size / 5);
        if ($type_id == "kids")             $page_number = ceil($list_size / 4);
        if ($type_id == "conference")       $page_number = ceil($list_size / 4);

        if ($type_id == "comment")          $page_number = ceil($list_size / 6);
        if ($type_id == "book")             $page_number = ceil($list_size / 5);

        return $page_number;

    }

    function type_of($index) {

        if ($index == "1")      $type = "tvshow";
        if ($index == "2")      $type = "documentary";
        if ($index == "3")      $type = "podcast";
        if ($index == "4")      $type = "shortfilm";
        if ($index == "5")      $type = "kids";
        if ($index == "6")      $type = "humour";
        if ($index == "7")      $type = "music";
        if ($index == "8")      $type = "conference";

        return $type;
    }

    ////////////////////////////////// Name functions //////////////////////////////////


    function title_of_type($thumbnail_type, $type_id, $item_number) {

        if ($thumbnail_type == "search")        $title = "Résultats de recherche";
        if ($thumbnail_type == "pending_in")    $title = "Demandes reçues";
        if ($thumbnail_type == "pending_out")   $title = "Demandes envoyées";
        if ($thumbnail_type == "friend")        $title = "Mes amis";

        if ($thumbnail_type == "video")         $title = "Vidéos";
        if ($thumbnail_type == "audio")         $title = "Podcasts";

        if ($thumbnail_type == "content") {
            if ($type_id == "tvshow")           $title = "Emissions";
            if ($type_id == "documentary")      $title = "Documentaires";
            if ($type_id == "podcast")          $title = "Podcasts";
            if ($type_id == "shortfilm")        $title = "Courts-métrages";
            if ($type_id == "humour")           $title = "Humour";
            if ($type_id == "music")            $title = "Albums musicaux";
            if ($type_id == "kids")             $title = "Jeunesse";
            if ($type_id == "conference")       $title = "Conférences";
        }

        $title = $title  . " (" . $item_number . ")";

        return $title;
    }


    function title_of_category($category_id, $item_number) {

        if ($category_id == 0)      $title = "";

        if ($category_id == 1)      $title = "Éveil des consciences";
        if ($category_id == 2)      $title = "Alternatives concrètes";
        if ($category_id == 3)      $title = "Médias et communication";
        if ($category_id == 4)      $title = "Santé et alimentation";       
        if ($category_id == 5)      $title = "Écologie et environnement";
        if ($category_id == 6)      $title = "Économie et finance";
        if ($category_id == 7)      $title = "Société et actualité";
        if ($category_id == 8)      $title = "Histoire et politique";

        if ($item_number != "") 
            $title = $title  . " (" . $item_number . ")";
     
        return $title;
    }


    function content_list_title_of($screen, $type_id, $category_id, $item_number) {

        if ($screen == "category")          $title = title_of_type("content", $type_id, $item_number);
        if ($screen == "type")              $title = title_of_category($category_id, $item_number);
        if ($screen == "category_type")     $title = "";

        if ($screen == "series" OR $screen == "movie") { 

            if ($type_id == "tvshow")               $title = "Emission(s) du même auteur (" . $item_number . ")";
            else if ($type_id == "documentary")     $title = "Docu(s) du même auteur (" . $item_number . ")";
            else if ($type_id == "shortfilm")       $title = "Court(s) du même auteur (" . $item_number . ")";
            else if ($type_id == "podcast")         $title = "Podcast(s) du même auteur (" . $item_number . ")";

            else if ($type_id == "book")            $title = "Livre(s) du même auteur (" . $item_number . ")";

            else                                    $title = "Avis et recommandations (" . $item_number . ")";
        }

        return $title;
    }


    function screen_title($screen, $type_id, $category_id) {

        if ($screen == "search")            $screen_title = "Ma recherche";

        else if ($screen == "favorite")     $screen_title = "Mes favoris";

        else if ($screen == "watch_later")     $screen_title = "A regarder plus tard"; 

        else if ($screen == "friend")     $screen_title = "Mes amis"; 

        else if ($screen == "type") {

            if ($type_id == "tvshow")       $screen_title = "Toutes les émissions";
            if ($type_id == "documentary")  $screen_title = "Tous les documentaires";
            if ($type_id == "podcast")      $screen_title = "Tous les podcasts";
            if ($type_id == "shortfilm")    $screen_title = "Tous les courts-métrages";
            if ($type_id == "humour")       $screen_title = "Tous les contenus humour";
            if ($type_id == "music")        $screen_title = "Tous les albums musicaux";
            if ($type_id == "kids")         $screen_title = "Tous les contenus jeunesse";
            if ($type_id == "conference")   $screen_title = "Toutes les conférences";

            if ($type_id == "book")         $screen_title = "Tous les livres";
        }

        else if ($screen == "category") {
            if ($category_id != "")         $screen_title = title_of_category($category_id, "");
        }

        else if ($screen == "category_type") {

            $category = category_of($category_id);

            if ($type_id == "tvshow")       $screen_title = "Toutes les émissions " . $category;
            if ($type_id == "documentary")  $screen_title = "Tous les documentaires " . $category;
            if ($type_id == "podcast")      $screen_title = "Tous les podcasts " . $category;
            if ($type_id == "shortfilm")    $screen_title = "Tous les courts-métrages " . $category;
            if ($type_id == "humour")       $screen_title = "Tous les contenus humour " . $category;
            if ($type_id == "music")        $screen_title = "Tous les albums musicaux " . $category;
            if ($type_id == "kids")         $screen_title = "Tous les contenus jeunesse " . $category;
            if ($type_id == "conference")   $screen_title = "Toutes les conférences " . $category;

            if ($type_id == "book")         $screen_title = "Tous les livres " . $category;
        }

        return $screen_title;
    }


    function title_of_sub_type($sub_type) {

        if ($sub_type == "teaser")      $sub_type_title = "Bande annonce";
        if ($sub_type == "movie")       $sub_type_title = "Film";
        if ($sub_type == "excerpt")     $sub_type_title = "Extrait(s)";
        if ($sub_type == "bonus")       $sub_type_title = "Bonus";

        return $sub_type_title;
    }


    function category_of($category_id) {

        if ($category_id == 0)      $category = "";

        if ($category_id == 1)      $category = "Conscience";
        if ($category_id == 2)      $category = "Alternatives";
        if ($category_id == 3)      $category = "Médias";
        if ($category_id == 4)      $category = "Santé";        
        if ($category_id == 5)      $category = "Ecologie";
        if ($category_id == 6)      $category = "Economie";
        if ($category_id == 7)      $category = "Société";
        if ($category_id == 8)      $category = "Histoire";

        return $category;
    }


    function category_id_of($category) {

        if ($category == "")                $category_id = 0;

        if ($category == "Conscience")      $category_id = 1;
        if ($category == "Alternatives")    $category_id = 2;
        if ($category == "Médias")          $category_id = 3;
        if ($category == "Santé")           $category_id = 4;        
        if ($category == "Ecologie")        $category_id = 5;
        if ($category == "Economie")        $category_id = 6;
        if ($category == "Société")         $category_id = 7;
        if ($category == "Histoire")        $category_id = 8;

        return $category_id;
    }


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
                ECHO 'https://www.imagotv.fr/img/video/' . $type_id . '/' . $content_id . '/hd/' . $episod_id . '.jpg';
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
