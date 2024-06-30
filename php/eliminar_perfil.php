<?php
$correo_recibido = $_POST['correo_recibido'];
$correo = $_POST['correo'];
$rut = $_POST['rut'];

include "db.php";

$db = new Database();
$con = $db->conectar();

if (!$con) {
    echo '
        <script>
            alert("Error en la conexión a la base de datos.");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
    ';
    exit;
}

$sql = "DELETE FROM Personal WHERE Rut = :rut AND Correo = :correo AND (Tipo_Cargo = 2 OR Tipo_Cargo = 3)";
$stmt = $con->prepare($sql);


if ($stmt === false) {
    echo '
        <script>
            alert("Error al preparar la consulta.");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
    ';
    exit;
}

$stmt->bindParam(':rut', $rut);
$stmt->bindParam(':correo', $correo);

if ($stmt->execute()) {
    if ($stmt->rowCount() > 0) {
        echo '
            <script>
                alert("El perfil ha sido eliminado correctamente.");
                window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
            </script>
        ';
        exit;
    } else {
        echo '
            <script>
                alert("No se encontró ningún perfil para eliminar.");
                window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
            </script>
        ';
        exit;
    }
} else {
    echo '
        <script>
            alert("Error al eliminar el perfil.");
            window.location = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
    ';
    exit;
}

$stmt->close();
$con->close();
?>
