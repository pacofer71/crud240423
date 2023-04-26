<?php
namespace Src;
use \PDO;
use \PDOException;

class Articulo extends Conexion{
    private int $id;
    private string $nombre;
    private string $imagen;
    private string $disponible;
    private int $category_id;
    private float $precio;

    public function __construct()
    {
        parent::__construct();
    }

    //__________________________________________ CRUD __________________________________________
    public function create(){
        $q="insert into articulos(nombre, imagen, disponible, category_id, precio) values(:n, :i, :d, :ci, :p)";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':i'=>$this->imagen,
                ':d'=>$this->disponible,
                ':ci'=>$this->category_id,
                ':p'=>$this->precio
            ]);
        }catch(PDOException $ex){
            die("Error al crear articulo: ".$ex->getMessage());
        }
        parent::$con=null;
    }
    public static function readParcial(){
        parent::crearConexion();
        $q="select nombre, id, disponible, precio from articulos";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hay articulos: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function detalleArticulo(){
        $q="select articulos.*, categorias.nombre as nomcat from articulos, categorias where category_id=categorias.id AND
        articulos.id=:i";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error en detalle articulo: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function delete(){
        $q="delete from articulos where id=:i";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error en borrar articulo: ".$ex->getMessage());
        }
        parent::$con=null;
        //die("BORRANDO: ".$this->id);
    }
    public function getImagen(): String{
        $q="select imagen from articulos where id=:i";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error en devolver imagen articulo: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->fetch(PDO::FETCH_OBJ)->imagen;
    } 

    public function update($id){
        $q="update articulos set imagen=:i, precio=:p, nombre=:n, disponible=:d, category_id=:ci where id=:id";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':i'=>$this->imagen,
                ':d'=>$this->disponible,
                ':ci'=>$this->category_id,
                ':p'=>$this->precio,
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al editar articulo: ".$ex->getMessage());
        }
        parent::$con=null;
    }
    //_________________________________________ OTROS METODOS __________________________________
    public static function existeNombre($nombre, $id=null): bool{
        parent::crearConexion();
        $q=($id==null) ? "select id from articulos where nombre=:n" : "select id from articulos where nombre=:n AND id!=:i";
        $stmt=parent::$con->prepare($q);
        $opciones=($id==null) ? [':n'=>$nombre] : [':n'=>$nombre, ':i'=>$id]; 
       
        try{
            $stmt->execute($opciones);
        }catch(PDOException $ex){
            die("Error en existe nombre: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->rowCount();

    }
    public static function existeId($id): bool{
        parent::crearConexion();
        $q="select id from articulos where id=:i";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error en existe ID: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->rowCount();

    }

    //__________________________________________ FAKER __________________________________________
    public static function crearArticulos(int $cantidad){
        if(self::hayArticulos()) return;
        $categorias=Categoria::devolverCategoryId();
        $faker= \Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        for($i=0; $i<$cantidad; $i++){
            $imagen="/img/".$faker->picsum('/xampp/htdocs/crud190423/public/img/', 640, 480, false);
            (new Articulo)
            ->setNombre(ucfirst($faker->unique()->words(3, true)))
            ->setImagen($imagen)
            ->setDisponible($faker->randomElements(["SI", "NO"])[0])
            ->setCategory_id($faker->randomElements($categorias)[0])
            ->setPrecio($faker->randomFloat(2, 10, 9999))
            ->create();

        }
    }

    private static function hayArticulos(): bool{
        parent::crearConexion();
        $q="select id from articulos";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hay articulos: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->rowCount();

    } 

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Set the value of disponible
     *
     * @return  self
     */ 
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }
}