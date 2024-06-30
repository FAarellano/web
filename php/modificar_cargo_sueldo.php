<?php
$rut = $_POST['rut'];
$correo_recibido = $_POST['correo_recibido'];
$new_salario = $_POST['new_salario'];
$new_cargo = $_POST['new_cargo'];

include "db.php";

$db = new Database();
$con = $db->conectar();

// Verificar si ya existe un registro con ese rut
$sql_check = "SELECT * FROM Personal WHERE Rut = :rut";
$stmt_check = $con->prepare($sql_check);
$stmt_check->bindParam(':rut', $rut);
$stmt_check->execute();

if ($stmt_check->rowCount() > 0) {
    // Si existe, actualizar el registro
    $sql_update = "UPDATE Personal SET 
                    Salario = :salario,
                    Tipo_Cargo = :cargo
                    WHERE Rut = :rut";

    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':salario', $new_salario, PDO::PARAM_INT);
    $stmt_update->bindParam(':cargo', $new_cargo, PDO::PARAM_INT);
    $stmt_update->bindParam(':rut', $rut);

    if ($stmt_update->execute()) {
        echo '
        <script>
            alert("Registro actualizado correctamente");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;
    } else {
        echo '
        <script>
            alert("Error al actualizar el registro");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;
    }
} else {
    echo '
        <script>
            alert("El Rut ingresado no tiene un Perfil existente");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
    ';
    exit;
}

$con = null; // Cerrar conexión
?>