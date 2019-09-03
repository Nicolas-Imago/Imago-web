
/******************************************** ENV VARIABLES ********************************************/

// Log env

console.log(env)
console.log(base_url)


// Variables

var trigger_width = 480;
var version = "1.0.9"


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

    // console.log("step 1 : " + my_cookie)
    
    for(index = 0; index < my_cookie.length; index++) {

        var cookie_temp = my_cookie[index];
        
        while (cookie_temp.charAt(0) == " ")
            cookie_temp = cookie_temp.substring(1);
        
        if (cookie_temp.indexOf(name) == 0) {
            result_cookie = cookie_temp.substring(name.length, cookie_temp.length);
            // console.log("step 2 : " + result_cookie)
            return result_cookie;
        }
    }

    return "";
}


/********************************************** FUNCTIONS **********************************************/

function go_to(url) {
        window.location.href = base_url + url;
}


function move_element(target, height_factor, speed) {

    header_height = height_factor * window.innerWidth;
    image_top = header_height + speed * (window.scrollY);
    $(target).css("top", image_top);
        
};


function callback_status(data) {

    data = "{" + data.split('{')[1];
    data = data.substring(0, data.length - 2);

    status = JSON.parse(data).status;

    if (status == "not_connected") go_to("/php/login.php"); 

    return status       
};


/********************************************** FUNCTIONS **********************************************/

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


// function streaming_type_of(hosting) {

//     switch (hosting) {
        
//         case "youtube"          : streaming = "video"; break;
//         case "invidio"          : streaming = "video"; break;

//         case "vimeo"            : streaming = "video"; break;
//         case "dailymotion"      : streaming = "video"; break;
//         case "facebook"         : streaming = "video"; break;

//         case "peertube"         : streaming = "video"; break;
//         case "wetube"           : streaming = "video"; break;
//         case "arte"             : streaming = "video"; break;
//         case "ftv"              : streaming = "video"; break;
//         case "tv5monde"         : streaming = "video"; break;

//         case "soundcloud"       : streaming = "audio"; break;
//         case "soundcloud_embed" : streaming = "audio"; break;

//         case "podcloud"         : streaming = "audio"; break;
//         case "pippa"            : streaming = "audio"; break;
//         case "ausha"            : streaming = "audio"; break;
//         case "anchor"           : streaming = "audio"; break;
//         case "infomaniak"       : streaming = "audio"; break;
//         case "radio_france"     : streaming = "audio"; break;
//         case "reporterre"       : streaming = "audio"; break;

//         case "rss"              : streaming = "audio"; break;    

//         default                 : streaming = ""; break;
//     }

//     return streaming
// }

