<?php
// Verificar si se ha enviado el formulario con método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el RUT ingresado desde el formulario
    $rut = $_POST['rut'];
    $correo_recibido = $_POST['correo_recibido']; // Agrega un punto y coma aquí

    try {
        include "db.php";
        $db = new Database();
        $con = $db->conectar();

        // Preparar la consulta SQL utilizando una consulta preparada
        $stmt = $con->prepare("SELECT Tipo_Cargo, Salario FROM Personal WHERE Rut = :rut");

        // Vincular el parámetro :rut con el valor de $rut
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron resultados
        if ($result !== false) {
            // Obtener los datos del resultado
            $Tipo_Cargo = $result['Tipo_Cargo'];
            $Salario = $result['Salario'];

            // Redirigir con los datos obtenidos
            header("Location: ../HTML - Jefe RR.HH/modificar_cargos_sueldos.php?rut=$rut&correo=$correo_recibido&cargo=$Tipo_Cargo&salario=$Salario");
            exit(); // Aseguramos que el script se detenga aquí
        } else {
            // Mostrar mensaje si no se encontró el RUT en la tabla
            echo '
                <script>
                    alert("El Rut no está registrado");
                    window.location = "../HTML - Jefe RR.HH/modificar_cargos_sueldos.php?correo=' . $correo_recibido . '";
                </script>
            ';
            exit(); // Aseguramos que el script se detenga aquí
        }
    } catch(PDOException $e) {
        // Mostrar mensaje de error si ocurre un problema con la conexión o la consulta
        echo "Error: " . $e->getMessage();
    }
}
?>
