
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

        $.post("/ws/create_session.php",
            {
                login : login,
                password : password,
            },
            function(data, status){
                // alert("Data: " + data + "\n Status: " + status);
                callback = callback_status(data);

                if (callback == "ok") {
                    if (url == "") 
                        window.location.href = "/accueil";
                    else 
                        window.location.href = url;
                }
                else {
                    $("a#message").css("visibility", "visible");
                }
            }
        )

    });

    $("a#subscribe").click(function() {
        go_to("/inscription");
    });
}


function listen_focus_input() {

    $("input#login").focusin(function(){
        $("a#message").css("visibility", "hidden");
    });

}





