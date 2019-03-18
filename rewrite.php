


<?php         

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL); 

?>

<?php


    // ECHO $_SERVER["REQUEST_URI"];

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "emissions") {

        $_GET["type_id"] = "tvshow";
        $_GET["content_id"] = $request_url[2];

        include("php/series.php");
    }





?>