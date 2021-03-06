<?php

namespace Clases;

require "../vendor/autoload.php";

use PDO;
use PDOException;
use Faker\Factory;
use Clases\Autores;

class Libros extends Conexion
{
    private $id_libro;
    private $titulo;
    private $isbn;
    private $autor;
    private $portada;

    public function __construct()
    {
        parent::__construct();
    }

    //Setters ---------------------------------------------

    /**
     * Set the value of id_libro
     *
     * @return  self
     */
    public function setId_libro($id_libro)
    {
        $this->id_libro = $id_libro;

        return $this;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Set the value of autor
     *
     * @return  self
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Set the value of portada
     *
     * @return  self
     */
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }

    //CRUD------------------------------------------------
    public function create() {
        $c1="insert into libros(titulo,autor,isbn,portada) values (:t, :a, :i, :p)";
        $c2="insert into libros(titulo,autor,isbn) values (:t, :a, :i)";
        $array=[':t'=>$this->titulo, ':a'=>$this->autor, ':i'=>$this->isbn];
        if (isset($this->portada)) {
            $array[':p']=$this->portada;
            $stmt=parent::$conexion->prepare($c1);
        } else {
            $stmt=parent::$conexion->prepare($c2);
        }
        try {
            $stmt->execute($array);
        } catch (PDOException $ex) {
            die("Error al crear el libro".$ex->getMessage());
        }
    }
    public function read()
    {
    }
    public function update()
    {
    }
    public function delete()
    {
    }
    //Otros metodos -----------------------------------------------
    public function totalReg()
    {
        $con = "select count(*) as total from libros";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Eroro al recuperar el total de libros, " . $ex->getMessage());
        }
        // return $stmt->fetch(PDO::FETCH_OBJ)->total;
        $fila = $stmt->fetch(PDO::FETCH_OBJ)->total;
        return $fila;
    }
    //Rellenando la tabla ------------------------------
    public function rellenarLibros($cant)
    {
        $autor = new Autores();
        $id = $autor->devolverIDs();
        if ($this->totalReg() == 0) {
            $faker = Factory::create('es_ES');
            for ($i = 0; $i < $cant; $i++) {
                $titulo = $faker->sentence($nbWords = 6, $variableNbWords = true);
                $isbn = $faker->unique()->isbn13;
                $autor = $id[$faker->numberBetween($min = 0, $max = count($id)-1)];
                $inser = "insert into libros(titulo, isbn, autor) values(:t, :i, :a)";
                $stmt = parent::$conexion->prepare($inser);
                try {
                    $stmt->execute([
                        ':t' => $titulo,
                        ':i' => $isbn,
                        ':a' => $autor
                    ]);
                } catch (PDOException $ex) {
                    die("Error al crear los libros de prueba: " . $ex->getMessage());
                }
            }
        }
    }
    //-------------------------------------------------
    public function recuperarTodos($inf, $cant) {
        $con = "select libros.*, autores.nombre, autores.apellidos from libros, autores where autor=id_autor order by autores.apellidos, titulo limit $inf, $cant";
        $stmt=parent::$conexion->prepare($con);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar los libros de prueba: ". $ex->getMessage());
        }
        return $stmt;
    }
    //----------------- Métodos para la 
}
