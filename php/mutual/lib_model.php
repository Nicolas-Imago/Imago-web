<?php

    // Get content information resquests

    function get_content_info($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_info_content 
            WHERE content_id = ? ");

        $request->execute(array($content_id));

        return $request->fetch(); 
    } 

    function get_author_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT author_id 
            FROM imago_author_content 
            WHERE content_id = ? ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_COLUMN, 0); 
    }

    function get_producer_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT producer_id 
            FROM imago_producer_content
            WHERE content_id = ? ");

        $request->execute(array($content_id));

        return $request->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    function get_episod_id_list($content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT hosting, thumbnail, youtube_id, vimeo_id, dailymotion_id, arte_id, ftv_id, peertube_id, wetube_id, wix_id, soundcloud_id, pippa_id, title, duration, publication_date  
            FROM imago_info_video 
            WHERE content_id = ? ");

        $request->execute(array($content_id));

        return $request->fetchAll();
    }

    function get_video_id($content_id, $episod_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT youtube_id, vimeo_id, dailymotion_id, arte_id, ftv_id, peertube_id, wetube_id, wix_id, soundcloud_id, pippa_id  
            FROM imago_info_video 
            WHERE content_id = ?
            AND episod_id = ? ");

        $request->execute(array($content_id, $episod_id));

        return $request->fetchAll();
    }

    function get_video_id_list($sub_type, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT hosting, thumbnail, youtube_id, vimeo_id, dailymotion_id, arte_id, ftv_id, peertube_id, wetube_id, title, duration, publication_date
            FROM imago_info_video 
            WHERE sub_type = ?
            AND content_id = ? ");

        $request->execute(array($sub_type, $content_id));

        return $request->fetchAll();
    }  

    // function get_movie_video_id_list($content_id) {

    //     global $data_base;

    //     $request = $data_base->prepare("
    //         SELECT sub_type, youtube_id 
    //         FROM imago_info_video 
    //         WHERE content_id = ? ");

    //     $request->execute(array($content_id));

    //     return $request->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
    // }   


    // Author information resquests

    function get_author_info($author_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT *
            FROM imago_info_creator 
            WHERE creator_id = ? ");

        $request->execute(array($author_id));

        return $request->fetch(); 
    }

    function get_author_first_name($author_id) {

        $author = get_author_info($author_id)["name"];
        $author = explode(" ", $author);
        $author = $author[0];

        return $author;
    }

    // function get_author_name_json($author_id) {

    //     $author_json_url = "../json/author_list.json";
    //     $author_json = file_get_contents($author_json_url);
    //     $author = json_decode($author_json, true);
    //     $author = $author[$author_id]["name"];

    //     return $author;
    // }

    // function get_author_first_name_json($author_id) {

    //     $author = get_author_name_json($author_id);
    //     $author = explode(" ", $author);
    //     $author = $author[0];

    //     return $author;
    // }


    // Get favorite information 

    function read_favorite_content($user_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            SELECT * 
            FROM imago_favorite_content 
            WHERE user_id = ?
            AND content_id = ? 
        "); 
        
        $request->execute(array($user_id, $content_id));    

        return $request->fetch(); 
    } 

    function add_favorite_content($user_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            INSERT INTO imago_favorite_content
                (`user_id`, `content_id`) 
            VALUES 
                (:user_id, :content_id)");

        $request->execute(array(
            'user_id' => $user_id, 
            'content_id' => $content_id,
        ));  
    }

    function remove_favorite_content($user_id, $content_id) {

        global $data_base;

        $request = $data_base->prepare("
            INSERT INTO imago_favorite_content
                (`user_id`, `content_id`) 
            VALUES 
                (:user_id, :content_id)");

        $request->execute(array(
            'user_id' => $user_id, 
            'content_id' => $content_id,
        ));  
    }


    // Get tag information 

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

    function increment_tag($id, $screen_id, $type_id, $category_id, $content_id, $video_id, $view) {

        global $data_base;

        $request = $data_base->prepare("
            UPDATE 
                imago_tag_screen 
            SET 
                screen_id = :screen_id,
                type_id = :type_id, 
                category_id = :category_id,
                content_id = :content_id,
                video_id = :video_id,
                view = :view
            WHERE 
                id = :id
        ");

        $request->execute(array(
            'screen_id' => $screen_id, 
            'type_id' => $type_id, 
            'category_id' => $category_id, 
            'content_id' => $content_id, 
            'video_id' => $video_id, 
            'view' => $view, 
            'id' => $id
        ));

        return;
    }


    // Get member information requets 

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
            WHERE login = ? ");

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

?>