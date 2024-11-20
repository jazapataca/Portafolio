<?php

class Conexion {    //declarando valores de conexion
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $pdo;

    public function __construct() { //decalrando credenciales de acceso a la base de datos
        $this->servername ="localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "sistemaphp";
    }

    public function conectar() {
        try {
            $this->pdo = new PDO('mysql:host='.$this->servername.'; dbname='.$this->dbname,$this->username,$this->password);//conexion base de datos
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //control de errores mas preciso

        } catch (PDOException $e) {
            echo "Error connecting to database: " . $e->getMessage();
        }
    }
    public function close(){
        $this->pdo = null;
    }
    public function getPDO() {  //construccotr para iniciar sesion
        return $this->pdo;
    }
    public function prepare($sql) { //prepara sentencias sql
        return $this->pdo->prepare($sql);
    }
    }
?>