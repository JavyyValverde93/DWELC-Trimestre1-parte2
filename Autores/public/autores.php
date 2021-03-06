<!DOCTYPE html>
<?php
session_start();
require "../vendor/autoload.php";
use Clases\Autores;
$misAutores = new Autores();
$totalRegistros = $misAutores->totalReg();
$mostrar=4;
if($totalRegistros % $mostrar == 0){
    $cantidadPaginas = $totalRegistros/$mostrar;
}else{
    $cantidadPaginas=(int)(($totalRegistros/$mostrar)+1);
}
/*$cantidadPaginas=($totalRegistros/$mostrar==0)? $totalRegistros/$mostrar : $cantidadPaginas=(int)(($totalRegistros/$mostrar)+1);
*/
$pagina=(isset($_GET['page'])) ? $_GET['page'] : 1;
$misAutores->rellenarAutores(20);
$todos = $misAutores->recuperarTodos(($pagina-1)*$mostrar, $mostrar);
$misAutores=null;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="background-color:darksalmon">
    <h3 class="text-center my-3">Autores</h3>
    <div class="container">
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<p class='text-light bg-dark font-weight-bold p-2 my-2'>{$_SESSION['mensaje']}</p>";
        unset($_SESSION['mensaje']);
    }
    ?>
    <a href="cautor.php" class='btn btn-success my-2'><i class="fas fa-user-plus mr-2"> Crear Autor</i></a>

        <table border=1 class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($fila = $todos->fetch(PDO::FETCH_OBJ)){
                    echo <<<TXT
                    <tr>
                    <th scope="row">{$fila->id_autor}</th>
                    <td>{$fila->apellidos}</td>
                    <td>{$fila->nombre}</td>
                    <td>
                    <form class="form-inline" name="b" action="deleteAutor.php" method="POST">
                        <a href="detalleAutor.php?id={$fila->id_autor}" class="btn btn-primary mr-2">
                        <i class="fas fa-user-check mr-2"></i>Detalle</a>
                        <a href="updateAutor.php?id={$fila->id_autor}" class="btn btn-warning mr-2"><i class="fas fa-user-edit mr-2"</i>Update</a>
                        <input type="hidden" value="{$fila->id_autor}" name="id">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Borrar Autor?');">
                        <i class="fas fa-user-minus mr-2"></i>Borrar</button>
                    </form>
                    </td>
                    </tr>
                    TXT;
                }







            ?>

        </tbody>
        </table>
    <?php
    echo "<br>";
    for($i=1; $i<=$cantidadPaginas; $i++){
        echo "| <a href='autores.php?page=$i'</a>$i | ";
    }
    ?>
    </div>
</body>
</html>