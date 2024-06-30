<?php

$correo_recibido = $_GET['correo'];

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
  <title>Eliminar un Perfilr</title>
</head>

<body>
  <div class="row">
    <!-- Inicio Navbar -->
    <div class="col">
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
                  <a id="volver" class="btn btn-outline-warning" aria-current="page"
                    href="menu_jefe.php?correo=<?php echo $correo_recibido ?>">Regresar</a>
                </li>
                <h4 id="title_navbar">Eliminar un Perfil</h4>
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
      <!-- Inicio Form Eliminar Trabajador -->
      <div class="col">
        <div class="card mb-3 card-form" style="max-width: 18rem;">
          <div class="card-header">
            <h4>Eliminar un Perfil</h4>
          </div>
          <div class="card-body">

            <form action="../php/eliminar_perfil.php" method="POST">
              <input type="hidden" name="correo_recibido" value="<?php echo $correo_recibido ?>">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingElimTrabajRut" placeholder="rut" name="rut" required>
                <label for="floatingElimTrabajRut">Rut a eliminar</label>
              </div>

              <div class="form-floating mb-3"> 
                <input type="email" class="form-control" id="floatingElimTrabajCorreo" placeholder="correo" name="correo" required>
                <label for="floatingElimTrabajCorreo">Correo a eliminar</label>
              </div>

              <button type="submit" class="btn btn-success">Eliminar</button>
            </form>

          </div>

        </div>
      </div>
      <!-- Fin Form Eliminar Trabajador -->
    </div>
  </div>