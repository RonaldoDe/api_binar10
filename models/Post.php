<?php

class Post{
    //cosas de base de datos
    private $conn;
    private $table = 'posts';

    //propiedades de Post
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
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
       $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at 
       FROM ' .$this->table. ' p LEFT JOIN categories c ON p.category_id = c.id ORDER By p.created_at DESC';

       //preparar el statement
       $stmt = $this->conn->prepare($query);

       //ejecutar el query
       $stmt->execute();

       return $stmt;
    }
}