<?php

class Contact{
    //cosas de base de datos
    private $conn;
    private $table = 'contact';

    //propiedades de Post
    public $id;
    public $name;
    public $email;
    public $phone;
    public $service;
    public $message;
    public $created_at;

    //constructor con base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //obtener Posts
    public function read()
    {
       //crear query
       $query = 'SELECT c.id,c.name, c.email, c.phone, c.service, c.message, c.created_at
       FROM ' .$this->table. ' c ORDER By c.created_at DESC';

       //preparar el statement
       $stmt = $this->conn->prepare($query);

       //ejecutar el query
       $stmt->execute();

       return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT c.id, c.name, c.email, c.phone, c.service, c.message, c.created_at
        FROM ' .$this->table. ' c  WHERE c.service = ? LIMIT 0,1';

        //preparar el statement
       $stmt = $this->conn->prepare($query);

       //enlazar id
       $stmt->bindParam(1, $this->service);

       //ejecutar el query
       $stmt->execute();

       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       //establecer propiedades
       $this->id = $row['id'];
       $this->name = $row['name'];
       $this->email = $row['email'];
       $this->phone = $row['phone'];
       $this->service = $row['service'];
       $this->message = $row['message'];
    }

    //crear post
    public function create()
    {
        //query para crear usuario
        $query = 'INSERT INTO '.$this->table.' SET name = :name, email = :email, phone = :phone, service = :service, message = :message';

        //preparar la sentencia
        $stmt = $this->conn->prepare($query);

        //limpiar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->service = htmlspecialchars(strip_tags($this->service));
        $this->message = htmlspecialchars(strip_tags($this->message));

        if($this->name != '' && $this->email != '' && $this->service != ''){
            //enlazar data
            if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/", $this->email)){
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':service', $this->service);
                $stmt->bindParam(':message', $this->message);

                //ejecutar query
                if($stmt->execute()){
                    return true;
                }
                return 'error del servidor';
            }else{
                return 'correo no valido';
            }
        }else{
            return 'Campos faltantes';
        }
        
    }
}                                                                              