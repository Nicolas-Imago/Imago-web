 
<?php include("../php/mutual/init.php") ?>

<?php

	// Random function

	function create_player_tvshow_list($category) {

        global $data_base;

        $tvshow_list = $data_base->prepare(
        	"SELECT content_id FROM imago_info_tvshow WHERE category = ? AND hosting = 'youtube' ORDER BY RAND() LIMIT 2 ");
        $tvshow_list->execute(array($category));

        return $tvshow_list->fetchAll(PDO::FETCH_COLUMN, 0); 

    }

	function create_player_video_list($content) {

        global $data_base;

        $tvshow_list = $data_base->prepare(
        	"SELECT video_id FROM imago_info_video WHERE content_id = ? ORDER BY RAND() LIMIT 1 ");
        $tvshow_list->execute(array($content));

        return $tvshow_list->fetch(); 

    } 


	$player_tvshow_list[1] = create_player_tvshow_list("Conscience");
	$player_tvshow_list[2] = create_player_tvshow_list("Alternatives");
	$player_tvshow_list[3] = create_player_tvshow_list("Esprit critique");
	$player_tvshow_list[4] = create_player_tvshow_list("Santé");
	$player_tvshow_list[5] = create_player_tvshow_list("Ecologie");
	$player_tvshow_list[6] = create_player_tvshow_list("Economie");
	$player_tvshow_list[7] = create_player_tvshow_list("Société");
	$player_tvshow_list[8] = create_player_tvshow_list("Connaissance");

    for ($index = 1; $index <= 8; $index++) {
    	$player_video_list[$index][0] = create_player_video_list($player_tvshow_list[$index][0])[0];
    	$player_video_list[$index][1] = create_player_video_list($player_tvshow_list[$index][1])[0];
    }

    /* Mette le type du document à text/javascript plutôt qu’à text/html */

    header("Content-type: text/javascript");

    /* Notre tableau PHP multidimentionnel permettant de passer à javascript via Ajax ajax */

    $arr = array(

          	array(
            	array(
                    "tvshow" => $player_tvshow_list[1][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[1][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[1][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[1][1]
            	)          	
            ),
            array(
             	array(
                    "tvshow" => $player_tvshow_list[2][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[2][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[2][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[2][1]
            	)  
            ),
            array(
            	array(
                    "tvshow" => $player_tvshow_list[3][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[3][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[3][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[3][1]
            	)   
            ),
            array(
            	array(
                    "tvshow" => $player_tvshow_list[4][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[4][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[4][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[4][1]
            	)  
            ),
            array(
            	array(
                    "tvshow" => $player_tvshow_list[5][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[5][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[5][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[5][1]
            	)  
            ),
            array(
            	array(
                    "tvshow" => $player_tvshow_list[6][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[6][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[6][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[6][1]
            	)  
            ),
            array(
             	array(
                    "tvshow" => $player_tvshow_list[7][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[7][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[7][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[7][1]
            	)  
            ),
            array(
            	array(
                    "tvshow" => $player_tvshow_list[8][0],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[8][0]
            	),
            	array(
                    "tvshow" => $player_tvshow_list[8][1],
                    "thumbnail" => "youtube",
                    "video" => $player_video_list[8][1]
            	)  
            )
    );

    echo json_encode($arr);

?>
