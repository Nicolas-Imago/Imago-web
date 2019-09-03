
		<section id = "information">

			<div id = "information_header">
				<a class = "logo_image">
					<img class = "logo_image" src = <?php ECHO $logo_url ?> > </img>
				</a>			
				<span id = "title">
					<a class = "name" <?php display_admin($type_id, $content_id) ?> > <?php ECHO $content["name"] ?>
						<img id = "heart" class = "content_access" src = "../img/icons/button/heart.png" > </img>
						<img id = "time" class = "content_access" src = "../img/icons/button/time.png" > </img>
						<img id = "lines" class = "content_access" src = "../img/icons/button/lines.png" > </img>
					</a>
					<a class = "author"> <?php ECHO $author_name ?> </a>
				</span>
				<?php display_author_image($author_id_list) ?>
			</div>

			
			<div class = "description">
				<a class = "description"> <?php ECHO $content["description"] ?> </a>
				<!-- <a class = "more_info"> En savoir plus</a> -->
			</div>

			<div class = "date"> 
				<a class = "info_title"> Année : </a>
				<a class = "year"> <?php ECHO $content["date"] ?> </a>
			</div>

			<div class = "number"> 
				<a class = "info_title"> Épisodes : </a>
				<a class = "number"> <?php ECHO $video_number ?> </a>
			</div>

			<div class = "duration"> 
				<a class = "info_title"> Durée : </a>
				<a class = "duration"> <?php ECHO $content["duration"] . " minutes" ?> </a>
			</div>

			<div class = "category"> 
				<a class = "info_title"> Thématique : </a>
				<a class = "category"> <?php ECHO $content["category"] ?> </a> 
			</div>

			<div class = "info"> 
				<a class = "info_title"> <?php ECHO $info_title ?> </a>
				<a class = "data" target = "_blank" href = <?php ECHO $content["link"] ?> > <?php ECHO $info_data ?> </a> 
			</div>


			<div id = "note_1"> 
				<div class = "note_title">
					<a class = "info_title"> Accessibilité </a>
					<a> au grand public : </a>
				</div>
				<div class = "note">
					<img id = "note_1_1" class = "note_image" <?php display_note(1, "1") ?> ></img>
					<img id = "note_1_2" class = "note_image" <?php display_note(2, "1") ?> ></img>
					<img id = "note_1_3" class = "note_image" <?php display_note(3, "1") ?> ></img>
					<img id = "note_1_4" class = "note_image" <?php display_note(4, "1") ?> ></img>
					<img id = "note_1_5" class = "note_image" <?php display_note(5, "1") ?> ></img>
				</div>
			</div>

			<div id = "note_2"> 
				<div class = "note_title"> 
					<a class = "info_title"> Analyse </a> 
					<a> des modèles dominants : </a>
				</div>
				<div class = "note">
					<img id = "note_2_1" class = "note_image" <?php display_note(1, "2") ?> ></img>
					<img id = "note_2_2" class = "note_image" <?php display_note(2, "2") ?> ></img>
					<img id = "note_2_3" class = "note_image" <?php display_note(3, "2") ?> ></img>
					<img id = "note_2_4" class = "note_image" <?php display_note(4, "2") ?> ></img>
					<img id = "note_2_5" class = "note_image" <?php display_note(5, "2") ?> ></img>
				</div>			
			</div>

			<div id = "note_3"> 
				<div class = "note_title"> 
					<a class = "info_title"> Proposition </a> 
					<a> de modèles alternatifs : </a>
				</div>
				<div class = "note">
					<img id = "note_3_1" class = "note_image" <?php display_note(1, "3") ?> ></img>
					<img id = "note_3_2" class = "note_image" <?php display_note(2, "3") ?> ></img>
					<img id = "note_3_3" class = "note_image" <?php display_note(3, "3") ?> ></img>
					<img id = "note_3_4" class = "note_image" <?php display_note(4, "3") ?> ></img>
					<img id = "note_3_5" class = "note_image" <?php display_note(5, "3") ?> ></img>
				</div>

				<!-- <a class = "set_note"> envoyez vos notes </a> -->
				<!-- <a class = "more_note"> plus de notes</a> -->
			</div>

		</section>
