
<?php         
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL); 
?>

<?php

    // ECHO $_SERVER["REQUEST_URI"];

    $request_url = $_SERVER["REQUEST_URI"];

    $request_url = explode("?", $request_url);

    if (isset($request_url[1])) {
        $params = explode("&", $request_url[1]);
        $params_number = sizeof($params);

        for ($index = 0; $index < $params_number; $index++) {
            $param = explode("=", $params[$index])[0];
            $value = explode("=", $params[$index])[1];
            $_GET[$param] = $value;
        }
    }

    $request_url = $request_url[0];

    $request_url = explode("/", $request_url);


    $type_list = ["emissions", "documentaires", "podcasts", "courts-metrages", "musique", "humour", "livres"];
    $category_list = ["conscience", "alternatives", "medias", "sante", "ecologie", "economie", "societe", "histoire"];


    if (isset($request_url[1])) {

        if ($request_url[1] == "img") {
            
            include("php/404.php");
            return;  
        }

        else if ($request_url[1] == "accueil") {
            
            include("php/homepage.php");
            return;  
        }

        else if ($request_url[1] == "connexion") {

            include("php/login.php");
            return;  
        }

        else if ($request_url[1] == "inscription") {

            include("php/subscribe.php");
            return;  
        }

        else if ($request_url[1] == "dossier" OR $request_url[1] == "recherche") {

            if      ($request_url[1] == "dossier")      $_GET["list_id"] = "folder";
            else if ($request_url[1] == "recherche")    $_GET["list_id"] = "search";

            if (isset($request_url[2])) $_GET["query_id"] = urldecode($request_url[2]);

            include("php/list.php");
            return;  
        }

        else if ($request_url[1] == "corner") {

            $_GET["corner_id"] = str_replace ("-", "_" , $request_url[2]);

            include("php/corner.php");
            return;  
        }

        else if ($request_url[1] == "info") {

            $_GET["page_id"] = str_replace ("-", "_" , $request_url[2]);

            include("php/page.php");
            return;  
        }

        else if (in_array($request_url[1], ["favoris", "memos", "recommandations", "amis"])) {

            if      ($request_url[1] == "favoris")          $_GET["list_id"] = "favorite";
            else if ($request_url[1] == "memos")            $_GET["list_id"] = "later";
            else if ($request_url[1] == "recommandations")  $_GET["list_id"] = "reco";
            else if ($request_url[1] == "amis")             $_GET["list_id"] = "friend";

            if (isset($request_url[2])) $_GET["query_id"] = $request_url[2];  

            include("php/list.php");
            return;  
        }

        else if ($request_url[1] == "profil") {

            include("php/member.php");
            return;  
        }

        else if ($request_url[1] == "dons") {

            include("php/donation.php");
            return;  
        }

        else if (in_array($request_url[1], $category_list)) {

            if      ($request_url[1] == "conscience")        $_GET["category_id"] = "1";
            else if ($request_url[1] == "alternatives")      $_GET["category_id"] = "2";
            else if ($request_url[1] == "medias")            $_GET["category_id"] = "3";
            else if ($request_url[1] == "sante")             $_GET["category_id"] = "4";
            else if ($request_url[1] == "ecologie")          $_GET["category_id"] = "5";
            else if ($request_url[1] == "economie")          $_GET["category_id"] = "6";
            else if ($request_url[1] == "societe")           $_GET["category_id"] = "7";
            else if ($request_url[1] == "histoire")          $_GET["category_id"] = "8";

            include("php/category.php");
            return;   
        }

        else if (in_array($request_url[1], $type_list)) {

            if      ($request_url[1] == "emissions")         $_GET["type_id"] = "tvshow";
            else if ($request_url[1] == "documentaires")     $_GET["type_id"] = "documentary";
            else if ($request_url[1] == "courts-metrages")   $_GET["type_id"] = "shortfilm";
            else if ($request_url[1] == "podcasts")          $_GET["type_id"] = "podcast";    
            else if ($request_url[1] == "musique")           $_GET["type_id"] = "music";
            else if ($request_url[1] == "humour")            $_GET["type_id"] = "humour";

            else if ($request_url[1] == "livres")            $_GET["type_id"] = "book";
            else if ($request_url[1] == "spectacles")        $_GET["type_id"] = "show";

            if (isset($request_url[2])) {

                if      ($request_url[2] == "conscience")    $_GET["category_id"] = "1";
                else if ($request_url[2] == "alternatives")  $_GET["category_id"] = "2";
                else if ($request_url[2] == "medias")        $_GET["category_id"] = "3";
                else if ($request_url[2] == "sante")         $_GET["category_id"] = "4";
                else if ($request_url[2] == "ecologie")      $_GET["category_id"] = "5";
                else if ($request_url[2] == "economie")      $_GET["category_id"] = "6";
                else if ($request_url[2] == "societe")       $_GET["category_id"] = "7";
                else if ($request_url[2] == "histoire")      $_GET["category_id"] = "8";

                else { 

                    $_GET["content_id"] = str_replace ("-", "_" , $request_url[2]);

                    if ($request_url[1] == "documentaires" OR $request_url[1] == "courts-metrages") {
            
                        if (isset($request_url[3]) AND isset($request_url[4])) {

                            if      ($request_url[3] == "bande-annonce")    $_GET["section_id"] = "teaser";
                            else if ($request_url[3] == "film")             $_GET["section_id"] = "movie";
                            else if ($request_url[3] == "bonus")            $_GET["section_id"] = "bonus";
                            else if ($request_url[3] == "extraits")         $_GET["section_id"] = "excerpt";

                            if (isset($request_url[4]))                     $_GET["episod_id"] = $request_url[4];
                        }

                        include("php/movie.php");
                        return;
                    }

                    else {

                        if (isset($request_url[3])) {

                            // $_GET["section_id"] = "season";

                            $_GET["episod_id"] = explode("?t=", $request_url[3])[0];
                            if (isset(explode("?t=", $request_url[3])[1]))
                                $_GET["timecode"] = explode("?t=", $request_url[3])[1];
                        }

                        include("php/series.php");
                        return;
                    }
                }

                include("php/category.php");
                return;
            }

            include("php/category.php");
            return;
        }

        else {
            include("php/404.php");
            return;
        }

    }

    else {
        include("php/homepage.php");
        return;
    }

?>