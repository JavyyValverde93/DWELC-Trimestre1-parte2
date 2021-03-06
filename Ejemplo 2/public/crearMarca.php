<?php
    require "../vendor/autoload.php";
    use Clases\Marcas;
    
    function mostrarError($texto){
        $_SESSION['error'] = $texto;
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    function esImagen($tipo){
        $tipos=['image/gif', 'image/jpeg', 'image/x-icon', 'image/tiff', 'image/bmp', 'image/png', 'image/webp'];
        return in_array($tipo, $tipos);
    }

    $provincias = ["Almeria", "Cádiz", "Huelva", "Granada", "Córdoba", "Jaén", "Málaga", "Sevilla"];
    if(isset($_POST['btncrear'])){
        $estaMarca = new Marcas();
        //Procesamos formulario
        $provincia = $_POST['provincia'];
        $nombre = trim(ucwords($_POST['nombre']));
        if(strlen($nombre)==0){
            mostrarError("Rellene el campo nombre por favor");
        }
        if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
            //Compruebo que sea realmente una imágen
            if(esImagen($_FILES['imagen']['type'])){
                //Es un fichero de imágen lo guardamos conun nombre aleatorio
                $miImagen = "./img/".uniqid()."_".$_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], $miImagen);
                $estaMarca->setImagen($miImagen);
            }else{
                mostrarError("Debes subir un archivo de Imagen!!!!!!");
            }
        }else{
            $estaMarca->setImagen("./img/default.jpg");
        }
            $estaMarca->setProvincia($provincia);
            $estaMarca->setNombre($nombre);
            $estaMarca->create();

            $estaMarca=null;
            $_SESSION['mensaje']="Marca creada correctamente";
            header("Location:index.php");
    }else{

    
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        <title>Crear Marca</title>
    </head>
    <body style="background-color:darksalmon">
        <h3 class="text-center my-4">Crear Marca</h3>
        <div class="container mr-4">
            <?php
            if(isset($_SESSION['error'])){
                echo "<p class='my-2 text-light bg-dark'>{$_SESSION['error']}</p>";
            }
            ?>
            <form name="cm" method="POST" enctype="multipart/form-data" action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                <div class="row">
                    <div class="col">
                    <input type="text" class="form-control" placeholder="Nombre" name="nombre">
                    </div>
                    <div class="col">
                        <select name="provincia" class="form-control">
                            <?php
                                foreach($provincias as $valor){
                                    echo "<option value='$valor'>$valor</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <b>Imagen de Marca: </b>
                        <input type="file" class="form-control" name="imagen">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button class="btn btn-primary mr-2" type="submit" name="btncrear">Crear</button>
                        <input type="reset" class="btn btn-warning mr-2" value="Limpiar">
                        <a href="index.php" class="btn btn-info">Inicio</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<?php } ?>