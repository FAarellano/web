<?php
if (isset($_GET['correo'])) {
  $correo_recibido = $_GET['correo'];
} else {
  // Manejar la situación cuando no se recibe el correo
  echo '<script>alert("No se recibió el correo.");</script>';
  // Puedes redirigir a alguna página de error o manejarlo de otra forma
  exit;
}

    include "../php/db.php";

    $db = new Database();
    $con = $db->conectar();


    if ($con) {

        $llamar_correo = $con->prepare("SELECT Rut FROM Personal WHERE Correo = :correo_recibido");
        $llamar_correo->bindParam(':correo_recibido', $correo_recibido);
        $llamar_correo->execute();

        if ($llamar_correo) {

            $fila = $llamar_correo->fetch(PDO::FETCH_ASSOC);
            if ($fila) {
                $rut_recibido = $fila['Rut'];

            } else {
                echo "No se encontraron resultados para el correo proporcionado.";
            }
        } else {

            echo "Error al ejecutar la consulta: " . $llamar_correo->errorInfo()[2];
        }
    } else {
        echo "Error al conectar a la base de datos.";
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
    <title>Cambiar contraseña</title>
</head>
<body>
  <div class="row">
      <!-- Inicio Navbar -->
      <div class="col">
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
                          <h4 id="title_navbar">Cambiar mi Contraseña</h4>
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
        <!-- Inicio Cambio de Contraseña -->
        <div class="col">
            <div class="card mb-3 card-form" style="max-width: 18rem;">
                <div class="card-header">
                    <h4>Cambiar Contraseña</h4>
                </div>
                <div class="card-body">
                    <form action="../php/cambiar_contraseña.php?correo=<?php echo $correo_recibido	?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingCambioContra" placeholder="nuevaContraseña" name="nueva_pass1" required>
                            <label for="floatingCambioContra">Nueva Contraseña</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingConfirmContra" placeholder="confirmarContraseña" name="nueva_pass2" required>
                            <label for="floatingConfirmContra">Confirmar Contraseña</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>

                    </form>
                </div>
            </div>
        </div>
        <!-- Fin Cambio de Contraseña -->

    </div>
</div>


</body>
</html>