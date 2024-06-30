<?php
$correo_recibido = $_GET['correo'];

include "../php/db.php";

$db = new Database();
$con = $db->conectar();

//BUSQUEDA POR RUT
$correo_perso= $_GET['correo_perso'];
$rut = $_GET['rut'];
$cargo = $_GET['cargo'];
    if($cargo == 1){
        $cargo = "Jefe RR.HH";
    }
    if($cargo == 2){
        $cargo = "Personal RR.HH";
    }
    if($cargo == 3){
        $cargo = "Trabajador";
    }
$salario = $_GET['salario'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
$telefono = $_GET['telefono'];

$ficha_emergencia = isset($_GET['ficha_emergencia']) ? json_decode($_GET['ficha_emergencia'], true) : null;

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

session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <style>
    /* Estilos adicionales para personalizar la tabla */
    .table-responsive {
      max-height: 200px; /* Altura máxima del contenedor responsive */
      overflow-y: auto; /* Habilitar scroll vertical si es necesario */
    }
    .table th, .table td {
      width: 100px; /* Ancho específico para las columnas de la tabla */
      text-align: center; /* Alineación central del texto */
    }
  </style>


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style_crear_perfil.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <title>Búsqueda Filtrada</title>
</head>

<body>
  <div class="row">
    <div class="col">
      <!-- Inicio Navbar -->
      <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
          <div class="container-fluid">
            <a id="logo" class="navbar-brand" href="#"><img src="../images/Correos-Logo-1977.png" alt="" width=70px></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
              aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a id="volver" class="btn btn-outline-warning" aria-current="page" href="menu_jefe.php?correo=<?php echo $correo_recibido ?>">Regresar</a>
                </li>
                <h4 id="title_navbar">Búsqueda Filtrada</h4>
              </ul>
            </div>
          </div>
          <a href="../index.html"><button id="cerrar" type="button" class="btn btn-outline-danger">Logout</button></a>
        </nav>
      </header>
      <!-- Fin Navbar -->
    </div>
  </div>

  <div class="container text-center">
    <!-- Inicio Logo Superior -->
    <div class="row-5">
      <div class="col-12">
        <br>
        <img id="logo_index" src="../images/Correos-Logo-1977.png" alt="" width="200px">
        <p id="titulo_logo">El Correo de Yury</p>
      </div>
    </div>
    <!-- Fin Logo Superior -->

    <div class="row">
      <!-- Inicio Busqueda de Empleado por Rut -->
      <div class="col">
        <div class="card mb-3 card-form">
          <div class="card-header">
            <h4>Buscar Empleado en Específico</h4>
          </div>
          <div class="card-body">

            <form action="../php/filtrada_rut.php" method="post">
              <input type="hidden" name="correo_recibido" value="<?php echo $correo_recibido ?>">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingBuscarRut" placeholder="rut" name="rut" required>
                <label for="floatingBuscarRut">Buscar por Rut</label>
              </div>

              <button type="submit" class="btn btn-primary mb-3">Buscar</button>
            </form>

            <!-- Inicio Resultados de Busqueda por Rut -->
            <div class="table-responsive">
              <table class="table table-dark table-striped">
                <thead>
                  <tr>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Sueldo</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Ficha Emergencia</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row"><?php echo $rut  ?></th>
                    <td><?php echo $nombre. " " . $apellido  ?></td>
                    <td><?php echo $correo_perso  ?></td>
                    <td><?php echo $cargo  ?></td>
                    <td><?php echo $salario  ?></td>
                    <td><?php echo $telefono  ?></td>
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

                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Fin Resultados de Busqueda por Rut -->

          </div>
        </div>
      </div>
      <!-- Fin Busqueda de Empleado por Rut -->
    </div>

    <div class="row">
      <!-- Inicio Busqueda Filtrada de Empleados -->
      <div class="col">
        <div class="card mb-3 card-form">
          <div class="card-header">
            <h4>Búsqueda Filtrada de Empleados</h4>
          </div>
          <div class="card-body">


            <form action="../php/buscar_filtrada.php" method="post">
              <input type="hidden" name="correo_recibido" value="<?php echo $correo_recibido ?>">
              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Sexo:</label>
                <div class="col-sm-10">

                  <div class="col-12">
                      <select class="form-control" placeholder="Sexo" name="sexo">

                          <?php if ($_POST["sexo"] != ''){ ?>
                          <option value="<?php echo $_POST["sexo"]; ?>"><?php echo $_POST["sexo"]; ?></option>
                          <?php } ?>

                          <option value="">Ambos</option>
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                      </select> 
                  </div>

                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Cargo:</label>
                <div class="col-sm-10">

                  <div class="col-12">
                      <select class="form-control" name="cargo" id="cargo">

                        <?php if ($_POST["cargo"] != ''){ ?>
                        <option value="<?php echo $_POST["cargo"]; ?>"><?php echo $_POST["cargo"]; ?></option>
                        <?php } ?>

                        <option value="">Todos</option>
                        <option value="1">Jefe RR.HH</option>
                        <option value="2">Personal RR.HH</option>
                        <option value="3">Trabajador</option>
                      </select>
                  </div>

                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Departamento:</label>
                <div class="col-sm-10">

                  <div class="col-12">
                      <select class="form-control" name="departamento">

                        <?php if ($_POST["departamento"] != ''){ ?>
                        <option value="<?php echo $_POST["ID_departamento"]; ?>"><?php echo $_POST["NombreDepartamento"]; ?></option>
                        <?php } ?>

                        <option value="">Todos</option>
                        <?php
                        foreach ($departamentos as $departamento) {
                            echo "<option value='" . $departamento['ID_departamento'] . "'>" . $departamento['NombreDepartamento'] . "</option>";
                        }
                        ?>
                      </select>
                  </div>

                </div>
              </div>


              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Area:</label>
                <div class="col-sm-10">

                  <div class="col-12">
                      <select class="form-control select mb-3" name="area">

                        <?php if ($_POST["area"] != ''){ ?>
                        <option value="<?php echo $_POST["ID_area"]; ?>"><?php echo $_POST["NombreArea"]; ?></option>
                        <?php } ?>

                        <option value="">Todos</option>
                        <?php
                        foreach ($areas as $area) {
                            echo "<option value='" . $area['ID_area'] . "'>" . $area['NombreArea'] . "</option>";
                        }
                        ?>
                      </select> 
                  </div>

                </div>
              </div>
              

              <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Salario desde:</label>
                  <div class="col-sm-10">
                      <div class="col-12">
                          <input type="number" class="form-control" id="floatingBuscarSalarioMinimo"
                                placeholder="Rango mínimo" min="1" name="sueldo_min" value="<?php echo isset($_POST["sueldo_min"]) ? $_POST["sueldo_min"] : ''; ?>">
                      </div>
                  </div>
              </div>



              <div class="mb-3 row">
                  <label class="col-sm-2 col-form-label">Salario hasta:</label>
                  <div class="col-sm-10">
                      <div class="col-12">
                          <input type="number" class="form-control" id="floatingBuscarSalarioMaximo"
                                placeholder="Rango mayor" min="1" name="sueldo_max" value="<?php echo isset($_POST["sueldo_max"]) ? $_POST["sueldo_max"] : ''; ?>">
                      </div>
                  </div>
              </div>



              <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
              
            </form>

            <!-- Inicio Resultados de Busqueda por Filtrada -->
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Rut</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Sueldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Suponiendo que $result es el resultado de la consulta que contiene todos los registros
                        // Iterar sobre cada fila de resultados
                        foreach ($_SESSION['resultados_busqueda'] as $row) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Rut']) ?></td>
                                <td><?php echo htmlspecialchars($row['Sexo']) ?></td>
                                <td><?php echo htmlspecialchars($row['PrimerNombre'] . " " . $row['ApellidoPaterno']) ?></td>
                                <td><?php echo htmlspecialchars($row['Correo']) ?></td>
                                <td>
                                    <?php
                                    $cargo = htmlspecialchars($row['Tipo_Cargo']);
                                    if ($cargo == 1) {
                                        echo "Jefe RR.HH";
                                    } elseif ($cargo == 2) {
                                        echo "Personal RR.HH";
                                    } elseif ($cargo == 3) {
                                        echo "Trabajador";
                                    } else {
                                        echo "Desconocido";
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['TelefonoPersonal']) ?></td>
                                <td><?php echo htmlspecialchars($row['Salario']) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Fin Resultados de Busqueda por Filtrada -->

          </div>
        </div>
      </div>
    </div>

  </div>

</body>

</html>