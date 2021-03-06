<?php
session_start();
if(!isset($_POST['id'])){
    header('Location:libros.php');
    die();
}
require "../vendor/autoload.php";
use Clases\Libros;

$id=$_POST['id'];
$libro = new Libros();
$libro->setId_libro($id);
$portada = $libro->recuperarPortada();
//Si portada no es defaul.jpg voy a borrar el archivo de imagen y luego la entrada en la bbdd
$libro->delete();

id($portada!="./img/default.jpg"){
    unlink($portada);
}
$libro->delete();
$libro = null;
$_SESSION['mensaje']="Libro borrado Correctamente";
header("Location:libros.php");