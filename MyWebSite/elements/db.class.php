<?php 

class DB{
    private $host = 'localhost';
    private $username = 'u869229698_juliennigou';
    private $password = 'Amandine1201';
    private $database = 'u869229698_food_stock';
    private $db;

    public function __construct($host= null, $username = null,$password = null, $database=null){
        if ($host != null){
            $this->host=$host;
            $this->username=$username;
            $this->password=$password;
            $this->database=$database;
        }
        try{
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->username,$this->password, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            ));
        }catch(PDOException $e){
            die('<h1> Impossible de se connecter à la base de donnée <h1/>');
        }
    }

    public function getDb() {
        if ($this->db instanceof PDO) {
             return $this->db;
        }
  }


    public function query($sql, $data = array()){
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
    
}