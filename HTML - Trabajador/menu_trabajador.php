<?php
// Recibir el parámetro 'correo' desde la URL
$correo_recibido = $_GET['correo'];

include "../php/db.php";

$db = new Database();
$con = $db->conectar();

$llamar_nombre = $con->prepare("SELECT Rut,PrimerNombre,ApellidoPaterno FROM Personal WHERE Correo = :correo_recibido");
$llamar_nombre->bindParam(':correo_recibido', $correo_recibido);
$llamar_nombre->execute();

if ($llamar_nombre) {
    $fila = $llamar_nombre->fetch(PDO::FETCH_ASSOC);

    $rut = $fila['Rut'];
    $primer_nombre = $fila['PrimerNombre'];
    $primer_apellido = $fila['ApellidoPaterno'];
} else {
    echo "Error al ejecutar la consulta: " . $llamar_nombre->errorInfo()[2];
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio: Trabajador</title>
    <link rel="stylesheet" href="../CSS/style_menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--MENÚ SUPERIOR-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
          <a id="logo" class="navbar-brand" href="#"><img src="../images/Correos-Logo-1977.png" alt="" width=70px></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            
            <ul class="navbar-nav">
              <li class="nav-item">
                <a id="check" class="nav-link active" aria-current="page" href="ver_formulario.php?rut=<?php echo $rut ?>">
                  Ver mi formulario
                </a>
              </li>


              <li class="nav-item">
                <a id="check" class="nav-link active" aria-current="page" href="modificar_mi_formulario.php?rut=<?php echo $rut ?>&correo=<?php echo $correo_recibido ?>">Modificar mi formulario</a>
              </li>

              <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="recuperar.php?correo=<?php echo urlencode($correo_recibido) ?>">
                        <button type="button" class="btn btn-outline-warning">Cambiar contraseña</button>
                        </a>
                    </li>

                
            </ul>
          </div>
          <a href="../index.html"><button id="cerrar" type="button" class="btn btn-outline-danger">Logout</button></a>
        </div>
      
        
      </nav>
    <!--MENÚ SUPERIOR-->


    
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


    <div id="titulo_seleccion">Bienvenido <br>"<?php echo $primer_nombre ." ".$primer_apellido ?>"</div><br><br>
</body>
</html>
