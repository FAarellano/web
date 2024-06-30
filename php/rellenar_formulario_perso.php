<?php
// Recibir el parámetro 'correo' desde la URL
$correo_recibido = isset($_GET['correo']) ? $_GET['correo'] : null;

// Verificar si se recibió el parámetro 'correo'
if (!$correo_recibido) {
    echo "No se proporcionó el correo del usuario.";
    exit; // Importante salir del script si no se encuentra el correo
}


include "db.php"; // Asumiendo que db.php contiene la lógica de conexión a la base de datos

// Conexión a la base de datos
$db = new Database();
$con = $db->conectar();

$rut = $_POST['rut'];
$primer_nombre = $_POST['primer_nombre'];
$segundo_nombre = $_POST['segundo_nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$sexo = $_POST['sexo'];
$direccion = $_POST['direccion'];
$region = $_POST['region'];
$provincia = $_POST['provincia'];
$comuna = $_POST['comuna'];
$departamento = $_POST['departamento'];
$area = $_POST['area'];
$salario = $_POST['salario'];
$fecha_contratacion = $_POST['fecha_contratacion'];
$termino_contrato = $_POST['termino_contrato'];
$prevision_social = $_POST['prevision_social'];
$prevision_medica = $_POST['prevision_medica'];

// Verificar si ya existe un registro con ese rut
$sql_check = "SELECT * FROM Personal WHERE Rut = :rut";
$stmt_check = $con->prepare($sql_check);
$stmt_check->bindParam(':rut', $rut);
$stmt_check->execute();

if ($stmt_check->rowCount() > 0) {
    // Si existe, actualizar el registro
    $sql_update = "UPDATE Personal SET 
                    PrimerNombre = :primer_nombre,
                    SegundoNombre = :segundo_nombre,
                    ApellidoPaterno = :apellido_paterno,
                    ApellidoMaterno = :apellido_materno,
                    Edad = :edad,
                    TelefonoPersonal = :telefono,
                    Sexo = :sexo,
                    Direccion = :direccion,
                    Region = :region,
                    Provincia = :provincia,
                    Comuna = :comuna,
                    ID_departamentos = :departamento,
                    ID_area = :area,
                    Salario = :salario,
                    FechaContratacion = :fecha_contratacion,
                    FechaTerminoContrato = :termino_contrato,
                    ID_prevision_social = :prevision_social,
                    ID_prevision_medica = :prevision_medica
                    WHERE Rut = :rut";

    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':primer_nombre', $primer_nombre);
    $stmt_update->bindParam(':segundo_nombre', $segundo_nombre);
    $stmt_update->bindParam(':apellido_paterno', $apellido_paterno);
    $stmt_update->bindParam(':apellido_materno', $apellido_materno);
    $stmt_update->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt_update->bindParam(':telefono', $telefono);
    $stmt_update->bindParam(':sexo', $sexo);
    $stmt_update->bindParam(':direccion', $direccion);
    $stmt_update->bindParam(':region', $region);
    $stmt_update->bindParam(':provincia', $provincia);
    $stmt_update->bindParam(':comuna', $comuna);
    $stmt_update->bindParam(':departamento', $departamento);
    $stmt_update->bindParam(':area', $area);
    $stmt_update->bindParam(':salario', $salario, PDO::PARAM_INT);
    $stmt_update->bindParam(':fecha_contratacion', $fecha_contratacion);
    $stmt_update->bindParam(':termino_contrato', $termino_contrato);
    $stmt_update->bindParam(':prevision_social', $prevision_social);
    $stmt_update->bindParam(':prevision_medica', $prevision_medica);
    $stmt_update->bindParam(':rut', $rut);

    if ($stmt_update->execute()) {
        echo '
        <script>
            alert("Registro actualizado correctamente");
            window.location = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;
    } else {
        echo '
        <script>
            alert("Error al actualizar el registro: ");
            window.location = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;
    }
} else {
    echo '
        <script>
            alert("El Rut ingresado no tiene un Perfil existente");
            window.location = "../HTML - Personal RR.HH/menu_personal.php?correo=' . urlencode($correo_recibido) . '";
        </script>
        ';
        exit;

    
}

$con = null; // Cerrar conexión
?>
