<!DOCTYPE html>
<?php
session_start();
require "../vendor/autoload.php";

use Clases\Libros;

$mislibros = new Libros();
$mislibros->rellenarLibros(100);
$totalRegistros = $mislibros->totalReg();
$paginar = 5;
if ($totalRegistros % $paginar == 0) {
    $cantidadPaginas = $totalRegistros / $paginar;
} else {
    $cantidadPaginas = (int) ($totalRegistros / $paginar) + 1;
}
$estapagina = (isset($_GET['page'])) ? $_GET['page'] : 1;

$traer = $mislibros->recuperarTodos(($estapagina - 1) * $paginar, $paginar);
$mislibros = null;
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Libros</title>
</head>

<body style="background-color: darksalmon">
    <h3 class="text-center my-3">Autores</h3>
    <div class="container">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='text-light bg-dark font-weight-bold p-2 my-2'>{$_SESSION['mensaje']}</p>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="createlibro.php" class='btn btn-success my-2'><i class="fas fa-user-plus mr-2"> Crear Libro</i></a>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $traer->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
        <tr>
          <th scope="row">{$fila->titulo}</th>
          <td>{$fila->apellidos}, {$fila->nombre}</td>
          <td><img src="{$fila->portada} width='80rem' height='80rem'"></td>
          <td></td>
          <form name='n1' action="borrarLibro.php" method='POST' class="form-in-line">
          <a href="updateLibro.php?id={$fila->id_libro}" class='btn btn-warning'>i class='far fa-edit mr -2'</i>Editar</a>
          
          <a href="detalleLibro.php?id={$fila->id_libro}" class='btn btn-info'>Detalle</a>
          <input type="hidden" value='{$fila->id_libro}' name="id"/>
          <button type='submit' class='btn btn-danger' onclick="return confirm('¿Borrar libro?');"><i class="far fa-trash-alt mr-2"></i>Borrar</button>
          </form>
        </tr>
        TXT;
                }
                ?>
            </tbody>
        </table>
        <?php
        for ($i = 1; $i <= $cantidadPaginas; $i++) {
            echo "| <a href='libros.php?page=$i'>$i</a>|";
        }
        ?>
    </div>
</body>

</html>