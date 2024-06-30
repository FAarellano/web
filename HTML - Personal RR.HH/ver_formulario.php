<?php
$rut_recibido = $_GET['rut'];

include "../php/db.php";

$db = new Database();
$con = $db->conectar();

$llamar_cargas_familiares = $con->prepare("SELECT * FROM CargaFamiliar WHERE Rut = :rut");
$llamar_cargas_familiares->bindParam(':rut', $rut_recibido);
$llamar_cargas_familiares->execute();

$llamar_formulario = $con->prepare("SELECT * FROM Personal WHERE Rut = :rut_recibido");
$llamar_formulario->bindParam(':rut_recibido', $rut_recibido);
$llamar_formulario->execute();

if ($llamar_formulario->rowCount() > 0) {

    $fila = $llamar_formulario->fetch(PDO::FETCH_ASSOC);

    $correo = $fila['Correo'];
    $primer_nombre = $fila['PrimerNombre'];
    $segundo_nombre = $fila['SegundoNombre'];
    $primer_apellido = $fila['ApellidoPaterno'];
    $segundo_apellido = $fila['ApellidoMaterno'];
    $salario = $fila['Salario'];
    $telefono_personal = $fila['TelefonoPersonal'];
    $direccion = $fila['Direccion'];
    $numero_contrato = $fila['NumeroContrato'];
    $fecha_contratacion = $fila['FechaContratacion'];
    $fecha__termino_contrato = $fila['FechaTerminoContrato'];
    $sexo = $fila['Sexo'];
    $num_cargo = $fila['Tipo_Cargo'];
    $region = $fila['Region'];
    $provincia = $fila['Provincia'];
    $comuna = $fila['Comuna'];

    $cargo = "NULL";
    if($num_cargo == 1){
        $cargo = "Jefe RR.HH";
    }
    if($num_cargo == 2){
        $cargo = "Personal RR.HH";
    }
    if($num_cargo == 3){
        $cargo = "Trabajador";
    }
} else {
    echo "Error al ejecutar la consulta: " . $llamar_formulario->errorInfo()[2];
}

