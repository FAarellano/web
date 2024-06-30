<?php

$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$rut = $_POST['rut'];

// Incluir archivo de conexión a la base de datos
include "db.php";

try {
    // Conexión a la base de datos
    $db = new Database();
    $con = $db->conectar();

    // Verificar conexión
    if ($con === false) {
        die("Error de conexión: " . $db->error());
    }

    // Consulta para obtener el registro del usuario por Rut
    $consulta = $con->prepare("SELECT Correo, Contraseña FROM Personal WHERE Rut = :rut");
    $consulta->bindParam(':rut', $rut);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el usuario
    if ($resultado) {
        // Verificar que el correo coincida
        if ($resultado['Correo'] === $correo) {
            $nueva = rand(1000, 9999);
            // Aquí puedes proceder a cambiar la contraseña
            // Ejemplo de cambio de contraseña (generación de hash)
            $nueva_contraseña = $nueva; // Aquí deberías obtener la nueva contraseña del formulario
            $hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $actualizar_contraseña = $con->prepare("UPDATE Personal SET Contraseña = :hashed_password WHERE Rut = :rut");
            $actualizar_contraseña->bindParam(':hashed_password', $hashed_password);
            $actualizar_contraseña->bindParam(':rut', $rut);

            if ($actualizar_contraseña->execute()) {
                echo '
                    <script>
                        alert("Excelente, Nueva contraseña: ' . $nueva_contraseña . '");
                        alert("Recuerde cambiar la contraseña en el menú principal");
                        window.location.href = "../index.html";
                    </script>
                ';
                exit;
            } else {
                echo '
                    <script>
                        alert("Error al cambiar la contraseña");
                        window.location.href = "../index.html";
                    </script>
                ';
                exit;
            }
        } else {
            echo '
                <script>
                    alert("Los datos ingresados no coinciden con los registrados.");
                    window.location.href = "../index.html";
                </script>
            ';
            exit;
        }
    } else {
        echo '
            <script>
                alert("No se encontró el usuario con el RUT proporcionado.");
                window.location.href = "../index.html";
            </script>
        ';
        exit;
    }
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos: " . $e->getMessage();
} finally {
    // Cerrar conexión
    if ($con) {
        $con = null;
    }
}
?>
