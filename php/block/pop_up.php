

	<!-- BACKGROUND -->

	<img id = "background_shadow" src = "/img/icons/background_shadow.png"> </img>

	<span id = "episod_title">
		<a id = "episod_name" > Episode n° </a>
		<img id = "episod_time" class = "display" src = "/img/icons/button/later_on.png" > </img>
		<img id = "episod_medal" class = "display" src = "/img/icons/button/reco_on.png" > </img>	
	</span>

    <!-- VIDEO PLAYER -->

    <section id = "video_player" >

		<div id = "player" class = "player_popup" > </div>
		<!-- <iframe  id = "main_player" class = "player_popup" allowfullscreen allow = "autoplay" > </iframe> -->

	    <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jschannel"></script>
	    <script src = "https://player.vimeo.com/api/player.js"></script>

<!-- 	   	<a class = "next_video" > <img class = "next_video" > </img> </a>
	    <a class = "previous_video" > <img class = "previous_video" > </img> </a>

		<img id = "shadow_next_video" src = "/img/icons/shadow_left.png"> </img>
		<img id = "shadow_previous_video" src = "/img/icons/shadow_rigth.png"> </img> -->

		<!-- <img id = "current_video" > </img>  -->
		<img id = "video_close" src = "/img/icons/close_player.png"> </img>

	</section>

    <!-- AUDIO PLAYER controls = "controls" -->	
 
    <section id = "audio_player" >

		<audio id = "audio_popup" class = "player_popup" autoplay controls autoplay> </audio>

	    <a class = "next_audio" > <img class = "next_audio" > </img> </a>
	    <a class = "previous_audio" > <img class = "previous_audio" > </img> </a>

		<a class = "next_audio" > <img id = "shadow_next_audio" src = "/img/icons/shadow_left.png"> </img> </a>
		<a class = "previous_audio" > <img id = "shadow_previous_audio" src = "/img/icons/shadow_rigth.png"> </img></a>

		<img id = "current_audio"> </img>
		<img id = "audio_close" src = "/img/icons/close_player.png"> </img>

<!-- 		<div id = "audio_control" >

			<a id = "timecode" > 00:00 </a>

			<div id = "progress_bar_background" > 
				<div id = "progress_bar" > </div>
			</div>

			<div id = "time_display" >
				<a id = "current_time" class = "time" > 00:00 </a>
				<a id = "duration" class = "time" > / 00:00 </a>
			</div>
			
			<div id = "player_control" >
				<a href = "" id = "download" download = "audio.mp3">
					<img id = "download" class = "control_icon" src = "/img/icons/play/download.png" > </img>
				</a>				 

				<img id = "next" 		 class = "control_icon" src = "/img/icons/play/next.png" > </img>
				<img id = "fast_rewind"  class = "control_icon" src = "/img/icons/play/fast_rewind.png" > </img>
				<img id = "pause_play" 	 class = "control_icon" src = "/img/icons/play/pause.png" > </img>
				<img id = "fast_forward" class = "control_icon" src = "/img/icons/play/fast_forward.png" > </img>
				<img id = "previous" 	 class = "control_icon" src = "/img/icons/play/previous.png" > </img>
				<img id = "mute" 		 class = "control_icon" src = "/img/icons/play/mute.png" > </img>

			</div>

		</div> -->

	</section>


    <!-- DON -->	

	<div id = "donation_area">

		<a class = "donation_text"> Ce film vous est offert par fokus21, un don est possible sur </a> 

		<a target = "_blank" href = "https://www.helloasso.com/associations/fokus-21/formulaires/3">
			<img class = "donation_button" src = "/img/icons/button/helloasso_inline.png" > </img>
		</a>

<!-- 		Grâce à ton don, l'aventure de cette diffusion alternative va continuer et d'autres projets inspirants pourront voir le jour... Merci ! -->

	</div>


    <!-- COMMENT -->	

	<section id = "post_it">
		<img id = "comment_popup" class = "comment" > </img>

		<a id = "title" class = "comment" > Saisissez ou modifier votre avis ci-dessous : </a>

		<a id = "previous" class = "comment" > Avis précédent </a>
		<a id = "next" class = "comment" > Avis suivant </a>

		<textarea rows = "12" cols = "34" name = "comment" > </textarea>

		<a id = "validate" class = "comment" > Enregistrer cet avis </a>
		<a id = "remove" class = "comment" > Supprimer cet avis </a>

		<a id = "useless" class = "comment" > Avis inutile </a>
		<a id = "useful" class = "comment" > Avis utile </a>
	</section>
