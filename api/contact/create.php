<?php
    //Cabeceras de acceso
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
   
    include_once '../../config/Database.php';
    include_once '../../models/Contact.php';
    // Ruta que incluye el autoload quecarga la vaidacion del captcha
    require_once '../../app/init.php';

    //obtenemos los datos de un formlario de tipo json y se convierte en decode
    $data = json_decode(file_get_contents('php://input'));
    //se valida y se recibe el captcha 
    $response = $recaptcha->verify($data->captcha);

    //verifica si el captcha es el correcto para realizar la insercion del correo
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
        $cliente = $contact->email;
        //enviar email
        $binar10 = "programador1@binar10.co";
        $servicio = $contact->service;
        $mensaje = "De: " .$contact->name."\n";
        $mensaje .= "Correo: ". $cliente."\n";
        $mensaje .= "Telefono: " .$contact->phone."\n";
        $mensaje .= "Servicio: " .$servicio."\n";
        $mensaje .= "Mensaje: " .$contact->message."\n";
        $informacion = "From: ".$contact->name." <" . $contact->name . ">\r\n" .
                    "Reply-To: noreply <" . $contact->name . ">\r\n" .
                    "X-Mailer: PHP/" . phpversion().
                    "Content-type: text/html"; 
        mail($binar10, $servicio, $mensaje, $informacion);
        //crear post
        if($contact->create() == 1){

           
            
            echo json_encode(
                array('message' => 'Correo enviado con exito.')
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


    