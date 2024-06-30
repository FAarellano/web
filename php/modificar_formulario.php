<?php

$rut = $_POST['rut'];

include "db.php";
$db = new Database();
$con = $db->conectar();

$sql = "UPDATE Personal SET ";
$params = array();

$campos_personales = array(
    'edad' => 'Edad',
    'telefono' => 'TelefonoPersonal',
    'direccion' => 'Direccion',
    'sexo' => 'Sexo',
    'region' => 'Region',
    'provincia' => 'Provincia',
    'comuna' => 'Comuna'
);

foreach ($campos_personales as $campo_post => $campo_bd) {
    if (isset($_POST[$campo_post]) && !empty($_POST[$campo_post])) {
        $sql .= "$campo_bd = :$campo_post, ";
        $params[":$campo_post"] = $_POST[$campo_post];
    }
}

$campos_previsiones = array(
    'prevision_social' => 'ID_prevision_social',
    'prevision_medica' => 'ID_prevision_medica',
);

foreach ($campos_previsiones as $campo_post => $campo_bd) {
    if (isset($_POST[$campo_post]) && !empty($_POST[$campo_post])) {
        $sql .= "$campo_bd = :$campo_post, ";
        $params[":$campo_post"] = $_POST[$campo_post];
    }
}

$sql = rtrim($sql, ', ');

$sql .= " WHERE Rut = :rut";
$params[':rut'] = $rut;

try {
    $stmt = $con->prepare($sql);

    foreach ($params as $key => &$value) {
        $stmt->bindParam($key, $value);
    }

    if ($stmt->execute()) {

        $rut_personal = $_POST['rut'];
        $nombre_contacto = $_POST['nombre_emergencia'];
        $telefono_emergencia = $_POST['telefono_emergencia'];
        $correo_emergencia = $_POST['correo_emergencia'];
        $relacion_trabajador = $_POST['relacion_emergencia'];

        // Verificar si ya existe una entrada en FichaEmergencia para este Rut
        $sql_verificar = "SELECT COUNT(*) AS count FROM FichaEmergencia WHERE Rut_personal = :rut_personal";
        $stmt_verificar = $con->prepare($sql_verificar);
        $stmt_verificar->bindParam(':rut_personal', $rut_personal);
        $stmt_verificar->execute();
        $result_verificar = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($result_verificar['count'] > 0) {
            // Si ya existe una entrada, actualizar los datos
            $sql_emergencia = "UPDATE FichaEmergencia SET 
                               NombreContactoEmergencia = :nombre_contacto,
                               TelefonoEmergencia = :telefono_emergencia,
                               CorreoEmergencia = :correo_emergencia,
                               RelacionTrabajador = :relacion_trabajador
                               WHERE Rut_personal = :rut_personal";

            $params_emergencia = array(
                ':rut_personal' => $rut_personal,
                ':nombre_contacto' => $nombre_contacto,
                ':telefono_emergencia' => $telefono_emergencia,
                ':correo_emergencia' => $correo_emergencia,
                ':relacion_trabajador' => $relacion_trabajador
            );

        } else {
            // Si no existe una entrada, insertar los datos
            $sql_emergencia = "INSERT INTO FichaEmergencia (Rut_personal, NombreContactoEmergencia, TelefonoEmergencia, CorreoEmergencia, RelacionTrabajador)
                               VALUES (:rut_personal, :nombre_contacto, :telefono_emergencia, :correo_emergencia, :relacion_trabajador)";

            $params_emergencia = array(
                ':rut_personal' => $rut_personal,
                ':nombre_contacto' => $nombre_contacto,
                ':telefono_emergencia' => $telefono_emergencia,
                ':correo_emergencia' => $correo_emergencia,
                ':relacion_trabajador' => $relacion_trabajador
            );
        }

        $stmt_emergencia = $con->prepare($sql_emergencia);

        foreach ($params_emergencia as $key => &$value) {
            $stmt_emergencia->bindParam($key, $value);
        }

        if ($stmt_emergencia->execute()) {

            // Verificar si se han proporcionado datos de cargas familiares
            if (isset($_POST['nombreCargaFamiliar']) && isset($_POST['rutCarga']) &&
                isset($_POST['parentesco']) && isset($_POST['sexoCarga'])) {

                $nombres_cargas = $_POST['nombreCargaFamiliar'];
                $ruts_cargas = $_POST['rutCarga'];
                $parentescos = $_POST['parentesco'];
                $sexos_cargas = $_POST['sexoCarga'];

                // Bucle para insertar cada carga familiar en la base de datos
                for ($i = 0; $i < count($nombres_cargas); $i++) {
                    // Verificar si hay valores vacíos en los datos de carga familiar
                    if (empty($nombres_cargas[$i]) && empty($ruts_cargas[$i]) &&
                        empty($parentescos[$i]) && empty($sexos_cargas[$i])) {
                        continue; // Saltar esta iteración si todos los campos están vacíos
                    }

                    $nombre_carga = !empty($nombres_cargas[$i]) ? $nombres_cargas[$i] : null;
                    $rut_carga = !empty($ruts_cargas[$i]) ? $ruts_cargas[$i] : null;
                    $parentesco = !empty($parentescos[$i]) ? $parentescos[$i] : null;
                    $sexo_carga = !empty($sexos_cargas[$i]) ? $sexos_cargas[$i] : null;

                    // Sentencia SQL para la inserción de cada carga familiar
                    $sql_carga = "INSERT INTO CargaFamiliar (Rut, Nom_cargaFamiliar, Rut_cargaFamiliar, Parentesco_cargaFamiliar, Sexo_cargaFamiliar)
                                  VALUES (:rut_personal, :nombre_carga, :rut_carga, :parentesco, :sexo_carga)";

                    $params_carga = array(
                        ':rut_personal' => $rut,
                        ':nombre_carga' => $nombre_carga,
                        ':rut_carga' => $rut_carga,
                        ':parentesco' => $parentesco,
                        ':sexo_carga' => $sexo_carga
                    );

                    $stmt_carga = $con->prepare($sql_carga);

                    foreach ($params_carga as $key => &$value) {
                        $stmt_carga->bindParam($key, $value);
                    }

                    // Ejecutar la consulta de inserción de carga familiar
                    if (!$stmt_carga->execute()) {
                        throw new Exception("Error al insertar carga familiar.");
                    }
                }

                // Mostrar mensaje de éxito y redireccionar
                echo '
                    <script>
                        alert("Datos personales, de emergencia y cargas familiares modificados correctamente.");
                        window.location.href = "../index.html";
                    </script>
                    ';
                exit;

            } else {
                // Si no se han proporcionado datos de cargas familiares, continuar sin realizar ninguna acción
                echo '
                    <script>
                        alert("Datos personales y de emergencia modificados correctamente. No se han proporcionado datos de cargas familiares.");
                        window.location.href = "../index.html";
                    </script>
                    ';
                exit;
            }
        } else {
            echo '
                <script>
                    alert("Error al modificar datos de emergencia.");
                    window.location.href = "../index.html";
                </script>
                ';
            exit;
        }
    } else {
        echo '
            <script>
                alert("Error al modificar datos personales.");
                window.location.href = "../index.html";
            </script>
            ';
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
