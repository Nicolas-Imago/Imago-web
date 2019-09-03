
/********************************************** INIT ***********************************************/

init_tvshow_screen();

function init_tvshow_screen() {

    // Display screen

    $("div#screen").fadeIn(2000);
    $("div#footer").show();

    $("a#message").css("visibility", "hidden");

    // listen mouse over, scroll and resize

    listen_validate_login();
    listen_focus_input();

    addEventListener("resize", close_menu_and_user, false);
}


/*********************************************** LISTEN *********************************************/

function listen_validate_login() {

    // Listen mouse over

    $("a.action").hover(function() {
        $(this).css("color","white");
        $(this).css("cursor","pointer"); 
    },function() {
        $(this).css("color","grey");
        $(this).css("cursor","auto");
    });

    // Listen click on

    $("a#validate").click(function() {
        // document.getElementById("form").submit();

        login = $("input#login").val();
        password = $("input#password").val();

        url = get_cookie("url_cookie");

        $.post("../ws/create_session.php",
            {
                login : login,
                password : password,
            },
            function(data, status){
                // alert("Data: " + data + "\n Status: " + status);

                status = callback_status(data);

                console.log(status);

                if (status == "ok") {
                    if (url == "") 
                        window.location.href = "homepage.php";
                    else 
                        window.location.href = url;
                }
                else {
                    $("a#message").css("visibility", "visible");
                }
            }
        )

    });

    // $("a#enter").click(function() {
    //     // go_to("/php/homepage.php");
    //     url = get_cookie("url_cookie")
    //     if (url == "") window.location.href = "homepage.php";
    //     else window.location.href = url;
    // });

    // $("a#logout").click(function() {
    //     // go_to("/php/homepage.php");
    //     window.location.href = get_cookie("url_cookie");
    // });       

    $("a#subscribe").click(function() {
        go_to("/php/subscribe.php");
    });
}


function listen_focus_input() {

    $("input#login").focusin(function(){
        $("a#message").css("visibility", "hidden");
    });

}





