<?php
$correo_recibido = $_GET['correo'];

include "../php/db.php";

$db = new Database();
$con = $db->conectar();

$sql = "SELECT Nombre_region FROM Region";
$stmt = $con->query($sql);

$regiones = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $regiones[] = $row;
    }
}


$sql = "SELECT Nombre_provincia FROM Provincia";
$stmt = $con->query($sql);

$provincias = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $provincias[] = $row;
    }
}

$sql = "SELECT Nombre_comuna FROM Comuna";
$stmt = $con->query($sql);

$comunas = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $comunas[] = $row;
    }
}

$sql = "SELECT ID_area, NombreArea FROM Area";
$stmt = $con->query($sql);

$areas = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $areas[] = $row;
    }
}

$sql = "SELECT ID_departamento, NombreDepartamento FROM Departamento";
$stmt = $con->query($sql);

$departamentos = array();

if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $departamentos[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_crear_perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Rellenar Formulario: Personal RR.HH</title>
</head>
<body>
    <!--INICIO NAVBAR-->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
              <a id="logo" class="navbar-brand" href="#"><img src="../images/Correos-Logo-1977.png" alt="" width=70px></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="volver" class="btn btn-outline-warning" aria-current="page" href="menu_jefe.php?correo=<?php echo $correo_recibido ?>">Regresar</a>
                    </li>
                    <h4 id="title_navbar">Rellenar Formulario: Personal RR.HH</h4>
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

    <form action="../php/rellenar_formulario.php?correo=<?php echo $correo_recibido ?>" method="POST">
        <!--INICIO BODY-->

            <div class="row">

                <div class="col">
                    <div class="card mb-3 card-form" style="max-width: 30rem;">
                        <div class="card-body">
                            <!-- Datos Personales a rellenar -->
                            <h3>Rut del Perfil a Rellenar:</h3>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRelleRut" placeholder="rut" name="rut" required>
                                        <label for="floatingRelleRut">Rut</label>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h4>Complete el Formulario</h4>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRellePrimerNombre" placeholder="primerNombre" name="primer_nombre" required>
                                        <label for="floatingRellePrimerNombre">Primer Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRelleSegundoNombre" placeholder="segundoNombre" name="segundo_nombre" required>
                                        <label for="floatingRelleSegundoNombre">Segundo Nombre</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRelleApellidoPaterno" placeholder="apellidoPaterno" name="apellido_paterno" required>
                                        <label for="floatingRelleApellidoPaterno">Apellido Paterno</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRelleApellidoMaterno" placeholder="apellidoMaterno" name="apellido_materno" required>
                                        <label for="floatingRelleApellidoMaterno">Apellido Materno</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingRelleEdad" placeholder="edad" name="edad" required>
                                        <label for="floatingRelleEdad">Edad</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingRelleTelefono" placeholder="telefono" name="telefono"required>
                                        <label for="floatingRelleTelefono">Teléfono</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                        <select class="form-control select mb-3" name="sexo">
                                            <option value="value0" selected disabled>Sexo</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRelleDireccion" placeholder="direccion" name="direccion" required>
                                        <label for="floatingRelleDireccion">Dirección Hogar</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <input type="text" id="searchRegion" class="form-control mb" onkeyup="filterRegions()" placeholder="Buscar región por nombre...">

                                    <select id="selectRegion" class="form-control select mb-5" name="region" required>
                                        <option value="" selected disabled>Selecciona una región</option>
                                        <?php
                                        foreach ($regiones as $region) {
                                            echo "<option value='" . $region['Nombre_region'] . "'>" . $region['Nombre_region'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <script>
                                    function filterRegions() {
                                        var input, filter, select, option, i;
                                        input = document.getElementById("searchRegion");
                                        filter = input.value.toUpperCase();
                                        select = document.getElementById("selectRegion");
                                        option = select.getElementsByTagName("option");

                                        for (i = 0; i < option.length; i++) {
                                            let txtValue = option[i].textContent || option[i].innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                option[i].style.display = "";
                                                if (!select.value || option[i].value === select.value) {
                                                    select.value = option[i].value; // Seleccionar automáticamente al encontrar coincidencia
                                                }
                                            } else {
                                                option[i].style.display = "none";
                                            }
                                        }
                                    }
                                </script>


                                <div class="col-12">
                                    <input type="text" id="searchProvincia" class="form-control mb" onkeyup="filterProvincias()" placeholder="Buscar provincia por nombre...">

                                    <select id="selectProvincia" class="form-control select mb-5" name="provincia" required>
                                        <option value="" selected disabled>Selecciona una provincia</option>
                                        <?php
                                        foreach ($provincias as $provincia) {
                                            echo "<option value='" . $provincia['Nombre_provincia'] . "'>" . $provincia['Nombre_provincia'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <script>
                                    function filterProvincias() {
                                        var input, filter, select, option, i;
                                        input = document.getElementById("searchProvincia");
                                        filter = input.value.toUpperCase();
                                        select = document.getElementById("selectProvincia");
                                        option = select.getElementsByTagName("option");

                                        for (i = 0; i < option.length; i++) {
                                            let txtValue = option[i].textContent || option[i].innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                option[i].style.display = "";
                                                if (!select.value || option[i].value === select.value) {
                                                    select.value = option[i].value; // Seleccionar automáticamente al encontrar coincidencia
                                                }
                                            } else {
                                                option[i].style.display = "none";
                                            }
                                        }
                                    }
                                </script>


                                <div class="col-12">
                                    <input type="text" id="searchComuna" class="form-control mb" onkeyup="filterComunas()" placeholder="Buscar comuna por nombre...">

                                    <select id="selectComuna" class="form-control select mb-5" name="comuna" required>
                                        <option value="" selected disabled>Selecciona una comuna</option>
                                        <?php
                                        foreach ($comunas as $comuna) {
                                            echo "<option value='" . $comuna['Nombre_comuna'] . "'>" . $comuna['Nombre_comuna'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <script>
                                    function filterComunas() {
                                        var input, filter, select, option, i;
                                        input = document.getElementById("searchComuna");
                                        filter = input.value.toUpperCase();
                                        select = document.getElementById("selectComuna");
                                        option = select.getElementsByTagName("option");

                                        for (i = 0; i < option.length; i++) {
                                            let txtValue = option[i].textContent || option[i].innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                option[i].style.display = "";
                                                if (!select.value || option[i].value === select.value) {
                                                    select.value = option[i].value; // Seleccionar automáticamente al encontrar coincidencia
                                                }
                                            } else {
                                                option[i].style.display = "none";
                                            }
                                        }
                                    }
                                </script>
                                
                            
                            </div>
                            <!-- Fin Datos Personales -->

                            <!-- Datos Laborales a rellenar -->
                            <h3>Datos Laborales</h3>
                            <div class="row">

                            <div class="col-12">
                                        <select class="form-control select mb-3" name="departamento">
                                            <option value="value0" selected disabled>Departamento</option>
                                            <?php
                                            foreach ($departamentos as $departamento) {
                                                echo "<option value='" . $departamento['ID_departamento'] . "'>" . $departamento['NombreDepartamento'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                </div>

                            <div class="col-12">
                                        <select class="form-control select mb-3" name="area">
                                            <option value="0" selected disabled>Area</option>
                                            <?php
                                            foreach ($areas as $area) {
                                                echo "<option value='" . $area['ID_area'] . "'>" . $area['NombreArea'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                </div>


                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingRelleSalario" placeholder="salario" name="salario"required>
                                        <label for="floatingRelleSalario">Salario</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Datos Laborales -->

                            <!-- Fecha Contratación a rellenar -->
                            <h3>Fecha de Contratación</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="floatingRelleFechaContratac" placeholder="fechaContratacion" name="fecha_contratacion" required>
                                        <label for="floatingRelleFechaContratac">Fecha Contratación</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="floatingRelleFechaTerminoContrato" placeholder="fechaTerminoContrato" name="termino_contrato" required>
                                        <label for="floatingRelleFechaTerminoContrato">Termino Contrato</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Fecha Contratación -->

                            <!-- Previsiones  -->
                            <h3>Previsiones</h3>
                            <div class="row">
                            <div class="col-12">
                                        <select class="form-control select mb-3" name="prevision_social">
                                            <option value="value0" selected disabled>Prevision Social</option>
                                            <option value="1">AFP Capital</option>
                                            <option value="2">AFP Modelo</option>
                                            <option value="3">AFP Cuprum</option>
                                            <option value="4">AFP Plan Vital</option>
                                            <option value="5">AFP Habitat</option>
                                            <option value="6">AFP ProVida</option>
                                            <option value="7">IPS (Sistema antiguo)</option>
                                            <option value="8">DIPRECA/CAPREDENA (Fuerzas Armadas)</option>
                                        </select>
                                </div>

                                <div class="col-12">
                                        <select class="form-control select mb-3" name="prevision_medica">
                                            <option value="value0" selected disabled>Prevision Médica</option>
                                            <option value="1">FONASA</option>
                                            <option value="2">ISAPRE</option>
                                        </select>
                                </div>
                            </div>
                            <!-- Fin Previsiones -->

                            <button type="submit" class="btn btn-primary">Enviar Formulario</button>

                        </div>

                    </div>
                </div>

            </div>



        </div>

        <!--FINAL BODY-->
    </form>
</body>
</html>

