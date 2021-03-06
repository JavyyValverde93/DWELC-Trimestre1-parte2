<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_GET['id'])){
        header("Location: libros.php");
    }
    $id = $_GET['id'];

    require "../vendor/autoload.php";

    use Clases\Autores;
    use Clases\Libros;

    $esteLibro = new Libros();
    $esteLibro->setId_libro($id);
    $datosLibro=$esteLibro->read();
    //Meto en variables todos los campos de libro
    $titulo=$datosLibro->titulo;
    $autor=$datosLibro->autor;
    $isbn=$datosLibro->isbn;
    $portada=$datosLibro->portada;
    //Recuperamos nombre y apellidos del autor a partir de $autor
    $esteAutor = new Autores();
    $esteAutor->setId_autor($autor);
    $datosAutor=$esteAutor->read();
    $esteAutor=null;
    $nombreAutor = $datosAutor->nombre;
    $apellidosAutor = $datosAutor->apellidos;

    $autor=new Autores();
    $autor->setId_autor($id);
    if($autor->existeId()==0){
        $autor=null;
        header("Location:autores.php");
    }
    $fila=$autor->read();
    $esteNombre=$fila->nombre;
    $esteApellido=$fila->apellidos;
?>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>Detalle</title>
</head>
<body style="background-color:darksalmon">
    <h3 class="text-center my-3">Detalle Libro</h3>
    <div class="container">
    <div class="card text-white bg-dark mb-3 m-auto" style="max-width: 38rem;">
  <div class="card-header text-center">Libro</div>
  <div class="card-body">
      <img src="<?php echo $portada ?>" height='100rem' width='100rem' class='float-right img-thumbnail rounded'>
    <p class="card-text- mb-2">Código: <?php echo $id; ?></p>
    <p class="card-text- mb-2">Título: <?php echo $titulo; ?></p>
    <p class="card-text- mb-2">Isbn: <?php echo $isbn; ?></p>
    <p class="card-text- mb-2">Autor: <?php echo $apellidosAutor. ", ".$nombreAutor; ?></p>

    <p class="float-right">
    <a href="autores.php" class="btn btn-info"><i class="fas fa-home mr-2"></i>Inicio</a>
  </div>
    </div>
    </div>
    </body>
    </html>