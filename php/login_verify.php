<?php
include "../php/db.php";

// Conexión a la base de datos
$db = new Database();
$con = $db->conectar();

// Obtener correo y contraseña del formulario
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
$contraseña = $_POST['contrasena'];
$cargo_seleccionado = $_POST['cargo_seleccionado']; // Este valor debe provenir del formulario

// Verificar si el correo, contraseña y tipo de cargo no están vacíos
if (empty($correo) || empty($contraseña) || empty($cargo_seleccionado)) {
    echo '
        <script>
            alert("Por favor, ingrese correo y contraseña");
            window.location = "../index.html";
        </script>
    ';
    exit;
}

// Consulta preparada para obtener el hash de la contraseña asociada al correo
$validar_login = $con->prepare("SELECT Tipo_Cargo, Contraseña FROM Personal WHERE Correo = :correo");
$validar_login->bindParam(':correo', $correo);
$validar_login->execute();
$resultado = $validar_login->fetch(PDO::FETCH_ASSOC);

if ($validar_login->rowCount() > 0) {
    // Verificar si la contraseña ingresada coincide con el hash almacenado
    if (password_verify($contraseña, $resultado['Contraseña'])) {
        if ($resultado['Tipo_Cargo'] == $cargo_seleccionado) {
            switch ($resultado['Tipo_Cargo']) {
                case 1:
                    header("Location: ../HTML - Jefe RR.HH/menu_jefe.php?correo=$correo");
                    exit;
                case 2:
                    header("Location: ../HTML - Personal RR.HH/menu_personal.php?correo=$correo");
                    exit;
                case 3:
                    header("Location: ../HTML - Trabajador/menu_trabajador.php?correo=$correo");
                    exit;
                default:
                    echo '
                    <script>
                        alert("Error en el cargo en la BD, verifique que Tipo_Cargo sea del 1 al 3");
                        window.location = "../index.html";
                    </script>
                    ';
                    break;
            }
        } else {
            // El tipo de cargo no coincide
            echo '
                <script>
                    alert("El tipo de cargo seleccionado no coincide con el registrado");
                    window.location = "../index.html";
                </script>
            ';
            exit;
        }
    } else {
        // Contraseña incorrecta
        echo '
            <script>
                alert("Contraseña incorrecta");
                window.location = "../index.html";
            </script>
        ';
        exit;
    }
} else {
    // Correo no encontrado en la base de datos
    echo '
        <script>
            alert("Correo no existe");
            window.location = "../index.html";
        </script>
    ';
    exit;
}
?>
