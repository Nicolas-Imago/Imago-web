
var trigger_width = 480;
var version = "1.1.1";

/*********************************************** COOKIES ***********************************************/


function set_cookie(cookie_name, cookie_value, expire_day) {

    var date = new Date();
    date.setTime(date.getTime() + (expire_day * 24 * 60 * 60 * 1000));
    
    var expires = "expires=" + date.toGMTString();
    document.cookie = cookie_name + "=" + cookie_value + ";" + expires + ";path=/";
}

function get_cookie(cookie_name) {

    var name = cookie_name + "=";
    var my_cookie = decodeURIComponent(document.cookie);
    var my_cookie = my_cookie.split(";");
    
    for(index = 0; index < my_cookie.length; index++) {

        var cookie_temp = my_cookie[index];
        
        while (cookie_temp.charAt(0) == " ")
            cookie_temp = cookie_temp.substring(1);
        
        if (cookie_temp.indexOf(name) == 0) {
            result_cookie = cookie_temp.substring(name.length, cookie_temp.length);
            return result_cookie;
        }
    }

    return "";
}


/********************************************** MONITORING **********************************************/

var currentUrl = location.href;

function reset_matomo(page_name) {

    _paq.push(['setReferrerUrl', currentUrl]);
     currentUrl = window.location;
    _paq.push(['setCustomUrl', currentUrl]);
    _paq.push(['setDocumentTitle', page_name]);

    // remove all previously assigned custom variables, requires Matomo (formerly Piwik) 3.0.2
    _paq.push(['deleteCustomVariables', 'page']); 
    _paq.push(['setGenerationTimeMs', 0]);
    _paq.push(['trackPageView']);

    // make Matomo aware of newly added content
    var content = document.getElementById('content');
    _paq.push(['MediaAnalytics::scanForMedia', content]);
    _paq.push(['FormAnalytics::scanForForms', content]);
    _paq.push(['trackContentImpressionsWithinNode', content]);
    _paq.push(['enableLinkTracking']);
}


/********************************************** FUNCTIONS **********************************************/

function go_to(url) {
        window.location.href = url;
}

function set_sharing_url() {


    sharing_url = encodeURIComponent(window.location);

    trombinobooq_url = "https://www.facebook.com/dialog/share?app_id=593792624381849&display=popup&href=" + sharing_url;
    cock_a_doodle_doo_url = "https://twitter.com/intent/tweet?url=" + sharing_url + "&via=ImagoTV_fr";

    $("a#trombinobooq").attr("href", trombinobooq_url);
    $("a#cock_a_doodle_doo").attr("href", cock_a_doodle_doo_url);

}

function limite(zone, max) {

    if (zone.value.length >= max)
        zone.value = zone.value.substring(0, max);
    else
        $("a#callback").show();
        $("a#callback").text(zone.value.length + "/350");
}

function move_element(target, height_factor, speed) {

    header_height = height_factor * window.innerWidth;
    image_top = header_height + speed * (window.scrollY);
    $(target).css("top", image_top);       
}


function set_mosaic_mode() {

    $("div.pager_container").hide();
    $("div.arrow_container").hide(); 

    $("img#arrow_left_page").show();
    $("img#arrow_right_page").show();

    $("div.list_container").css("white-space", "normal");   
    $("a.line_2").hide();
}


function callback_status(data) {

    data = "{" + data.split('{')[1];
    data = data.split('}')[0] + "}";

    callback = JSON.parse(data).status;

    if (callback == "not_connected") 
        window.location.href = "/connexion"; 

    return callback       
}

/********************************************** CATEGORY **********************************************/

function category_name_of(category_id) {

    if (category_id == 1)       category_name = "Conscience";
    if (category_id == 2)       category_name = "Alternatives";
    if (category_id == 3)       category_name = "Média";
    if (category_id == 4)       category_name = "Santé";        
    if (category_id == 5)       category_name = "Ecologie";
    if (category_id == 6)       category_name = "Economie";
    if (category_id == 7)       category_name = "Société";
    if (category_id == 8)       category_name = "Histoire";

    return category_name
}

function category_id_of(category_name) {

    if (category_name == "Conscience")      category_id = 1;
    if (category_name == "Alternatives")    category_id = 2;
    if (category_name == "Média")           category_id = 3;
    if (category_name == "Santé")           category_id = 4;
    if (category_name == "Ecologie")        category_id = 5;
    if (category_name == "Economie")        category_id = 6;
    if (category_name == "Société")         category_id = 7;
    if (category_name == "Histoire")        category_id = 8;

    return category_id
} 

function section_of(section_id) {

    if      (section_id == "teaser")       section = "bande-annonce";
    else if (section_id == "movie")        section = "film";
    else if (section_id == "bonus")        section = "bonus";
    else if (section_id == "excerpt")      section = "extraits";

    else section = "";

    return section;
}


/********************************************** TIME **********************************************/

function format_time(time) {

    var hours = Math.floor(time / 3600);
    var mins  = Math.floor((time % 3600) / 60);
    var secs  = Math.floor(time % 60);
    
    if (secs < 10)
        secs = "0" + secs;
    
    if (hours) {
        if (mins < 10)
            mins = "0" + mins;
        
        return hours + ":" + mins + ":" + secs;
    } else {
        return mins + ":" + secs;
    }
}
