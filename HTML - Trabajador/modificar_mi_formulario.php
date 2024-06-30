<?php
$correo_recibido = $_GET['correo'];
$rut_recibido = $_GET['rut'];

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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar mi Formulario</title>
    <link rel="stylesheet" href="../CSS/style_crear_perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                        <a id="volver" class="btn btn-outline-warning" aria-current="page" href="menu_trabajador.php?correo=<?php echo $correo_recibido ?>">Regresar</a>
                    </li>
                    <h4 id="title_navbar">Modificar mi Formulario</h4>
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

    <form action="../php/modificar_formulario.php" method="POST">
        <!--INICIO BODY-->
        <div id="titulo_seleccion">
                    Modificar Formulario de <br>"<?php echo $rut_recibido ?>"
                </div><br>

            <div class="row">

                <div class="col">
                    <div class="card mb-3 card-form" style="max-width: 30rem;">
                        <div class="card-body">


                        

                            <!-- Datos Personales a rellenar -->
                        <form action="../php/modificar_formulario.php" method="post">
                            <input type="hidden" name="rut" value="<?php echo $rut_recibido ?>">
                            <h3>Datos Personales</h3>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingRelleEdad" placeholder="edad" name="edad" min=1 required>
                                        <label for="floatingRelleEdad">Edad</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingRelleTelefono" placeholder="telefono" name="telefono" min=1 required>
                                        <label for="floatingRelleTelefono">Teléfono</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                        <select class="form-control select mb-3" name="sexo" required>
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

                            <!-- Contactos de Emergencia del trabajador-->
                            <h3>Contacto de Emergencia</h3>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingModTrabajNomPersonaEmergen"
                                            placeholder="nombrePersonaEmergencia" name="nombre_emergencia" required>
                                        <label for="floatingModTrabajNomPersonaEmergen">Nombre Persona de Emergencia
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingModTrabajRelacion"
                                            placeholder="relacionTrabajador" name="relacion_emergencia" required>
                                        <label for="floatingModTrabajRelacion">Relación con el Trabajador</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="floatingModTrabajTelefEmergen"
                                            placeholder="telefonoEmergencia" name="telefono_emergencia" min=1 required>
                                        <label for="floatingModTrabajTelefEmergen">Teléfono de Emergencia</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingModTrabajCorreoPersonaEmergen"
                                            placeholder="correoPersonaEmergencia" name="correo_emergencia" required>
                                        <label for="floatingModTrabajCorreoPersonaEmergen">Correo Persona de Emergencia
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <!-- Fin Contactos de Emergencia del trabajador-->

                            <!-- Previsiones  -->
                            <h3>Previsiones</h3>
                            <div class="row">
                                <div class="col-12">
                                        <select class="form-control select mb-3" name="prevision_social" required>
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
                                        <select class="form-control select mb-3" name="prevision_medica" required>
                                            <option value="value0" selected disabled>Prevision Médica</option>
                                            <option value="1">FONASA</option>
                                            <option value="2">ISAPRE</option>
                                        </select>
                                </div>

                                

                            </div>
                            <!-- Fin Previsiones -->
                            <!-- Cargas familiares (Puede añadir más) -->
                            <h3>Cargas Familiares:</h3>
                            <div class="row">
                                <button id="agregarCargaFamiliar" type="button" class="btn btn-primary">Agregar Carga Familiar</button>
                            </div>
                            <div id="contenedorTarjetas"></div>

                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('agregarCargaFamiliar').addEventListener('click', function() {
                                    // Crear elementos para la tarjeta
                                    var cardContainer = document.createElement('div');
                                    cardContainer.classList.add('card', 'mb-3');

                                    var cardHeader = document.createElement('div');
                                    cardHeader.classList.add('card-header');
                                    cardHeader.innerHTML = '<h3>Cargas Familiares</h3>';

                                    var cardBody = document.createElement('div');
                                    cardBody.classList.add('card-body');

                                    // Formulario para los campos de carga familiar
                                    var formHTML = `
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingCargaFamiliarNombre" name="nombreCargaFamiliar[]" placeholder="Nombre" required>
                                                    <label for="floatingCargaFamiliarNombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingCargaFamiliarRut" name="rutCarga[]" placeholder="Rut" required>
                                                    <label for="floatingCargaFamiliarRut">Rut: Ej: XXXXXXX-1</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control select mb-3" aria-label="Parentesco" name="parentesco[]" required>
                                                    <option  disabled selected>Parentesco </option>
                                                    <option value="Hijo(a)">Hijo(a)</option>
                                                    <option value="Conyugue">Conyugue</option>
                                                    <option value="Padre">Padre</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control select mb-3" aria-label="Sexo" name="sexoCarga[]" required>
                                                    <option  disabled selected>Sexo</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                </select>
                                            </div>
                                        </div>

                                    `;

                                    cardBody.innerHTML = formHTML;

                                    // Botón para eliminar la tarjeta
                                    var eliminarBtn = document.createElement('button');
                                    eliminarBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');
                                    eliminarBtn.textContent = 'Eliminar';
                                    eliminarBtn.addEventListener('click', function() {
                                        cardContainer.remove();
                                    });

                                    cardBody.appendChild(eliminarBtn);

                                    // Agregar cardBody y cardHeader a cardContainer
                                    cardContainer.appendChild(cardHeader);
                                    cardContainer.appendChild(cardBody);

                                    // Agregar cardContainer al contenedor principal
                                    var contenedorPrincipal = document.getElementById('contenedorTarjetas');
                                    contenedorPrincipal.appendChild(cardContainer);
                                });
                            });
                            </script>
                            </div>

                            <button type="submit" class="btn btn-success">Enviar Formulario</button>
                        </form>
                        </div>

                    </div>
                </div>

            </div>



        </div>

        <!--FINAL BODY-->
    </form>
</body>
</html>

