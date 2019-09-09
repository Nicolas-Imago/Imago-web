<?php

    $date = date("Y-m-d H:i:s");

    ////////////////////////////////// Get content list //////////////////////////////////


    function homepage_video_id_list($limit) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video
            WHERE type = 'tvshow'
            ORDER BY publication_date DESC
            LIMIT $limit
        ");

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    function homepage_audio_id_list($limit) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video
            WHERE type = 'podcast'
            ORDER BY publication_date DESC
            LIMIT $limit
        ");

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    function homepage_content_list_of($type_id, $limit) {

        global $data_base, $env, $date;

        if ($env == "prod") {

            $request = $data_base->prepare("
                SELECT *   
                FROM imago_info_content
                WHERE type = ?
                AND env = ?
                AND end_date > ?
                ORDER BY RAND()
                LIMIT $limit 
            ");

            $request->execute(array($type_id, "prod", $date));
        }

        else {

            $request = $data_base->prepare("
                SELECT *   
                FROM imago_info_content
                WHERE type = ?
                AND end_date > ?
                ORDER BY RAND()
                LIMIT $limit 
            ");

            $request->execute(array($type_id, $date));
        }

        return $request->fetchAll(PDO::FETCH_ASSOC); 
    }

    function homepage_folder_list() {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_home_content
            WHERE type = 'folder'
            ORDER BY RAND()
        ");

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    function homepage_corner_list($sub_type) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_home_content
            WHERE type = 'corner'
            AND sub_type = ?
            ORDER BY RAND()
        ");

        $request->execute(array($sub_type));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    ////////////////////////////////// Get category content //////////////////////////////////

    
    function category_content_list_of($type_id, $category_id) {

        global $data_base, $env, $date;

        if ($env == "prod") {

	        $request = $data_base->prepare("
	            SELECT *
	            FROM imago_info_content 
	            WHERE type = ? 
	            AND category = ?
	            AND env = ? 
                AND end_date > ?
	            ORDER BY RAND() 
	        ");

	        $request->execute(array($type_id, $category_id, "prod", $date));
	    }

	    else {

	        $request = $data_base->prepare("
	            SELECT *
	            FROM imago_info_content 
	            WHERE type = ? 
	            AND category = ?
                AND end_date > ?
	            ORDER BY RAND() 
	        ");

	        $request->execute(array($type_id, $category_id, $date));
	    }

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    ////////////////////////////////// Get content list //////////////////////////////////


    ///////////// Search /////////////


    function search_video_list_of($query_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video 
            WHERE type = 'tvshow'
            AND LOWER(replace(title,'é','e')) LIKE replace(LOWER(?),'é','e') 
        ");

        $request->execute(array("%" . $query_id . "%"));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function search_audio_list_of($query_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video 
            WHERE type = 'podcast'
            AND LOWER(replace(title,'é','e')) LIKE replace(LOWER(?),'é','e') 
        ");

        $request->execute(array("%" . $query_id . "%"));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function search_content_list_of($type_id, $query_id) {

        global $data_base, $env;

        if ($env == "prod") {

	        $request = $data_base->prepare("
	            SELECT *
	            FROM imago_info_content 
	            WHERE type = ? 
	            AND env = ?
	            AND ppv = 'no' 
            	AND LOWER(replace(tag,'é','e')) LIKE replace(LOWER(?),'é','e') 
	        ");

	        $request->execute(array($type_id, "prod","%" . $query_id . "%"));
	    }

	    else {

	        $request = $data_base->prepare("
	            SELECT *
	            FROM imago_info_content 
	            WHERE type = ? 
	            AND ppv = 'no' 
            	AND LOWER(replace(tag,'é','e')) LIKE replace(LOWER(?),'é','e') 
	        ");

	        $request->execute(array($type_id, "%" . $query_id . "%"));

	    }

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    ///////////// Corner /////////////


    function corner_video_list_of($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video 
            WHERE content_id = ?
            ORDER BY id DESC
        ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function corner_content_list_of($corner_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_corner_content 
            WHERE corner_id = ?
            ORDER BY content_order ASC
        ");

        $request->execute(array($corner_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    ///////////// Favorite /////////////

    function favorite_video_list_of($user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video i
            INNER JOIN imago_my_favorite f
            ON i.content_id = f.content_id
            AND i.episod_id = f.episod_id
            AND i.type = 'tvshow'
            AND f.user_id = ?
            ORDER BY f.add_date DESC
        ");

        $request->execute(array($user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 
    

    function favorite_audio_list_of($user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video i 
            INNER JOIN imago_my_favorite f
            ON i.content_id = f.content_id
            AND i.episod_id = f.episod_id
            AND i.type = 'podcast'
            AND f.user_id = ?
            ORDER BY f.add_date DESC
        ");

        $request->execute(array($user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function favorite_content_list_of($type_id, $user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_content i 
            INNER JOIN imago_my_favorite f
            ON i.content_id = f.content_id 
            AND i.type = ?
            AND f.user_id = ?
            AND f.episod_id = ''
            ORDER BY f.add_date DESC 
        ");

        $request->execute(array($type_id, $user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    ///////////// Watch later /////////////

    function watch_later_video_list_of($user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video i
            INNER JOIN imago_my_later f
            ON i.content_id = f.content_id
            AND i.episod_id = f.episod_id
            AND i.type = 'tvshow'
            AND f.user_id = ?
            ORDER BY f.add_date DESC
        ");

        $request->execute(array($user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 
    

    function watch_later_audio_list_of($user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video i 
            INNER JOIN imago_my_later f
            ON i.content_id = f.content_id
            AND i.episod_id = f.episod_id
            AND i.type = 'podcast'
            AND f.user_id = ?
            ORDER BY f.add_date DESC
        ");

        $request->execute(array($user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function watch_later_content_list_of($type_id, $user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_content i 
            INNER JOIN imago_my_later f
            ON i.content_id = f.content_id 
            AND i.type = ?
            AND f.user_id = ? 
            AND f.episod_id = ''
            ORDER BY f.add_date DESC
        ");

        $request->execute(array($type_id, $user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    ///////////// Donation /////////////

    function donation_user_list_of($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_my_donation d
            INNER JOIN imago_info_content c
            ON d.content_id = c.content_id
            WHERE d.content_id = ?
            ORDER BY donation_date ASC
        ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    function donation_content_list_of($user_id, $type_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT d.id, c.content_id, type, value, donation_date, name
            FROM imago_my_donation d
            INNER JOIN imago_info_content c
            ON d.content_id = c.content_id
            WHERE d.user_id = ?
            AND c.type = ?
            ORDER BY donation_date ASC
        ");

        $request->execute(array($user_id, $type_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    ///////////// Friend /////////////

    function connect_search_list_of($query_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT id, login
            FROM imago_list_member m
            WHERE LOWER(replace(m.login,'é','e')) LIKE replace(LOWER(?),'é','e')
        ");

        $request->execute(array("%" . $query_id . "%"));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function connect_pending_list_of($user_id, $direction) {

        global $data_base;

        if ($direction == "in") {

            $request = $data_base->prepare("
                SELECT *
                FROM imago_list_member m
                INNER JOIN imago_my_friend f
                ON m.id = f.user_id_1 
                AND f.user_id_2 = ?
                AND f.acceptance_date = '0000-00-00 00:00:00'
                ORDER BY f.invitation_date DESC
            ");
        }

        if ($direction == "out") {

            $request = $data_base->prepare("
                SELECT *
                FROM imago_list_member m
                INNER JOIN imago_my_friend f
                ON m.id = f.user_id_2 
                AND f.user_id_1 = ?
                AND f.acceptance_date = '0000-00-00 00:00:00'
                ORDER BY f.invitation_date DESC
            ");
        }

        $request->execute(array($user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    function connect_friend_list_of($user_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_list_member m
            INNER JOIN imago_my_friend f
            ON ((m.id = f.user_id_2 AND f.user_id_1 = ?)
            OR (m.id = f.user_id_1 AND f.user_id_2 = ?))
            AND f.acceptance_date != '0000-00-00 00:00:00'
            ORDER BY f.acceptance_date DESC
        ");

        $request->execute(array($user_id, $user_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 

    
    ////////////////////////////////// Get content information //////////////////////////////////


    function content_list_of($type_id, $category_id) {

        global $data_base, $env;

        if ($env == "prod") {

            $request = $data_base->prepare("
                SELECT content_id
                FROM imago_info_content 
                WHERE type = ? 
                AND category = ?
                AND env = ?
                AND ppv = 'no'
                ORDER BY content_id ASC
            ");

            $request->execute(array($type_id, $category_id));
        }

        else {

            $request = $data_base->prepare("
                SELECT content_id
                FROM imago_info_content 
                WHERE type = ? 
                AND category = ?
                AND ppv = 'no'
                ORDER BY content_id ASC
            ");

            $request->execute(array($type_id, $category_id));

        }

        return $request->fetchAll(PDO::FETCH_COLUMN, 0);
    } 


    function get_content_info($content_id) {

        global $data_base, $env;

        if ($env == "prod") {

            $request = $data_base->prepare("
                SELECT * 
                FROM imago_info_content 
                WHERE content_id = ? 
                AND env = ? 
            ");

            $request->execute(array($content_id, "prod"));
        }

        else {

            $request = $data_base->prepare("
                    SELECT * 
                    FROM imago_info_content 
                    WHERE content_id = ? 
                ");

            $request->execute(array($content_id));
        }

        return $request->fetch(); 
    } 


    function get_author_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT author_id 
            FROM imago_related_author 
            WHERE content_id = ? 
        ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_COLUMN, 0); 
    }


    function get_producer_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT producer_id 
            FROM imago_producer_content
            WHERE content_id = ? 
        ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_COLUMN, 0);
    }


    function get_related_content_list($type_id, $content_id, $author_id_list) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_content i
            INNER JOIN imago_related_author c
            ON i.content_id = c.content_id 
            AND i.type = ?
            AND i.content_id != ?
            WHERE c.author_id IN (?)
        ");

        $request->execute(array($type_id, $content_id, $author_id_list[0]));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    function get_related_comment_list($user_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT c.id, c.comment, login, color, add_date
            FROM imago_related_comment c
            INNER JOIN imago_list_member m
            ON c.user_id = m.id
            WHERE c.user_id != ?
            AND c.content_id = ?
            ORDER BY c.add_date DESC
        ");

        $request->execute(array($user_id, $content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    function get_user_comment_list($user_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_related_comment
            WHERE user_id = ?
            AND content_id = ?
        ");

        $request->execute(array($user_id, $content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    function get_related_book_list($author_id_list) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_content i
            INNER JOIN imago_related_content c
            ON i.content_id = c.content_id 
            AND c.author_id IN (?)
            AND i.type = 'book'
        ");

        $request->execute(array($author_id_list[0]));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }


    ////////////////////////////////// Get video information //////////////////////////////////


    function get_episod_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_info_video 
            WHERE content_id = ? 
        ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_view_list($content_id, $section_id, $episod_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT SUM(view)
            FROM imago_tag_screen
            WHERE  content_id = ?
            AND section_id = ?
            AND episod_id = ?
        ");

        $request->execute(array($content_id, $section_id, $episod_id));

        return $request->fetch();
    }


    function get_video_id_list($section_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_video 
            WHERE section_id = ?
            AND content_id = ? 
        ");

        $request->execute(array($section_id, $content_id));

        return $request->fetchAll(PDO::FETCH_ASSOC);
    } 


    ////////////////////////////////// Get Author information //////////////////////////////////


    function get_author_info($author_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_creator 
            WHERE creator_id = ? 
        ");

        $request->execute(array($author_id));

        return $request->fetch(PDO::FETCH_ASSOC); 
    }


    function get_author_first_name($author_id) {

        $author = get_author_info($author_id)["name"];
        $author = explode(" ", $author);
        $author = $author[0];

        return $author;
    }


    ////////////////////////////////// Get favorite information //////////////////////////////////


    function read_favorite_content($user_id, $content_id, $episod_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_my_favorite 
            WHERE user_id = ?
            AND content_id = ?
            AND episod_id = ?
        "); 
            
        $request->execute(array($user_id, $content_id, $episod_id));

        return $request->fetchAll(PDO::FETCH_ASSOC); 
    } 


    function read_watch_later_content($user_id, $content_id, $episod_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_my_later 
            WHERE user_id = ?
            AND content_id = ?
            AND episod_id = ?
        "); 
            
        $request->execute(array($user_id, $content_id, $episod_id));   

        return $request->fetchAll(PDO::FETCH_ASSOC); 
    } 

    ////////////////////////////////// Get tag information //////////////////////////////////


    function read_tag($screen_id, $type_id, $category_id, $content_id, $video_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_tag_screen 
            WHERE screen_id = ?
            AND type_id = ? 
            AND category_id = ?
            AND content_id = ?
            AND video_id = ?
        "); 
        
        $request->execute(array($screen_id, $type_id, $category_id, $content_id, $video_id));    

        return $request->fetch(); 
    } 


    function create_tag($screen_id, $type_id, $category_id, $content_id, $video_id) {

        global $data_base;

        $request = $data_base->prepare("
            INSERT INTO imago_tag_screen
                (`screen_id`, `type_id`, `category_id`, `content_id`, `video_id`, `view`) 
            VALUES 
                (:screen_id, :type_id, :category_id, :content_id, :video_id, :view)");

        $request->execute(array(
            'screen_id' => $screen_id, 
            'type_id' => $type_id, 
            'category_id' => $category_id, 
            'content_id' => $content_id, 
            'video_id' => $video_id, 
            'view' => 1, 
        ));  
    }


    function increment_tag($id, $screen_id, $type_id, $category_id, $content_id, $episod_id, $view) {

        global $data_base;

        $request = $data_base->prepare("
            UPDATE 
                imago_tag_screen 
            SET 
                screen_id = :screen_id,
                type_id = :type_id, 
                category_id = :category_id,
                content_id = :content_id,
                episod_id = :episod_id,
                view = :view
            WHERE 
                id = :id
        ");

        $request->execute(array(
            'screen_id' => $screen_id, 
            'type_id' => $type_id, 
            'category_id' => $category_id, 
            'content_id' => $content_id, 
            'episod_id' => $episod_id, 
            'view' => $view, 
            'id' => $id
        ));

        return;
    }



    ////////////////////////////////// Get member information //////////////////////////////////


    function create_member($first_name, $last_name, $email, $login, $password, $current_date) {

        global $data_base;

        $status = "user";
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // $email_crypt = AES_ENCRYPT($email, "toto");
        $email_crypt = $email;

        $request = $data_base->prepare("
            INSERT INTO imago_list_member
                (`first_name`, `last_name`, `email`, `login`, `password`, `status`, `subscription_date`) 
            VALUES 
                (:first_name, :last_name, :email, :login, :password, :status, :subscription_date)");

        $request->execute(array(
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'email' => $email_crypt, 
            'login' => $login, 
            'password' => $password_hash, 
            'status' => $status, 
            'subscription_date' => $current_date,
        ));

        return;
    }


    function read_member($login) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_list_member 
            WHERE login = ? 
        ");

        $request->execute(array($login));

        return $request->fetch(); 
    } 


    function update_member_info($id, $first_name, $last_name, $email, $login, $current_date) {

        global $data_base;

        $request = $data_base->prepare("
            UPDATE 
                imago_list_member 
            SET 
                first_name = :first_name, 
                last_name = :last_name,
                email = :email,
                login = :login,
                modification_date = :modification_date
            WHERE 
                id = :id
        ");

        $request->execute(array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'login' => $login,
            'modification_date' => $current_date,
            'id' => $id
        ));

        return;
    }


    function update_member_pwd($id, $password, $current_date) {

        global $data_base;

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $request = $data_base->prepare("
            UPDATE
                imago_list_member 
            SET 
                password = :password,
                modification_date = :modification_date 
            WHERE 
                id = :id
        ");

        $request->execute(array(
            'password' => $password_hash,
            'modification_date' => $current_date,
            'id' => $id
        ));

        return;
    }


    function count_member() {

        global $data_base;

        $request = $data_base->prepare("
            SELECT COUNT(*) 
            FROM imago_list_member 
        ");

        $request->execute();
        
        return $request->fetch();  
    }

// SELECT COUNT(DISTINCT email) FROM imago_list_member WHERE email != ''
         
?>