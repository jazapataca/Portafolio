<?php

class Usuario {
    public $nombre;
    public $apellido;
    public $edad;
    public $genero;
    public $correo;
    public $clave;
    public $clave2;
    public $errores = array();

    public function __construct() {}

    // No hay necesidad de métodos adicionales en esta clase
    // ya que solo se utiliza para almacenar la información del usuario
}

?>