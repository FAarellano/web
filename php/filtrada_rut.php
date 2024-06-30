<?php
    $rut = $_POST['rut'];
    $correo_recibido = $_POST['correo_recibido'];

    try {
        include "db.php";
        $db = new Database();
        $con = $db->conectar();

        // Consulta para obtener información básica del personal
        $stmt = $con->prepare("SELECT * FROM Personal WHERE Rut = :rut");
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $nombre = $result['PrimerNombre'];
            $apellido = $result['ApellidoPaterno'];
            $correo_perso = $result['Correo'];
            $cargo = $result['Tipo_Cargo'];
            $salario = $result['Salario'];
            $telefono = $result['TelefonoPersonal'];

            // Consulta para obtener ficha de emergencia
            $fi = $con->prepare("SELECT * FROM FichaEmergencia WHERE Rut_personal = :rut");
            $fi->bindParam(':rut', $rut, PDO::PARAM_STR);
            $fi->execute();
            $ficha_emergencia = $fi->fetch(PDO::FETCH_ASSOC);

            // Redireccionamiento con parámetros GET
            header("Location: ../HTML - Jefe RR.HH/busqueda_filtrada.php?telefono=$telefono&apellido=$apellido&nombre=$nombre&rut=$rut&correo_perso=$correo_perso&correo=$correo_recibido&cargo=$cargo&salario=$salario&ficha_emergencia=" . urlencode(json_encode($ficha_emergencia)));
            exit();
        } else {
            echo '
                <script>
                    alert("El Rut no está registrado");
                    window.location = "../HTML - Jefe RR.HH/busqueda_filtrada.php?correo=' . $correo_recibido . '";
                </script>
            ';
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
