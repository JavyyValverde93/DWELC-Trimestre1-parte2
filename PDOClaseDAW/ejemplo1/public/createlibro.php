<?php
session_start();
require "../vendor/autoload.php";

use Clases\Autores;
use Clases\Libros;

$esteAutor = new Autores();
$recuperar = $esteAutor->recuperarTodos(0, 1000);
$esteAutor = null;

function esImagen($tipo) {
    $img = ["image/gif","image/x-icon","image/jpeg","image/svg+xml","image/tiff", "image/webp"];
    return in_array($tipo, $img);
}
function mostrarError($texto) {
    $_SESSION['error'] = $texto;
    header("Location:{$_SERVER['PHP_SELF']}");
    die();
}

if (isset($_POST['crear'])) {
    $esteLibro = new Libros();
    $titulo=trim(ucwords($_POST['titulo']));
    $isbn=$_POST['isbn'];
    $autor=$_POST['autor'];
    if (is_uploaded_file($_FILES['portada']['tmp_name'])) {
        if (esImagen($_FILES['portada']['type'])) {
            //subo el archivo con un nombre único a la carpeta img
            $nombre = "./img/". uniqid(). "_".$_FILES['portada']['name'];
            move_uploaded_file($_FILES['portada']['tmp_name'], $nombre);
            $esteLibro->setPortada($nombre);
        } else {
            mostrarError("Debes subir un archivo de imagen");
        }
    }
    if (strlen($titulo)==0) {
        mostrarError("Rellena el campo titulo!");
    }
    $esteLibro->setTitulo($titulo);
    $esteLibro->setAutor($autor);
    $esteLibro->setISBN($isbn);
    $esteLibro->create();
    $esteLibro = null;
    $_SESSION['mensaje']="Libro creado correctamente";
    header("Location:libros.php");
} else {

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        <title>Libros</title>
    </head>

    <body style="background-color: darksalmon">
        <h3 class="text-center my-3">Crear Libros</h3>
        <div class="container">
            <?php
             if (isset($_SESSION['error'])) {
                echo "<p class='text-light bg-dark font-weight-bold p-2 my-2'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            ?>
            <form name="a" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-1">
                        <label class="col-form-label">Título: </label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="titulo" required name="titulo">
                    </div>
                    <div class="col-1">
                        <label class="col-form-label">Autor: </label>
                    </div>
                    <div class="col-6">
                        <select name="autor" class="form-control">
                            <?php
                            while ($filas = $recuperar->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='{$filas->id_autor}'>{$filas->apellidos},{$filas->nombre}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-1">
                        <label class="col-form-label">ISBN: </label>
                    </div>
                    <div class="col-4">
                        <input type="text" minlength=13 maxlength=13 required pattern="[0-9]{13}" name="isbn" class='form-control' placeholder="ISBN">
                    </div>
                    <div class="col-1">
                        <label class="col-form-label" for="p">Portada:</label>
                    </div>
                    <div class="col">
                        <input type="file" class="form-control" id="p" name="portada">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary mr-3" name="crear"><i class="fas fa-plus  mr-2"></i>Crear</button>
                        <button type="reset" class='btn btn-warning mr-3'>Limpiar</button>
                        <a href="libros.php" class="btn btn-info"><i class="fas fa-home  mr-2"></i>Inicio</a>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php } ?>