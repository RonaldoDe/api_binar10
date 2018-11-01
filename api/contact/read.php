<?php
    //Cabeceras de acceso
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Contact.php';

    //instanciar BD y conexion
    $database = new Database();
    $db = $database->connect();

    //instanciar objeto del contact
    $contact = new Contact($db);

    if($result = $contact->read()){

    }
    //obtener cantidad de filas
    $num = $result->rowCount();

    //Verificar si hay algun contacto
    if($num > 0){
        //array de los contactos
        $contact_arr = array();
        $contact_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $contact_item = array(
                'id' => $id,
                'name' => $name,
                'message' => html_entity_decode($message),
                'email' => $email,
                'phone' => $phone,
                'service' => $service
            );

            //agregar al array data
            array_push($contact_arr['data'], $contact_item);
        }

        //Converti a json y salida
        echo json_encode($contact_arr);

    }else{
        //no hay contactos
        echo json_encode(
            array('message' => 'No hay Correos')
        );
    }