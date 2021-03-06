<?php
session_start();
if (!isset($_GET['id'])) {
    header("Location:autores.php");
}
$id = $_GET['id'];
require "../vendor/autoload.php";

use Clases\Autores;

$autor = new Autores();
$autor->setId_autor($id);
if ($autor->existeId() == 0) {
    $autor = null;
    header("Location:autores.php");
}

$fila = $autor->read();
$estenombre = $fila->nombre;
$esteapellido = $fila->apellidos;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Detalle autor</title>
</head>

<body style="background-color: darksalmon">
    <h3 class="text-center my-3">Detalle autor</h3>
    <div class="container">
        <div class="card text-white bg-dark mb-3" style="max-width: 38rem;">
            <div class="card-header text-center">Autor</div>
            <div class="card-body">
                <p class="card-text mb-2">Código: <?php echo $id; ?></p>
                <p class="card-text mb-2">Apellidos: <?php echo $esteapellido; ?></p>
                <p class="card-text mb-2">Nombre: <?php echo $estenombre; ?></p>
                <p class="text-center">
                    <a href="autores.php" class="btn btn-info"><i class="fas fa-home mr-2"></i>Inicio</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>