<?php
    $correo_recibido = $_GET['correo'];
    $cargo = $_GET['cargo'];
    $rut = $_GET['rut'];
    $salario = $_GET['salario'];

    if($cargo == 1){
        $cargo = "Jefe RR.HH";
    }
    if($cargo == 2){
        $cargo = "Personal RR.HH";
    }
    if($cargo == 3){
        $cargo = "Trabajador";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_crear_perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Modificar Cargos y Sueldos</title>
</head>
<body>
    <div class="row">
        <!-- Inicio Navbar -->
        <div class="col">
          <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
              <div class="container-fluid">
                <a id="logo" class="navbar-brand" href="#"><img src="../images/Correos-Logo-1977.png" alt=""
                    width=70px></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                  aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a id="volver" class="btn btn-outline-warning" aria-current="page"
                        href="menu_jefe.php?correo=<?php echo $correo_recibido ?>">Regresar</a>
                    </li>
                    <h4 id="title_navbar">Modificar Cargos y Sueldos</h4>
                  </ul>
                </div>
              </div>
              <a href="../index.html"><button id="cerrar" type="button" class="btn btn-outline-danger">Logout</button></a>
            </nav>
          </header>
        </div>
        <!-- Fin Navbar -->
    </div>
<div class="container text-center">
    <div class="row-5">
        <!-- Inicio Logo Superior -->
        <div class="col-12">
          <br>
          <img id="logo_index" src="../images/Correos-Logo-1977.png" alt="" width="200px">
          <p id="titulo_logo">El Correo de Yury</p>
        </div>
        <!-- Fin Logo Superior -->
    </div>

    <div class="row">
        <!-- Inicio Buscar RUT -->
        <div class="col">
            <div class="card mb-3 card-form" style="max-width: 18rem;">
                <div class="card-header">
                    <h4>Buscar Trabajador</h4>
                </div>
                <div class="card-body">

                    <form action="../php/buscar_rut.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="correo_recibido" value="<?php echo $correo_recibido ?>">
                            <input type="text" class="form-control" id="floatingModCargoRut" placeholder="rut" name="rut" required>
                            <label for="floatingModCargoRut">Rut trabajador a Modificar</label>
                        </div>

                        <button type="submit" class="btn btn-outline-primary">Buscar rut</button><br>
                    </form>                    

                </div>
            </div>
        </div>
        <!-- Fin Buscar RUT -->
    </div>

    <div class="row">
        <!-- Inicio Modificación de Sueldo y Cargo -->
        <div class="col">
            <div class="card mb-3 card-form" style="max-width: 18rem;">
                <div class="card-header">
                    <h4>Modificar Cargo y Sueldo</h4>
                </div>
                <div class="card-body">

                <form action="../php/modificar_cargo_sueldo.php" method="POST">
                    <input type="hidden" name="correo_recibido" value="<?php echo $correo_recibido ?>">
                    <input type="hidden" name="rut" value="<?php echo $rut ?>">
                    <h6>Sueldo Actual</h6>
                    <ul class="list-group mb-3">
                        <li class="list-group-item disabled" aria-disabled="true">$<?php echo $salario ?></li>
                    </ul>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingModSueldo" value="1" min="1" placeholder="sueldo" name="new_salario" required>
                        <label for="floatingModSueldo">Nuevo sueldo</label>
                    </div>

                    <h6>Cargo Actual</h6>
                        
                    <ul class="list-group mb-3">
                        <li class="list-group-item disabled" aria-disabled="true"><?php echo $cargo ?></li>
                    </ul>

                        <div class="form-floating mb-3">
                            <select class="form-control select mb-4" name="new_cargo" style="padding: 16px 12px 16px 12px;"  required>
                                <option value="0" selected disabled >Cargo</option>
                                <option value="1">Jefe RR.HH</option>
                                <option value="2">Pesonal RR.HH</option>
                                <option value="3">Trabajador</option>
                            </select>
                        </div>
                    <button type="submit" class="btn btn-success">Modificar Sueldo</button>
                </form>   

                </div>

            </div>
        </div>
        <!-- Fin Modificación de Sueldo y Cargo-->
    </div>

</div>
    
</body>
</html>