<?php
$correo_jefe = $_GET['correo_jefe']; // Asegúrate de validar y sanitizar esta entrada si es necesaria

// Incluir archivo de conexión a la base de datos
include "db.php";

try {
    // Conexión a la base de datos
    $db = new Database();
    $con = $db->conectar();

    // Verificar conexión
    if ($con === false) {
        throw new Exception("Error de conexión a la base de datos.");
    }

    // Obtener valores del formulario
    $rut = $_POST['rut'];
    $cargo = $_POST['cargo'];
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];

    // Verificar si algún campo está vacío
    if (empty($rut) || empty($cargo) || empty($correo) || empty($contrasena)) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Verificar si el RUT o el correo ya están registrados
    $check_existing_query = $con->prepare("SELECT Rut, Correo FROM Personal WHERE Rut = :rut OR Correo = :correo");
    $check_existing_query->bindParam(':rut', $rut);
    $check_existing_query->bindParam(':correo', $correo);
    $check_existing_query->execute();
    $resultado = $check_existing_query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Si el RUT está registrado, mostrar alerta y redirigir
        if ($rut == $resultado['Rut']) {
            echo '
                <script>
                    alert("El Rut ya está registrado");
                    window.location.href = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_jefe) . '";
                </script>
            ';
            exit;
        } 
        // Si el correo está registrado, mostrar alerta y redirigir
        elseif ($correo == $resultado['Correo']) {
            echo '
                <script>
                    alert("El Correo ya está registrado");
                    window.location.href = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_jefe) . '";
                </script>
            ';
            exit;
        }
    } else {
        // Generar hash seguro de la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $insert_user_query = $con->prepare("INSERT INTO Personal (Rut, Tipo_Cargo, Correo, Contraseña) VALUES (:rut, :cargo, :correo, :contrasena)");
        $insert_user_query->bindParam(':rut', $rut);
        $insert_user_query->bindParam(':cargo', $cargo);
        $insert_user_query->bindParam(':correo', $correo);
        $insert_user_query->bindParam(':contrasena', $hashed_password);

        if ($insert_user_query->execute()) {
            // Usuario registrado exitosamente
            echo '
                <script>
                    alert("Usuario registrado exitosamente");
                    alert("Recuerde Rellenar el Perfil en su menú principal");
                    window.location.href = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_jefe) . '";
                </script>
            ';
            exit;
        } else {
            // Error al registrar el usuario
            throw new Exception("Error al registrar el usuario.");
        }
    }
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo '
        <script>
            alert("Error: ' . $e->getMessage() . '");
        </script>
    ';
} finally {
    // Cerrar conexión
    if ($con) {
        $con = null;
    }
}
?>
