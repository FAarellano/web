<?php

class Database
{
    private $hostname = "btaofpbbpl4d32s3d9sv-mysql.services.clever-cloud.com";
    private $port = "20110";
    private $database = "btaofpbbpl4d32s3d9sv";
    private $username = "u82dh03qjltvf6pl";
    private $password = "TkvJRG5kq5ppAwQLXcgs";
    private $charset = "utf8";

    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";port=" . $this->port . ";dbname=" . $this->database . ";charset=" . $this->charset;

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            // Registra el error en un archivo de registro o muestra un mensaje genérico
            error_log('Error de conexión a la base de datos: ' . $e->getMessage());
            // Muestra un mensaje genérico al usuario
            // Puedes personalizar este mensaje según tus necesidades
            die('Lo sentimos, se ha producido un error en la conexión a la base de datos.');
        }
    }
}

?>
