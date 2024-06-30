<?php
if (isset($_GET['correo'])) {
    $correo_recibido = $_GET['correo'];
} else {
    echo '
        <script>
            alert("No se recibió el correo.");
            window.location.href = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;
}



if (isset($_POST['nueva_pass1']) && isset($_POST['nueva_pass2'])) {
    $new_pass1 = $_POST['nueva_pass1'];
    $new_pass2 = $_POST['nueva_pass2'];


    if ($new_pass1 != $new_pass2) {
        echo '
        <script>
            alert("Las contraseñas ingresadas no coinciden.");
            window.location.href = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;

    }
    


    $hashed_password = password_hash($new_pass1, PASSWORD_DEFAULT);


    include "db.php";


    $db = new Database();
    $con = $db->conectar();

    if ($con === false) {
        die("Error de conexión: " . $db->error());
    }


    $llamar_formulario = $con->prepare("SELECT Rut, Contraseña FROM Personal WHERE Correo = :correo_recibido");
    $llamar_formulario->bindParam(':correo_recibido', $correo_recibido);
    $llamar_formulario->execute();


    if ($llamar_formulario->rowCount() > 0) {
        $fila = $llamar_formulario->fetch(PDO::FETCH_ASSOC);
        $contraseña_actual = $fila['Contraseña'];
        $rut_recibido = $fila['Rut'];


        if (password_verify($new_pass1, $contraseña_actual)) {
            echo '
            <script>
                alert("La nueva contraseña no puede ser igual a la actual.");
                window.location.href = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
            </script>
            ';
            exit; 
        }


        $actualizar_contraseña = $con->prepare("UPDATE Personal SET Contraseña = :hashed_password WHERE Rut = :rut_recibido");
        $actualizar_contraseña->bindParam(':hashed_password', $hashed_password);
        $actualizar_contraseña->bindParam(':rut_recibido', $rut_recibido);

        if ($actualizar_contraseña->execute()) {
            echo '
            <script>
                alert("¡Contraseña cambiada exitosamente!.");
                window.location.href = "../index.html";
            </script>
            ';
            exit; 
        } else {
            echo '
            <script>
                alert("Error al cambiar la contraseña.");
                window.location.href = "../index.html";
            </script>
            ';
            exit; 
        }
    } else {
        echo '
        <script>
            alert("No se encontró el usuario");
            window.location.href = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit; 
    }


    $con = null;
} else {
    echo '
        <script>
            alert("Las contraseñas no fueron proporcionadas correctamente.");
            window.location.href = "../HTML - Jefe RR.HH/menu_jefe.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit; 
}
?>
