<?php
    //Cabeceras de acceso
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instanciar BD y coneccion
    $database = new Database();
    $db = $database->connect();

    //instanciar objeto del post

    $post = new Post($db);

    //query del post
    $result = $post->read();
    //obtener cantidad de filas
    $num = $result->rowCount();

    //Verificar si hay algun post
    if($num > 0){
        //array de los post
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //agregar al array data
            array_push($posts_arr['data'], $post_item);
        }

        //Converti a json y salida
        echo json_encode($posts_arr);

    }else{
        //no hay posts
        echo json_encode(
            array('message' => 'No hay posts')
        );
    }