$llamar_area = $con->prepare("SELECT Personal.ID_area, Area.NombreArea AS nombre_area
                                    FROM Personal
                                    INNER JOIN Area ON Personal.ID_area = Area.ID_area
                                    WHERE Rut = :rut");
$llamar_area->bindParam(':rut', $rut_recibido);
$llamar_area->execute();
$resultado_area = $llamar_area->fetch(PDO::FETCH_ASSOC);

if ($resultado_area) {
    $area = $resultado_area['nombre_area'];
} else {
    $area = "Área no encontrada";
}

$llamar_departamento = $con->prepare("SELECT Departamento.ID_departamento, Departamento.NombreDepartamento AS nombre_departamento
FROM Personal
INNER JOIN Departamento ON Personal.ID_departamentos = Departamento.ID_departamento
WHERE Personal.Rut = :rut
");
$llamar_departamento->bindParam(':rut', $rut_recibido);
$llamar_departamento->execute();
$resultado_departamento = $llamar_departamento->fetch(PDO::FETCH_ASSOC);

if ($resultado_departamento) {
    $departamento = $resultado_departamento['nombre_departamento'];
} else {
    $departamento = "Departamento no encontrada";
}

$llamar_prevision_medica = $con->prepare("SELECT `PrevisionMedica`.ID_prevision_medica, `PrevisionMedica`.NombrePrevision AS nombre_prevision_medica
FROM Personal
INNER JOIN `PrevisionMedica` ON Personal.ID_prevision_medica = `PrevisionMedica`.ID_prevision_medica
WHERE Personal.Rut = :rut");


$llamar_prevision_medica->bindParam(':rut', $rut_recibido);
$llamar_prevision_medica->execute();
$resultado_prevision_medica = $llamar_prevision_medica->fetch(PDO::FETCH_ASSOC);

if ($resultado_prevision_medica) {
    $prevision_medica = $resultado_prevision_medica['nombre_prevision_medica'];
} else {
    $prevision_medica = "Previsión médica no encontrada";
}

$llamar_prevision_social = $con->prepare("SELECT PrevisionSocial.ID_prevision_social, PrevisionSocial.NombrePrevision AS nombre_prevision_social
FROM Personal
INNER JOIN PrevisionSocial ON Personal.ID_prevision_social = PrevisionSocial.ID_prevision_social
WHERE Personal.Rut = :rut");

$llamar_prevision_social->bindParam(':rut', $rut_recibido);
$llamar_prevision_social->execute();
$resultado_prevision_social = $llamar_prevision_social->fetch(PDO::FETCH_ASSOC);

if ($resultado_prevision_social) {
    $prevision_social = $resultado_prevision_social['nombre_prevision_social'];
} else {
    $prevision_social = "Previsión social no encontrada";
}

$fi = $con->prepare("SELECT * FROM FichaEmergencia WHERE Rut_personal = :rut");
$fi->bindParam(':rut', $rut_recibido, PDO::PARAM_STR);  // Aquí debe ser $rut_recibido en lugar de $rut
$fi->execute();
$ficha_emergencia = $fi->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_crear_perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Ver mi Formulario</title>
</head>

<body>
    <!--INICIO NAVBAR-->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a id="logo" class="navbar-brand" href="#"><img src="../images/Correos-Logo-1977.png" alt=""
                        width=70px></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a id="volver" class="btn btn-outline-warning" aria-current="page"
                                href="menu_personal.php?correo=<?php echo $correo ?>">Regresar</a>
                        </li>
                        <h4 id="title_navbar">Ver mi Formulario</h4>
                    </ul>
                </div>
            </div>
            <a href="../index.html"><button id="cerrar" type="button" class="btn btn-outline-danger">Logout</button></a>
        </nav>
    </header>
    <!--FINAL NAVBAR-->

    <!--Logo Superior-->
    <div class="container text-center">
        <div class="row-5">
            <div class="col-12">
                <br>
                <img id="logo_index" src="../images/Correos-Logo-1977.png" alt="" width="200px">
                <p id="titulo_logo">El Correo de Yury</p>
            </div>
        </div>
    </div>
    <!--Logo Superior-->


    <!--INICIO BODY-->

    <div id="titulo_seleccion">
        Formulario de "<?php echo $primer_nombre . " " . $primer_apellido ?>"
    </div><br>


    <div class="container">
        <div class="col ">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Dato</th>
                        <th scope="col">Resultado</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                    <tr>
                        <td>Número de Contrato</td>
                        <td><?php echo $numero_contrato ?></td>
                    </tr>

                    <tr>
                        <td>Rut</td>
                        <td><?php echo $rut_recibido ?></td>
                    </tr>

                    <tr>
                        <td>Cargo</td>
                        <td><?php echo $cargo ?></td>
                    </tr>

                    <tr>
                        <td>Primer Nombre</td>
                        <td><?php echo $primer_nombre ?></td>
                    </tr>

                    <tr>
                        <td>Segundo Nombre</td>
                        <td><?php echo $segundo_nombre ?></td>
                    </tr>

                    <tr>
                        <td>Apellido Paterno</td>
                        <td><?php echo $primer_apellido ?></td>
                    </tr>

                    <tr>
                        <td>Apellido Materno</td>
                        <td><?php echo $segundo_apellido ?></td>
                    </tr>

                    <tr>
                        <td>Correo</td>
                        <td><?php echo $correo ?></td>
                    </tr>

                    <tr>
                        <td>Sexo</td>
                        <td><?php echo $sexo ?></td>
                    </tr>

                    <tr>
                        <td>Previsión Medica</td>
                        <td><?php echo $prevision_medica ?></td>
                    </tr>

                    <tr>
                        <td>Previsión Social</td>
                        <td><?php echo $prevision_social ?></td>
                    </tr>

                    <tr>
                        <td>Área</td>
                        <td><?php echo $area ?></td>
                    </tr>

                    <tr>
                        <td>Departamento</td>
                        <td><?php echo $departamento ?></td>
                    </tr>

                    <tr>
                        <td>Telefono Personal</td>
                        <td><?php echo $telefono_personal ?></td>
                    </tr>

                    <tr>
                        <td>Dirección</td>
                        <td><?php echo $direccion ?></td>
                    </tr>

                    <tr>
                        <td>Región</td>
                        <td><?php echo $region ?></td>
                    </tr>

                    <tr>
                        <td>Provincia</td>
                        <td><?php echo $provincia ?></td>
                    </tr>

                    <tr>
                        <td>Comuna</td>
                        <td><?php echo $comuna ?></td>
                    </tr>

                    <tr>
                        <td>Salario</td>
                        <td><?php echo $salario ?></td>
                    </tr>

                    <tr>
                        <td>Fecha Contratación</td>
                        <td><?php echo $fecha_contratacion ?></td>
                    </tr>

                    <tr>
                        <td>Fecha Termino de Contrato</td>
                        <td><?php echo $fecha__termino_contrato ?></td>
                    </tr>

                    <tr>
                        <td>Ficha Emergencia</td>
                        <td>
                            <?php
                            if ($ficha_emergencia) {
                                echo "Nombre: " . $ficha_emergencia['NombreContactoEmergencia'] . "<br>";
                                echo "Contacto: " . $ficha_emergencia['TelefonoEmergencia'] . "<br>";
                                echo "Correo: " . $ficha_emergencia['CorreoEmergencia'] . "<br>";
                                // Agrega más campos de la ficha de emergencia si es necesario
                            } else {
                                echo "No hay ficha de emergencia disponible";
                            }
                            ?>
                        </td>
                    <tr>
                        <td colspan="2" class="table-secondary"><strong>Cargas Familiares</strong></td>
                    </tr>
                    <?php while ($fila_carga = $llamar_cargas_familiares->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td>Nombre Carga</td>
                        <td><?php echo $fila_carga['Nom_cargaFamiliar']; ?></td>
                    </tr>
                    <tr>
                        <td>Parentesco</td>
                        <td><?php echo $fila_carga['Parentesco_cargaFamiliar']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>

        </div>
    </div>

    <!--FINAL BODY-->
</body>

</html>
