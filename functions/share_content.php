<?php
// Get parameters and set notes
$url = $_GET["url"];
$social_network = $_GET["social_network"];
?>

<!-- VIEW -->
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset = "utf-8"/>
    <link rel = "stylesheet" href="css/share_content.css"/>
    <title> Partage de contenu </title>

    <script src = "../lib/jquery.js"></script>

</head>

<body>
<img id = "background_image" src = "/img/login/imago.jpg" alt="imago">

<div>
    <p><a id = "text_line_1"> </a></p>
    <p><a id = "text_line_2"> </a></p>
    <p><a id = "text_line_3"> </a></p>
    <!--         <input type = "text" id = "url" value = "<?php ECHO $url ?> " />
 -->        <p><a id = "action"> partager</a></p>
</div>


<!-- JS VARIABLES INIT -->
<script type="text/javascript">

    var url = "<?php ECHO $url; ?>";
    var social_network = "<?php ECHO $social_network; ?>";

</script>


<!-- JS FILES -->
<script src = "js/share_content.js"></script>

</body>
</html>