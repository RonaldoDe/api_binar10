<?php
    //Cabeceras de acceso
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
   
    include_once '../../config/Database.php';
    include_once '../../models/Contact.php';

    require_once '../../app/init.php';
    $data = json_decode(file_get_contents('php://input'));
    $response = $recaptcha->verify($data->captcha);

    if($response->isSuccess()){
       //instanciar BD y coneccion
        $database = new Database();
        $db = $database->connect();


        //instanciar objeto del post
        $contact = new Contact($db);

        //obtener posts publicados
        $contact->name = $data->name;
        $contact->email = $data->email;
        $contact->phone = $data->phone;
        $contact->service = $data->service;
        $contact->message = $data->message;

        //crear post
        if($contact->create() == 1){
            echo json_encode(
                array('message' => 'Contacto Creado')
            );
        }else{
            echo json_encode(
                array('message' => $contact->create())
            );
        }

    }else{
        echo json_encode(
            array('message' => 'Por favor Verificar que no eres un robot')
        );
    }


    