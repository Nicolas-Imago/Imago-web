<?php
function add_href_about() {
    global $content_id;

    ECHO ' href = "../php/page.php?page_id=qui_sommes_nous" ';
}


function add_href_project() {
    global $content_id;

    ECHO ' href = "../pdf/imago_presentation.pdf" ';
    ECHO ' onclick = "window.open(this.href); return false"';
}


function add_href_chart() {
    global $content_id;

    ECHO ' href = "../pdf/imago_charte.pdf" ';
    ECHO ' onclick = "window.open(this.href); return false"';
}
?>


<div id = "cookie_popup">
    <a> En attendant que tous les créateurs nous aient donné leur accord pour héberger leurs contenus sur les plateformes partenaires Wetube ou Peertube, <br> Imago utilise les iframes (embed) youtube, viméo, soundcloud et wix. Celles-ci peuvent utiliser des cookies. En poursuivant votre navigation, vous en acceptez l'usage.</a>
    <img id = "close_cookies" src = "../img/icons/close_player.png" alt="fermer">
</div>

<div id="footer">
    <a id="info_footer"> ImagoTV</a>
    <ol id="footer_list">
        <li><a id = "item_footer_1" class = "item_footer" <?php add_href_about() ?> > A propos </a></li>
        <li><a id = "item_footer_2" class = "item_footer" <?php add_href_project() ?> > Le projet </a></li>
        <li><a id = "item_footer_3" class = "item_footer" <?php add_href_chart() ?> > La charte </a></li>
        <li><a href = "mailto:contact@imagotv.fr" id = "item_footer_3" class="item_footer"> Contact </a></li>
    </ol>
</div>

<img id="page_up" src = "../img/icons/footer/page_up_grey.png" alt="remonter">