<?php
session_start(); // Iniciar sesión si no se ha iniciado aún

$correo_recibido = $_POST['correo_recibido'];

include "db.php";

$db = new Database();
$con = $db->conectar();

// Obtener valores del formulario
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
$area = isset($_POST['area']) ? $_POST['area'] : '';
$sueldo_min = isset($_POST['sueldo_min']) ? $_POST['sueldo_min'] : '';
$sueldo_max = isset($_POST['sueldo_max']) ? $_POST['sueldo_max'] : '';

// Construir la consulta SQL base
$sql = "SELECT * FROM Personal WHERE 1=1";

// Aplicar filtros según los datos recibidos del formulario
if (!empty($sexo)) {
    $sql .= " AND Sexo = '$sexo'";
}

if (!empty($cargo)) {
    if ($cargo == '1') {
        $sql .= " AND Tipo_Cargo = '1'";
    } elseif ($cargo == '2') {
        $sql .= " AND Tipo_Cargo = '2'";
    } elseif ($cargo == '3') {
        $sql .= " AND Tipo_Cargo = '3'";
    }
}

if (!empty($departamento)) {
    $sql .= " AND ID_departamentos = $departamento";
}

if (!empty($area)) {
    $sql .= " AND ID_area = $area";
}

if (!empty($sueldo_min)) {
    $sql .= " AND Salario >= $sueldo_min";
}

if (!empty($sueldo_max)) {
    $sql .= " AND Salario <= $sueldo_max";
}

// Ejecutar la consulta SQL
$stmt = $con->query($sql);

// Guardar los resultados en una variable de sesión
$_SESSION['resultados_busqueda'] = [];

// Verificar si se encontraron resultados
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['resultados_busqueda'][] = $row;
    }
}

// Redirigir a otro archivo PHP para mostrar los resultados
header("Location: ../HTML - Jefe RR.HH/busqueda_filtrada.php?correo=$correo_recibido");
exit();
?>
