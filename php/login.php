<?php

include "../db.php";

$db = new Database();

$con = $db->conectar();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];


$validar_login = $con->prepare("SELECT * FROM login WHERE usuario = :usuario AND contraseña = :contrasena");
$validar_login->bindParam(':usuario', $usuario);
$validar_login->bindParam(':contrasena', $contrasena);
$validar_login->execute();

if($validar_login->rowCount() > 0){
    header("location: ../HTML - Jefe RR.HH/menu_jefe.html");
    exit;
}else{
    echo '
        <script>
            alert("Usuario no existe, verifique los datos ingresados")
            window.location = "../index.html"
        </script>
    ';
    exit;
}

?>