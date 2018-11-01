<?php

class Database{

    private $host       = 'localhost';
    private $db_name    = 'api_binar10';
    private $username   = 'root';
    private $password   = '';
    private $conn;

    //Coneccion a la base de datos
    public function connect()
    {
       $this->conn = null;

        try{
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    } 

    // public function obtenerDireccionIP()
    // {
    //     if (!empty($_SERVER ['HTTP_CLIENT_IP'] ))
    //     $ip=$_SERVER ['HTTP_CLIENT_IP'];
    //     elseif (!empty($_SERVER ['HTTP_X_FORWARDED_FOR'] ))
    //     $ip=$_SERVER ['HTTP_X_FORWARDED_FOR'];
    //     else
    //     $ip=$_SERVER ['REMOTE_ADDR'];
    //     return $ip;
    // }
}

