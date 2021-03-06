<?php
session_start();
require "../vendor/autoload.php";

use Clases\Autores;

if (isset($_POST['crear'])) {
    $n = trim(ucwords($_POST['nombre']));
    $a = trim(ucwords($_POST['apellidos']));
    if (strlen($a) == 0 || strlen($n) == 0) {
        $_SESSION['error'] = "Error debe ingresar nombre y apellidos";
        header("Location:{$_SERVER['PHP_SELF']}");
    }
    $autor = new Autores();
    $autor->setNombre($n);
    $autor->setApellidos($a);
    $autor->create();
    $autor = null;

    $_SESSION['mensaje'] = "Autor creado correctamente.";
    header("Location:autores.php");
} else {
?>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        <title>Crear Autor</title>
    </head>

    <body style="background-color: darksalmon">
        <h3 class="text-center my-3">Crear Autor</h3>
        <div class="container mb-3">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='text-light bg-dark font-weight-bold p-2'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            ?>
            <form name="cautor" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="row">
                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" require>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" require>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button name="crear" type="submit" class="btn btn-info"><i class="fas fa-user-plus mr-2"> Crear</i></button>
                        <button type="reset" class="btn btn-warning ml-3"><i class="fas fa-broom mr-2"> Limpiar</i></button>
                        <a href="autores.php" class="btn btn-primary ml-3"><i class="fas fa-home mr-2"> Inicio</i></a>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php
}
?>