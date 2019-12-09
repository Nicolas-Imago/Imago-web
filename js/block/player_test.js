// var player, iframe;
// var toto = document.querySelector.bind(document);

// init player
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '200',
    width: '300',
    videoId: 'dQw4w9WgXcQ',
    events: {
      'onReady': onPlayerReady
    }
  });
}

// when ready, wait for clicks
function onPlayerReady(event) {

  var player = event.target;
  // var toto = document.querySelector.bind(document);

  iframe = document.querySelector.bind(document)("iframe#player");
  listen_fullscreen(); 
}

function listen_fullscreen() {

    // Listen mouse over

    $("a#button").hover(function() {
        $(this).css("cursor","pointer");
        $(this).css("color","white");
    },function() {
        $(this).css("cursor","auto");
        $(this).css("color","grey"); 
    });

    // Listen click on

    $("a#button").click(function() {
        playFullscreen();
    });
}

// function setupListener (){
// toto('button').addEventListener('click', playFullscreen);
// }

function playFullscreen (){
  player.playVideo();//won't work on mobile
  
  var requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
  if (requestFullScreen) {
    requestFullScreen.bind(iframe)();
  }
}


function launch_video_player(hosting, video_id) {

    console.log("toto")
}

function launch_audio_player(hosting, episod_id, audio_id, timecode) {

    console.log("toto")

}