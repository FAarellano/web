<?php
$cargo_seleccionado = $_POST['cargo_seleccionado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./js/script_index.js"></script>
    <title>Login: El Correo de Yury</title>
</head>
<body>
    <!--Logo Superior-->
    <div class="container text-center">
        <div class="row-5">
          <div class="col-12">
            <br>
            <img id="logo_index" src="../images/Correos-Logo-1977.png" alt="" width="180px">
            <p id="titulo_logo">El Correo de Yury</p>   
          </div>
        </div>
    </div>
    <!--Logo Superior-->

    <!--Selección Usuario-->
    <div id="titulo_seleccion">
        Inicio de Sesión
    </div>
    <!--Login-->
    <div class="login">
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <form class="login" action="login_verify.php" method="post">

                      <input type="hidden" name="cargo_seleccionado" value=<?php echo $cargo_seleccionado ?>>

                      <input id="usuario" type="email" placeholder="Correo" name="correo" required><br>
                      <input id="contraseña" type="password" placeholder="Contraseña" name="contrasena" required><br>
                      <button id="enviar" class="btn btn-primary">Iniciar sesión</button>


                    </form>
                </div>
        </div>
    <!--Login-->

    <!--Recuperacion-->
        <div class="container text-center">
            <div class="row">
            <divclass="col">
                <div class="dropdown">
                    <button id="recuperar" type="button" class="btn btn-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Restablecer mi contraseña</button>

                    <form class="dropdown-menu p-4" data-bs-theme="dark" action="restablecer_contraseña.php" method="POST">
                      <div class="mb-3">

                        <label for="exampleDropdownFormEmail2" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@yury.com" name="correo" required>

                      </div>
                      <div class="mb-3">

                        <label for="exampleDropdownFormText" class="form-label">Rut</label>
                        <input type="text" class="form-control" id="exampleDropdownFormText" placeholder="12345678-1" name="rut" required>

                      </div>
                      <button type="submit" class="btn btn-primary">Recuperar</button>
                    </form>

                  </div>
            </div>
            </div>
        </div>
    </div>
    <!--Recuperacion-->



</body>
</html>
