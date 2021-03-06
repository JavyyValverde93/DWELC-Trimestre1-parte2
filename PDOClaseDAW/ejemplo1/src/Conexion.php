<?php

namespace Clases;

use PDO;
use PDOException;

class Conexion
{
    protected static $conexion;
    
    public function __construct()
    {
        if (self::$conexion == null) {
            self::crearConexion();
        }
    }
    private static function crearConexion()
    {
        $ops=parse_ini_file("../config.ini");
        $user = $ops["usuario"];  //Usuario de la base de datos
        $pass = $ops["pass"];  //Contraseña de ese usuario
        $base = $ops["base"];    //Base de datos a la que me quiero conextar
        //Creo el DSN
        $dsn = "mysql:host=localhost;dbname=$base;charset=utf8mb4";   //el host es localhost; database nombre es $base y charset para mostrar la ñ
        try {
            self::$conexion = new PDO($dsn, $user, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error al conectar a la BBDD, mensaje: " . $ex->getMessage());
        }
    }
    //------------------------------------------------------------------------
}