<?php
    //Cabeceras de acceso
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Contact.php';

    //instanciar BD y coneccion
    $database = new Database();
    $db = $database->connect();

    //instanciar objeto del post
    $contact = new Contact($db);

    //obtener id
    $contact->service = isset($_GET['service']) ? $_GET['service'] : die(json_encode(
        $contact_arr = array(
        'error' => 'Search faltante'
    )));

    //obtener post
    $contact->read_single();

    

    if($contact->id != null){
        //crear array
    $contact_arr = array(
        'id' => $contact->id,
        'name' => $contact->name,
        'email' => $contact->email,
        'phone' => $contact->phone,
        'service' => $contact->service,
        'message' => $contact->message,
    );
    }else{
        $contact_arr = array(
            'error' => 'Servicio no disponible'
        );
    }

    print_r(json_encode($contact_arr));

    