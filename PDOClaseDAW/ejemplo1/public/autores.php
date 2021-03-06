<!DOCTYPE html>
<?php
session_start();
require "../vendor/autoload.php";

use Clases\Autores;

$misAutores = new Autores();
$totalRegistros = $misAutores->totalReg();
$mostrar = 4;
if ($totalRegistros % $mostrar == 0) {
    $cantidadPaginas = $totalRegistros / $mostrar;
} else {
    $cantidadPaginas = (int)(($totalRegistros / $mostrar) + 1);
}
/*
$cantidadPaginas=($totalRegistros%$mostrar==0)? $totalRegistros / $mostrar : $cantidadPaginas = (int)(($totalRegistros / $mostrar) + 1);
$a=(evaluo expresion logica)? si cierto este valor: si no este otro;
*/
$pagina=(isset($_GET['page']))? $_GET['page']:1;



$misAutores->rellenarAutores(20);
$todos = $misAutores->recuperarTodos(($pagina-1)*$mostrar,$mostrar);
$misAutores = null;
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Autores</title>
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
        <a href="cautor.php" class='btn btn-success my-2'><i class="fas fa-user-plus mr-2"> Crear Autor</i></a>

        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $todos->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
                <tr>
                    <th scope="row">{$fila->id_autor}</th>
                    <td>{$fila->apellidos}</td>
                    <td>{$fila->nombre}</td>
                    <td>
                    <form class="form-inline" name="b" action="deleteAutor.php" method="POST">
                    <a href="detalleAutor.php?id={$fila->id_autor}" class="btn btn-primary mr-2">
                    <i class="fas fa-user-check">Detalles</i></a>
                        <a href="updateAutor.php?id={$fila->id_autor}" class="btn btn-warning mr-2">
                        <i class="fas fa-user-edit mr-2"> Editar Autor</i></a>
                        <input type="hidden" value="{$fila->id_autor}" name="id">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Borrar Autor?');">
                        <i class="fas fa-user-minus mr-2"> Borrar</i> </button>
                    </form>
                    </td>
                </tr>
                TXT;
                }

                ?>
            </tbody>
        </table>
        <?php
            for($i=1;$i<=$cantidadPaginas;$i++){
                echo "| <a href='autores.php?page=$i'>$i</a>|";
            }
        ?>
    </div>
</body>

</html>