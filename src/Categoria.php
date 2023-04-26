<?php
namespace Src;
use \PDO;
use PDOException;
class Categoria extends Conexion{
    private int $id;
    private string $nombre;
    private string $descripcion;

    public function __construct()
    {
        parent::__construct();
    }

    //______________________________________ CRUD _______________________________________________
    public function create(){
        $q="insert into categorias(nombre, descripcion) values(:n, :d)";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':d'=>$this->descripcion,
            ]);
        }catch(PDOException $ex){
            die("Error al crear categoria: ".$ex->getMessage());
        }
        parent::$con=null;
    }
    public static function read(){
        parent::crearConexion();
        $q="select id, nombre from categorias order by nombre";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al devolver categoriaa: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //________________________________ FAKER _______________________________________________________
    private static function hayCategorias(): bool{
        parent::crearConexion();
        $q="select id from categorias";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hay categorias: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->rowCount();

    }
    public static function crearCategorias(int $cantidad){
        if(self::hayCategorias()) return;
        $faker = \Faker\Factory::create('es_ES');
        for($i=0; $i<$cantidad; $i++){
            (new Categoria)->setNombre(ucfirst($faker->unique()->words(random_int(2,3), true)))
            ->setDescripcion($faker->text)
            ->create();
        }
    }

    public static function devolverCategoryId(): array{
        parent::crearConexion();
        $q="select id from categorias";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en devolver categorias: ".$ex->getMessage());
        }
        parent::$con=null;
        $cat=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $cat[]=$fila->id;
        }
        //var_dump($cat);
        //die();
        return $cat;

    }


    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}