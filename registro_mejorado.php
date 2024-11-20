<?php

require_once 'Conexion.php';
require_once 'Usuario.php';
//uso de archivos conexion y usuarios, se pusieron aparte si necesitan cambios a futuro
class Registro {
    private $conexion;
    private $usuario;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->usuario = new Usuario();
    }

    public function registrar() {   //funcion control de errores
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->validarCampos();
            if (empty($this->usuario->errores)) {
                $this->registrarUsuario();
            } else {
                $this->mostrarErrores();
            }
        }
    }

    private function validarCampos() { //validacion campos
        $this->usuario->nombre = $_POST['Nombre'];
        $this->usuario->apellido = $_POST['Apellido'];
        $this->usuario->edad = $_POST['Edad'];
        $this->usuario->genero = $_POST['Genero'];
        $this->usuario->correo = $_POST['Correo'];
        $this->usuario->clave = $_POST['Clave'];
        $this->usuario->clave2 = $_POST['ConfirmaClave'];

        if (empty($this->usuario->nombre)) {
            $this->usuario->errores['Nombre'] = 'Rellene campo Nombre';
        }
        if (empty($this->usuario->apellido)) {
            $this->usuario->errores['Apellido'] = 'Rellene campo Apellido';
        }
        if (empty($this->usuario->edad)) {
            $this->usuario->errores['Edad'] = 'Rellene campo Edad';
        }
        if (empty($this->usuario->genero)) {
            $this->usuario->errores['Genero'] = 'Rellene campo Genero';
        }
        if (empty($this->usuario->correo)) {
            $this->usuario->errores['Correo'] = 'Rellene campo Correo'; //no se si a futuro se pueda usar una clase exclusivamente para validar correo y contraseña
        } elseif (!filter_var($this->usuario->correo, FILTER_VALIDATE_EMAIL)) {
            $this->usuario->errores['Correo'] = 'Correo invalido';
        }
        if (empty($this->usuario->clave)) {
            $this->usuario->errores['Clave'] = 'Rellene campos Clave';
        } elseif (strlen($this->usuario->clave) < 5) {
            $this->usuario->errores['Clave'] = 'La contraseña debe tener al menos 5 caracteres';
        } elseif (strlen($this->usuario->clave) > 16) {
            $this->usuario->errores['Clave'] = 'La contraseña debe tener menos de 16 caracteres'; //¿esto cuenta como prevencion para iyeccion SQL?
        } elseif ($this->usuario->clave != $this->usuario->clave2) {
            $this->usuario->errores['Clave'] = 'Las contraseñas no coinciden';
        }
    }

    private function registrarUsuario() { //funcion registro, usa conectar de conexion.php
        try {
            $this->conexion->conectar();
            $stmt = $this->conexion->prepare("SELECT * FROM `datos_usuario` WHERE `Correo` = :Correo");
            $stmt->execute([':Correo' => $this->usuario->correo]);
            $usuarioExistente = $stmt->fetch();

            if ($usuarioExistente) {    //Generacion hash
                $this->usuario->errores['Correo'] = 'El correo ya está registrado';
                $this->mostrarErrores();
            } else {
                $encriptacion = password_hash($this->usuario->clave, PASSWORD_BCRYPT); //buscar mejores metodos de encriptacion
                $stmt = $this->conexion->prepare("INSERT INTO `datos_usuario` (`ID`, `Nombre`, `Apellido`, `Edad`, `Genero`, `Correo`, `Clave`) 
                    VALUES (NULL, :Nombre,:Apellido,:Edad,:Genero,:Correo,:Clave);");
                $stmt->execute([
                    ':Nombre' => $this->usuario->nombre,
                    ':Apellido' => $this->usuario->apellido,
                    ':Edad' => $this->usuario->edad,
                    ':Genero' => $this->usuario->genero,
                    ':Correo' => $this->usuario->correo,
                    ':Clave' => $encriptacion
                ]);

                header("Location: login.html");
            }
        } catch (PDOException $e) {
            echo "Error en conexión: " . $e->getMessage();
        }
    }

    private function mostrarErrores() {
        foreach ($this->usuario->errores as $error) {
            echo "<br/>" . $error;
        }
        echo "<br><a href='panel_de_registro.html'>Regresar a registro</a>";
    }
}

$registro = new Registro();
$registro->registrar();

?>