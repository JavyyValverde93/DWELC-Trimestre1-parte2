<?php
    session_start();
    require "../vendor/autoload.php";
    use Clases\Autores;
    use Clases\Libros;

    $esteAutor=new Autores();
    $recuperar=$esteAutor->recuperarTodos(0, 1000);
    $esteAutor=null;

    $esteLibro = new Libros();
    $esteLibro->setId_libro($id);
    $datosLibro=$esteLibro->read();

    function esImagen($tipo){
        $ima=["image/gif", "image/jpeg", "image/x-icon", "image/png", "image/tiff", "image/bmp", "image/webp"];
        return in_array($tipo, $ima);
    }
    function mostrarErrores($texto){
        $_SESSION['error']=$texto;
        global $id;
        header('Location:updateLibro.php?id=$id');
        die();
        
    }

    if(isset($_POST['update'])){
        
        $esteLibro=new Libros();
        
        $titulo=trim(ucwords($_POST['titulo']));
        $isbn=$_POST['isbn'];
        $autor=$_POST['autor'];
        
        if(is_uploaded_file($_FILES['portada']['tmp_name'])){
            if(esImagen($_FILES['portada']['type'])){
                //subo el archivo con un nombre único a la carpeta img.
                $nombre= "./img/".uniqid(). "_".$_FILES['portada']['name'];
                move_uploaded_file($_FILES['portada']['tmp_name'], $nombre);
                
                //debemos
                if(basename($datosLibro->portada)!="default.jpg"){
                    unlink($datosLibro->portada);
                }
                $esteLibro->setPortada($nombre);
            }else{
                mostrarErrores("Debes subir un archivo de imagen!!!!");
            }


        }
        if(strlen($titulo)==0){
            mostrarErrores("Rellena el campo título!!!");
        }
        $esteLibro->setTitulo($titulo);
        $esteLibro->setAutor($autor);
        $esteLibro->setIsbn($isbn);
        if(isset($nombre)){
            $esteLibro->setPortada = $datosLibro->portada;
        }

        $esteLibro->create();
        $esteLibro=null;
        $_SESSION['mensaje']="LIbro creado Correctamente";
        header("Location:libros.php");

    }
    else{
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Crear Libro </title>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <title>Crear Libro</title>
</head>

<body style="background-color:darksalmon">
    <h3 class="text-center my-3">Nuevo Libro</h3>
    <div class="container">
    <?php
            if(isset($_SESSION['error'])){
                echo "<p class='text-light bg-dark font-weight-bold p-2 my-2'>{$_SESSION['error']}</p>";
                unset($_SESSION['mensaje']);
            }
        ?>
        <form name="c" action="<?php $_SERVER['PHP_SELF']."?id=$id"; ?>" method='POST' enctype="multipart/form-data">
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
                                while($fila=$recuperar->fetch(PDO::FETCH_OBJ)){
                                    if($fila->id_autpr=$datosLibro->autor){
                                        echo "<option value='{$fila->id_autor}' selected>{$fila->epellidos}, {$fila->nombre}</option>\n";
                                    }else{
                                        echo "<option value='{$fila->id_autor}'>{$fila->apellidos}, {$fila->nombre}</option>\n";
                                    }
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
                        <input type="text" minlength=13 maxlength=13 required pattern="[0-9]{13}" name="isbn" class='form-control'>
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
                        <button type="submit" class="btn btn-primary mr-3" name="update"><i class="fas fa-plus  mr-2"></i>Crear</button>
                        <button type="reset" class='btn btn-warning mr-3'>Limpiar</button>
                        <a href="libros.php" class="btn btn-info"><i class="fas fa-home  mr-2"></i>Inicio</a>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
    <?php } ?>

