<?php
session_start();

require_once 'Conexion.php'; // Incluye el archivo de conexión

class Login {
    private $conn;

    public function __construct() {
        $this->conn = new Conexion();
    }
    /*public function __construct() {
        $this->pdo = new PDO('mysql:host=' . $this->servername . '; dbname=' . $this->dbname, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }*/

    public function validateLogin($correo, $clave) {
        $error = array();

        if (empty($correo)) {
            $error['Correo'] = 'Rellene campo usuario';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error['Correo'] = 'Formato de correo invalido';
        }

        if (empty($clave)) {
            $error['Clave'] = 'Rellene campos Clave';
        }

        return $error;
    }

    public function login($correo, $clave) {
        $this ->conn->conectar();
        $validate=$this->conn->prepare("SELECT * FROM `datos_usuario` WHERE Correo = :Correo");

        //$sql = "SELECT * FROM `datos_usuario` WHERE Correo = :Correo";
        //$resultado = $this->pdo->prepare($sql); //esto es validate
        $validate->execute(['Correo' => $correo]);

        $usuarios = $validate->fetchAll(PDO::FETCH_ASSOC);

        $login = false;

        foreach ($usuarios as $user) {
            if (password_verify($clave, $user['Clave'])) {
                $_SESSION['loggedUser'] = $user['Nombre'];
                $login = true;
            }
        }

        return $login;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $login = new Login();

    $correo = (isset($_POST['Correo'])) ? htmlspecialchars($_POST['Correo']) : NULL;
    $clave = (isset($_POST['Clave'])) ? $_POST['Clave'] : null;

    $error = $login->validateLogin($correo, $clave);

    if (empty($error)) {
        if ($login->login($correo, $clave)) {
            echo "login exitoso";
            $_SESSION["usuario"]=$_POST['Correo'];
            header("Location: logged.php");

        } else {
            echo "Error de login";
        }
    } else {
        foreach ($error as $error) {
            echo "<br/>" . $error . "";
        }
        echo "<br/><a href='login.html'>Regresar a login</a>";
        echo "<br><a href='panel_de_registro.html'>Regresar a registro</a>";
    }
}
?>